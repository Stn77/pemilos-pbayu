#!/bin/bash

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}    Fix Storage Permission & Database Connection           ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

# Fix 1: Storage Permissions
echo -e "\n${YELLOW}[1/5] Fixing storage permissions...${NC}"

# Fix from host
echo "Fixing permissions from host..."
sudo chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || {
    # If www-data doesn't exist on host, use current user
    sudo chown -R 33:33 storage bootstrap/cache 2>/dev/null || {
        sudo chown -R $USER:$USER storage bootstrap/cache
    }
}
sudo chmod -R 775 storage bootstrap/cache

# Fix from container
echo "Fixing permissions from container..."
docker compose exec -T php chown -R www-data:www-data storage bootstrap/cache
docker compose exec -T php chmod -R 775 storage bootstrap/cache

# Create log file if not exists
docker compose exec -T php touch storage/logs/laravel.log
docker compose exec -T php chown www-data:www-data storage/logs/laravel.log
docker compose exec -T php chmod 664 storage/logs/laravel.log

echo -e "${GREEN}✓ Storage permissions fixed${NC}"

# Fix 2: Database Connection
echo -e "\n${YELLOW}[2/5] Checking database configuration...${NC}"

# Show current .env DB settings
echo -e "\n${BLUE}Current .env database settings:${NC}"
grep -E "^DB_" .env

# Check what's in docker compose.yml
echo -e "\n${BLUE}docker compose MySQL settings:${NC}"
grep -A 5 "MYSQL_" docker compose.yml | grep -E "MYSQL_DATABASE|MYSQL_USER|MYSQL_PASSWORD"

echo -e "\n${YELLOW}[3/5] Testing MySQL connection...${NC}"

# Get credentials from docker compose
DB_ROOT_PASS="root_password"
DB_NAME="laravel"
DB_USER="laravel"
DB_PASS="laravel_password"

# Wait for MySQL
echo "Waiting for MySQL..."
sleep 3

# Test root connection
if docker compose exec -T mysql mysql -u root -p${DB_ROOT_PASS} -e "SELECT 1;" 2>/dev/null | grep -q "1"; then
    echo -e "${GREEN}✓ MySQL root access OK${NC}"
    
    # Check if database exists
    echo -e "\n${YELLOW}Checking database and user...${NC}"
    
    # Show existing databases
    echo "Existing databases:"
    docker compose exec -T mysql mysql -u root -p${DB_ROOT_PASS} -e "SHOW DATABASES;" 2>/dev/null
    
    # Recreate user with correct permissions
    echo -e "\n${YELLOW}Recreating database user...${NC}"
    docker compose exec -T mysql mysql -u root -p${DB_ROOT_PASS} <<EOF
DROP USER IF EXISTS '${DB_USER}'@'%';
CREATE USER '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'%';
FLUSH PRIVILEGES;
SELECT User, Host FROM mysql.user WHERE User='${DB_USER}';
EOF
    
    echo -e "${GREEN}✓ Database user recreated${NC}"
    
else
    echo -e "${RED}✗ Cannot connect to MySQL as root${NC}"
    echo "Checking MySQL logs..."
    docker compose logs mysql --tail=20
fi

# Fix 3: Update .env with correct credentials
echo -e "\n${YELLOW}[4/5] Updating .env file...${NC}"

# Backup .env
cp .env .env.backup.$(date +%Y%m%d_%H%M%S)

# Update .env
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
sed -i 's/^DB_HOST=.*/DB_HOST=mysql/' .env
sed -i 's/^DB_PORT=.*/DB_PORT=3306/' .env
sed -i 's/^DB_DATABASE=.*/DB_DATABASE=laravel/' .env
sed -i 's/^DB_USERNAME=.*/DB_USERNAME=laravel/' .env
sed -i 's/^DB_PASSWORD=.*/DB_PASSWORD=laravel_password/' .env

echo -e "${GREEN}✓ .env updated${NC}"

echo -e "\n${BLUE}Updated .env database settings:${NC}"
grep -E "^DB_" .env

# Clear config cache
echo -e "\n${YELLOW}Clearing configuration cache...${NC}"
docker compose exec -T php php artisan config:clear

# Fix 4: Test connection from Laravel
echo -e "\n${YELLOW}[5/5] Testing Laravel database connection...${NC}"
docker compose exec -T php php artisan tinker --execute="
try {
    DB::connection()->getPdo();
    echo 'Database connection: SUCCESS\n';
    echo 'Database name: ' . DB::connection()->getDatabaseName() . '\n';
} catch (Exception \$e) {
    echo 'Database connection: FAILED\n';
    echo 'Error: ' . \$e->getMessage() . '\n';
}
" 2>&1

echo -e "\n${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}              Verification                                  ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

# Verify storage permissions
echo -e "\n${BLUE}Storage permissions:${NC}"
ls -la storage/logs/

# Try to write to log
echo -e "\n${BLUE}Testing log write:${NC}"
docker compose exec -T php php -r "file_put_contents('/var/www/html/storage/logs/laravel.log', 'Test write at ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);" && {
    echo -e "${GREEN}✓ Can write to log file${NC}"
} || {
    echo -e "${RED}✗ Cannot write to log file${NC}"
}

# Try migration again
echo -e "\n${YELLOW}Attempting migration...${NC}"
docker compose exec -T php php artisan migrate --force 2>&1 | head -20

echo -e "\n${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}              Done!                                         ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

SERVER_IP=$(hostname -I | awk '{print $1}')

echo -e "\n${YELLOW}Next steps:${NC}"
echo "1. Test application: http://${SERVER_IP}"
echo "2. Check logs: tail -f storage/logs/laravel.log"
echo "3. If still error, run: docker compose logs -f php"
echo ""
echo "${YELLOW}If database connection still fails:${NC}"
echo "  docker compose restart mysql php"
echo "  docker compose exec php php artisan migrate --force"
