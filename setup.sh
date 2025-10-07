#!/bin/bash

# Colors untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Setup Laravel Production Server ===${NC}"

# 1. Create directory structure
echo -e "\n${YELLOW}[1/8] Creating directory structure...${NC}"
mkdir -p docker/{nginx/conf.d,php,mysql,redis}

# 2. Copy configuration files
echo -e "${YELLOW}[2/8] Setting up configuration files...${NC}"
# Pastikan semua file config sudah ada di lokasi yang benar

# 3. Set proper permissions
echo -e "${YELLOW}[3/8] Setting permissions...${NC}"
chmod -R 755 storage bootstrap/cache
chmod +x setup.sh

# 4. Install/Update Composer dependencies
echo -e "${YELLOW}[4/8] Installing Composer dependencies...${NC}"
docker run --rm -v $(pwd):/app composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=ext-gd || {
    echo -e "${YELLOW}Note: Using --ignore-platform-req=ext-gd. Extensions will be available in PHP-FPM container.${NC}"
}

# 5. Generate app key jika belum ada
if grep -q "APP_KEY=base64:your-app-key-here" .env 2>/dev/null; then
    echo -e "${YELLOW}[5/8] Generating application key...${NC}"
    docker compose run --rm php php artisan key:generate
else
    echo -e "${GREEN}[5/8] Application key already exists.${NC}"
fi

# 6. Build and start containers
echo -e "${YELLOW}[6/8] Building and starting Docker containers...${NC}"
docker compose down 2>/dev/null || true
docker compose build --no-cache php
docker compose up -d --scale queue-worker=2

# Wait for MySQL to be ready
echo -e "${YELLOW}Waiting for MySQL to be ready...${NC}"
sleep 15

# 7. Run migrations
echo -e "${YELLOW}[7/8] Running database migrations...${NC}"
docker compose exec -T php php artisan migrate --force

# 8. Optimize Laravel for production
echo -e "${YELLOW}[8/8] Optimizing Laravel...${NC}"
docker compose exec -T php php artisan config:cache
docker compose exec -T php php artisan route:cache
docker compose exec -T php php artisan view:cache
docker compose exec -T php php artisan event:cache

# Get server IP
SERVER_IP=$(hostname -I | awk '{print $1}')

echo -e "\n${GREEN}=== Setup Complete! ===${NC}"
echo -e "${GREEN}Your Laravel application is now running at:${NC}"
echo -e "${GREEN}http://${SERVER_IP}${NC}"
echo -e "\n${YELLOW}Useful commands:${NC}"
echo -e "  docker compose ps          - View running containers"
echo -e "  docker compose logs -f     - View logs"
echo -e "  docker compose down        - Stop all containers"
echo -e "  docker compose restart     - Restart all containers"
echo -e "\n${YELLOW}Monitoring:${NC}"
echo -e "  docker stats               - View resource usage"
echo -e "  docker compose exec php php artisan queue:work  - Start queue worker manually"
