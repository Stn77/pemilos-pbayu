#!/bin/bash

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

clear

echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║     Laravel Production Server Monitoring Dashboard        ║${NC}"
echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"

# Function to get container stats
get_container_stats() {
    local container=$1
    docker stats $container --no-stream --format "table {{.CPUPerc}}\t{{.MemUsage}}\t{{.NetIO}}" | tail -n 1
}

# Function to get PHP-FPM status
get_phpfpm_status() {
    docker-compose exec -T nginx curl -s http://php:9000/status 2>/dev/null
}

# Function to get Redis stats
get_redis_stats() {
    docker-compose exec -T redis redis-cli INFO stats 2>/dev/null | grep -E "instantaneous_ops_per_sec|total_commands_processed"
}

# Function to get MySQL stats
get_mysql_stats() {
    docker-compose exec -T mysql mysql -u laravel -plaravel_password -e "SHOW STATUS LIKE 'Threads_connected';" 2>/dev/null | tail -n 1
}

# Main monitoring loop
while true; do
    clear
    echo -e "${GREEN}╔════════════════════════════════════════════════════════════╗${NC}"
    echo -e "${GREEN}║          Server Monitoring - $(date '+%Y-%m-%d %H:%M:%S')         ║${NC}"
    echo -e "${GREEN}╚════════════════════════════════════════════════════════════╝${NC}"
    
    echo -e "\n${BLUE}[1] Docker Container Status${NC}"
    echo "─────────────────────────────────────────────────────────────"
    docker-compose ps
    
    echo -e "\n${BLUE}[2] Container Resource Usage${NC}"
    echo "─────────────────────────────────────────────────────────────"
    docker stats --no-stream --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.MemPerc}}\t{{.NetIO}}\t{{.BlockIO}}"
    
    echo -e "\n${BLUE}[3] PHP-FPM Pool Status${NC}"
    echo "─────────────────────────────────────────────────────────────"
    phpfpm_status=$(docker-compose exec -T nginx curl -s http://php:9000/status 2>/dev/null)
    if [ $? -eq 0 ]; then
        echo "$phpfpm_status" | grep -E "pool|process manager|start time|accepted conn|listen queue|idle processes|active processes|total processes"
    else
        echo -e "${RED}Cannot connect to PHP-FPM${NC}"
    fi
    
    echo -e "\n${BLUE}[4] Redis Statistics${NC}"
    echo "─────────────────────────────────────────────────────────────"
    redis_stats=$(docker-compose exec -T redis redis-cli INFO 2>/dev/null)
    if [ $? -eq 0 ]; then
        echo "$redis_stats" | grep -E "used_memory_human|connected_clients|instantaneous_ops_per_sec|total_commands_processed" | head -5
    else
        echo -e "${RED}Cannot connect to Redis${NC}"
    fi
    
    echo -e "\n${BLUE}[5] MySQL Connections${NC}"
    echo "─────────────────────────────────────────────────────────────"
    mysql_conn=$(docker-compose exec -T mysql mysql -u laravel -plaravel_password -e "SHOW STATUS LIKE 'Threads_connected';" 2>/dev/null | tail -n 1 | awk '{print $2}')
    if [ ! -z "$mysql_conn" ]; then
        echo "Active MySQL Connections: $mysql_conn"
    else
        echo -e "${RED}Cannot connect to MySQL${NC}"
    fi
    
    echo -e "\n${BLUE}[6] Nginx Access Log (Last 5 requests)${NC}"
    echo "─────────────────────────────────────────────────────────────"
    docker-compose logs --tail=5 nginx 2>/dev/null | grep -v "Attaching"
    
    echo -e "\n${BLUE}[7] System Resources${NC}"
    echo "─────────────────────────────────────────────────────────────"
    echo "CPU Load Average: $(uptime | awk -F'load average:' '{print $2}')"
    echo "Memory Usage:"
    free -h | grep -E "Mem|Swap"
    echo "Disk Usage:"
    df -h / | tail -n 1
    
    echo -e "\n${YELLOW}Press Ctrl+C to exit. Refreshing in 5 seconds...${NC}"
    sleep 5
done
