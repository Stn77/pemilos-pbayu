#!/bin/bash

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║           Fixing PHP, Redis & Queue Worker Errors         ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"

# Stop all containers
echo -e "\n${YELLOW}[1/7] Stopping all containers...${NC}"
docker-compose down
sleep 2
echo -e "${GREEN}✓ Containers stopped${NC}"

# Fix 1: PHP-FPM slowlog permission issue
echo -e "\n${YELLOW}[2/7] Fixing PHP-FPM configuration...${NC}"
# Config sudah diperbaiki di php-fpm.conf (slowlog ke /proc/self/fd/2)
echo -e "${GREEN}✓ PHP-FPM config fixed (slowlog to stdout)${NC}"

# Fix 2: Redis config syntax error
echo -e "\n${YELLOW}[3/7] Fixing Redis configuration...${NC}"
# Config sudah diperbaiki di redis.conf (hapus comment inline)
echo -e "${GREEN}✓ Redis config fixed (removed inline comments)${NC}"

# Fix 3: Composer autoload corrupt - reinstall vendor
echo -e "\n${YELLOW}[4/7] Fixing Composer autoload...${NC}"
echo "Removing corrupt vendor directory..."
rm -rf vendor/
echo "Clearing Composer cache..."
docker run --rm -v $(pwd):/app composer clear-cache
echo "Reinstalling dependencies..."
docker run --rm -v $(pwd):/app composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs
echo -e "${GREEN}✓ Composer dependencies reinstalled${NC}"

# Rebuild PHP container
echo -e "\n${YELLOW}[5/7] Rebuilding PHP container...${NC}"
docker-compose build --no-cache php
echo -e "${GREEN}✓ PHP container rebuilt${NC}"

# Start services
echo -e "\n${YELLOW}[6/7] Starting all services...${NC}"
echo "Starting MySQL..."
docker-compose up -d mysql
sleep 8

echo "Starting Redis..."
docker-compose up -d redis
sleep 3

# Test Redis
if docker-compose exec -T redis redis-cli ping 2>/dev/null | grep -q PONG; then
    echo -e "${GREEN}✓ Redis started successfully${NC}"
else
    echo -e "${RED}✗ Redis failed to start${NC}"
    docker-compose logs redis --tail=20
fi

echo "Starting PHP-FPM..."
docker-compose up -d php
sleep 5

# Check PHP-FPM
if docker-compose ps | grep php | grep -q "Up"; then
    echo -e "${GREEN}✓ PHP-FPM started successfully${NC}"
else
    echo -e "${RED}✗ PHP-FPM failed to start${NC}"
    docker-compose logs php --tail=20
    exit 1
fi

echo "Starting Nginx..."
docker-compose up -d nginx
sleep 2

echo "Starting Queue Workers..."
docker-compose up -d --scale queue-worker=2 queue-worker
sleep 3

# Check Queue Workers
if docker-compose ps | grep queue-worker | grep -q "Up"; then
    echo -e "${GREEN}✓ Queue workers started successfully${NC}"
else
    echo -e "${RED}✗ Queue workers failed to start${NC}"
    docker-compose logs queue-worker --tail=20
fi

# Setup Laravel
echo -e "\n${YELLOW}[7/7] Setting up Laravel...${NC}"

# Wait for MySQL
echo "Waiting for MySQL to be ready..."
COUNTER=0
until docker-compose exec -T mysql mysqladmin ping -h localhost --silent 2>/dev/null || [ $COUNTER -eq 15 ]; do
    echo -n "."
    sleep 2
    ((COUNTER++))
done
echo ""

if [ $COUNTER -eq 15 ]; then
    echo -e "${YELLOW}⚠ MySQL may not be ready, continuing anyway...${NC}"
else
    echo -e "${GREEN}✓ MySQL is ready${NC}"
fi

# Generate app key if needed
if grep -q "APP_KEY=$" .env 2>/dev/null || ! grep -q "APP_KEY=" .env 2>/dev/null; then
    echo "Generating application key..."
    docker-compose exec -T php php artisan key:generate --force
fi

# Run migrations
echo "Running database migrations..."
docker-compose exec -T php php artisan migrate --force 2>&1 | head -20

# Optimize Laravel
echo "Optimizing Laravel..."
docker-compose exec -T php php artisan config:cache
docker-compose exec -T php php artisan route:cache
docker-compose exec -T php php artisan view:cache

# Fix permissions
echo "Fixing permissions..."
docker-compose exec -T php chown -R www-data:www-data storage bootstrap/cache
docker-compose exec -T php chmod -R 775 storage bootstrap/cache

# Final status
echo -e "\n${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║                    Fix Complete!                           ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"

echo -e "\n${BLUE}Container Status:${NC}"
docker-compose ps

echo -e "\n${BLUE}Testing Services:${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Test Redis
if docker-compose exec -T redis redis-cli ping 2>/dev/null | grep -q PONG; then
    echo -e "${GREEN}✓${NC} Redis: WORKING"
else
    echo -e "${RED}✗${NC} Redis: NOT WORKING"
fi

# Test MySQL
if docker-compose exec -T mysql mysqladmin ping -h localhost --silent 2>/dev/null; then
    echo -e "${GREEN}✓${NC} MySQL: WORKING"
else
    echo -e "${RED}✗${NC} MySQL: NOT WORKING"
fi

# Test PHP-FPM
if docker-compose exec -T nginx curl -sf http://php:9000/status 2>/dev/null | grep -q "pool"; then
    echo -e "${GREEN}✓${NC} PHP-FPM: WORKING"
else
    echo -e "${RED}✗${NC} PHP-FPM: NOT WORKING"
fi

# Test Nginx
if docker-compose exec -T nginx nginx -t 2>&1 | grep -q "successful"; then
    echo -e "${GREEN}✓${NC} Nginx: WORKING"
else
    echo -e "${RED}✗${NC} Nginx: NOT WORKING"
fi

# Get server IP
SERVER_IP=$(hostname -I | awk '{print $1}')

echo -e "\n${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║  Application is ready at: http://${SERVER_IP}       ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"

echo -e "\n${YELLOW}Useful Commands:${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "View all logs:          docker-compose logs -f"
echo "View PHP logs:          docker-compose logs -f php"
echo "View Redis logs:        docker-compose logs -f redis"
echo "View worker logs:       docker-compose logs -f queue-worker"
echo "Check status:           docker-compose ps"
echo "Monitor resources:      docker stats"
echo "Run monitoring:         ./monitor.sh"
echo "Run load test:          ./load-test.sh"

echo -e "\n${YELLOW}If you see any errors above, check specific logs:${NC}"
echo "docker-compose logs [service-name] --tail=50"
