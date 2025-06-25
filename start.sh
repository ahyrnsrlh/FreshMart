#!/bin/bash

set -e  # Exit on error

echo "🚀 Starting FreshMart Laravel App..."

# Set environment variables
export PORT=${PORT:-8000}
export APP_ENV=${APP_ENV:-production}

# Wait for database if needed
echo "⏳ Waiting for database..."
php artisan db:show --quiet 2>/dev/null || sleep 5

# Create required directories
mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache

# Set permissions (only if not in Docker or if writable)
if [ -w storage ]; then
    chmod -R 775 storage bootstrap/cache 2>/dev/null || true
fi

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Create storage link if needed
if [ ! -L public/storage ]; then
    php artisan storage:link 2>/dev/null || true
fi

# Cache for production
echo "⚡ Caching configurations..."
php artisan config:cache
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

# Start server
echo "✅ Starting server on 0.0.0.0:$PORT"
exec php artisan serve --host=0.0.0.0 --port=$PORT
