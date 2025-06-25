#!/bin/bash

# Railway Deployment Script for FreshMart Laravel App
# This script handles the complete deployment process

set -e  # Exit on any error

echo "🚀 Starting FreshMart deployment on Railway..."

# Set environment variables
export PORT=${PORT:-8000}
export APP_ENV=${APP_ENV:-production}

echo "📋 Environment Check:"
echo "- PORT: $PORT"
echo "- APP_ENV: $APP_ENV"
echo "- PHP Version: $(php --version | head -n 1)"
echo "- Node Version: $(node --version 2>/dev/null || echo 'Not installed')"

# Create required directories with proper permissions
echo "📁 Creating directories..."
mkdir -p storage/{logs,framework/{cache,sessions,views,testing}}
mkdir -p bootstrap/cache
mkdir -p public/storage

# Set correct permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 755 public

# Clear all caches to start fresh
echo "🧹 Clearing caches..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Install composer dependencies if needed
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installing composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# Run database migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Create storage symlink if it doesn't exist
if [ ! -L public/storage ]; then
    echo "🔗 Creating storage symlink..."
    php artisan storage:link
fi

# Cache configurations for production performance
echo "⚡ Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
echo "🔧 Optimizing autoloader..."
composer dump-autoload --optimize

# Test database connection
echo "🔍 Testing database connection..."
php artisan db:show 2>/dev/null || echo "⚠️  Database connection test failed - continuing anyway"

# Test health endpoint
echo "❤️  Testing health endpoint..."
timeout 5 php artisan serve --host=127.0.0.1 --port=8080 &
SERVER_PID=$!
sleep 3
curl -f http://127.0.0.1:8080/health 2>/dev/null || echo "⚠️  Health check failed - continuing anyway"
kill $SERVER_PID 2>/dev/null || true

echo "✅ Deployment preparation complete!"
echo "🚀 Starting Laravel server on 0.0.0.0:$PORT"

# Start the server
exec php artisan serve --host=0.0.0.0 --port=$PORT
