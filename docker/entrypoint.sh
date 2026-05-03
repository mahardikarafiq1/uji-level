#!/bin/sh

# Exit on error
set -e

# Cache configuration, routes, and views for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations if enabled (usually good for Render)
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
nginx -g "daemon off;"
