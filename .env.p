
APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=http://your-server-ip

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel_password

# Broadcasting
BROADCAST_DRIVER=redis

# Cache
CACHE_DRIVER=redis
CACHE_PREFIX=laravel_cache

# Filesystem
FILESYSTEM_DISK=local

# Queue
QUEUE_CONNECTION=redis

# Session
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=false

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=phpredis

# Redis untuk cache
REDIS_CACHE_DB=1

# Redis untuk session
REDIS_SESSION_DB=2

# Redis untuk queue
REDIS_QUEUE_DB=3
