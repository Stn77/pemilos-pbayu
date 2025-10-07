#!/bin/bash

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}         Fixing PHP-FPM Slowlog Permission Error            ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

# Stop PHP container
echo -e "\n${YELLOW}[1/4] Stopping PHP container...${NC}"
docker compose stop php
sleep 2

# Update php-fpm.conf file
echo -e "\n${YELLOW}[2/4] Updating php-fpm.conf...${NC}"
cat > docker/php/php-fpm.conf <<'EOF'
[www]
user = www-data
group = www-data
listen = 9000

; Process management - Dynamic untuk handle spike traffic
pm = dynamic
pm.max_children = 100
pm.start_servers = 20
pm.min_spare_servers = 15
pm.max_spare_servers = 35
pm.max_requests = 500
pm.process_idle_timeout = 10s

; Status page untuk monitoring
pm.status_path = /status

; Connection timeouts
request_terminate_timeout = 300
request_slowlog_timeout = 10s

; Logging - Output to stdout/stderr (Docker logs)
access.log = /proc/self/fd/2
slowlog = /proc/self/fd/2

; Catch workers output
catch_workers_output = yes
decorate_workers_output = no

; Clear environment
clear_env = no

; Security
security.limit_extensions = .php

; Environment variables
env[HOSTNAME] = $HOSTNAME
env[PATH] = /usr/local/bin:/usr/bin:/bin
env[TMP] = /tmp
env[TMPDIR] = /tmp
env[TEMP] = /tmp
EOF

echo -e "${GREEN}✓ php-fpm.conf updated${NC}"

# Rebuild PHP container
echo -e "\n${YELLOW}[3/4] Rebuilding PHP container...${NC}"
docker compose build --no-cache php
echo -e "${GREEN}✓ PHP container rebuilt${NC}"

# Start PHP container
echo -e "\n${YELLOW}[4/4] Starting PHP container...${NC}"
docker compose up -d php
sleep 5

# Check status
echo -e "\n${BLUE}Checking PHP-FPM status...${NC}"
if docker compose ps | grep php | grep -q "Up"; then
    echo -e "${GREEN}✓ PHP-FPM is now running!${NC}"

    # Test PHP-FPM
    echo -e "\n${YELLOW}Testing PHP-FPM...${NC}"
    docker compose exec -T php php -v

    echo -e "\n${YELLOW}Testing PHP-FPM pool status...${NC}"
    docker compose up -d nginx
    sleep 2
    docker compose exec -T nginx curl -s http://php:9000/status 2>/dev/null || echo "Status page not available yet"

else
    echo -e "${RED}✗ PHP-FPM still failed to start${NC}"
    echo -e "\n${YELLOW}Latest logs:${NC}"
    docker compose logs php --tail=20
    exit 1
fi

# Start other services
echo -e "\n${YELLOW}Starting remaining services...${NC}"
docker compose up -d nginx queue-worker

echo -e "\n${GREEN}════════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}                    Fix Complete!                           ${NC}"
echo -e "${GREEN}════════════════════════════════════════════════════════════${NC}"

echo -e "\n${BLUE}All Services Status:${NC}"
docker compose ps

SERVER_IP=$(hostname -I | awk '{print $1}')
echo -e "\n${GREEN}Application URL: http://${SERVER_IP}${NC}"

echo -e "\n${YELLOW}To view logs:${NC}"
echo "docker compose logs -f php"
