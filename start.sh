#!/bin/bash

echo "🚀 Starting FreshMart..."

# Create required directories
mkdir -p storage/logs
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Run migrations
php artisan migrate --force

# Cache config for production
php artisan config:cache

# Start server
echo "✅ Starting server on port ${PORT:-8000}"
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
