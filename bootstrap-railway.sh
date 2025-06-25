#!/bin/bash

echo "🚀 Starting FreshMart Laravel App..."

# Clear all Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Create storage directories if not exist
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

# Set proper permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Check if APP_KEY exists, if not generate one
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "🔑 Generating APP_KEY..."
    php artisan key:generate --force
fi

# Test database connection
echo "🗄️ Testing database connection..."
php artisan migrate:status || {
    echo "❌ Database connection failed!"
    exit 1
}

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link || echo "Storage link already exists"

# Cache for production (only if successful)
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Bootstrap completed successfully!"

# Start the server
echo "🌐 Starting Laravel server..."
echo "Port: ${PORT:-8000}"
echo "Host: 0.0.0.0"

# Use Railway's assigned port
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
