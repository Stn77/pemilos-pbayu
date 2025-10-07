#!/bin/bash

# Script untuk memperbaiki error setup

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${GREEN}=== Fixing Setup Issues ===${NC}"

# 1. Stop dan remove containers yang ada
echo -e "\n${YELLOW}[1/5] Stopping existing containers...${NC}"
docker compose down 2>/dev/null || true
docker stop $(docker ps -aq) 2>/dev/null || true
docker rm $(docker ps -aq) 2>/dev/null || true

# 2. Rebuild PHP container dengan GD extension
echo -e "\n${YELLOW}[2/5] Rebuilding PHP container with all extensions...${NC}"
docker compose build --no-cache php

# 3. Start containers dengan scale untuk queue workers
echo -e "\n${YELLOW}[3/5] Starting all containers...${NC}"
docker compose up -d --scale queue-worker=2

# Wait for services to be ready
echo -e "\n${YELLOW}[4/5] Waiting for services to be ready...${NC}"
sleep 10

# Verify MySQL is ready
echo "Waiting for MySQL..."
until docker compose exec -T mysql mysqladmin ping -h localhost --silent 2>/dev/null; do
    echo -n "."
    sleep 2
done
echo -e "${GREEN}MySQL is ready!${NC}"

# 4. Install Composer dependencies inside PHP container
echo -e "\n${YELLOW}[5/5] Installing Composer dependencies in PHP container...${NC}"
docker compose exec -T php composer install --no-dev --optimize-autoloader --no-interaction

# Verify GD extension
echo -e "\n${YELLOW}Verifying PHP extensions...${NC}"
docker compose exec -T php php -m | grep -E "gd|redis|opcache|zip"

# Run migrations
echo -e "\n${YELLOW}Running database migrations...${NC}"
docker compose exec -T php php artisan migrate --force

# Optimize Laravel
echo -e "\n${YELLOW}Optimizing Laravel...${NC}"
docker compose exec -T php php artisan config:cache
docker compose exec -T php php artisan route:cache
docker compose exec -T php php artisan view:cache

# Set permissions
echo -e "\n${YELLOW}Setting correct permissions...${NC}"
docker compose exec -T php chown -R www-data:www-data storage bootstrap/cache
docker compose exec -T php chmod -R 775 storage bootstrap/cache

# Get server IP
SERVER_IP=$(hostname -I | awk '{print $1}')

echo -e "\n${GREEN}=== Setup Fixed Successfully! ===${NC}"
echo -e "${GREEN}Application is running at: http://${SERVER_IP}${NC}"
echo ""
echo -e "${YELLOW}Container Status:${NC}"
docker compose ps
echo ""
echo -e "${YELLOW}To monitor: ./monitor.sh${NC}"
echo -e "${YELLOW}To test load: ./load-test.sh${NC}"
