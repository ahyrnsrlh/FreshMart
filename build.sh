#!/bin/bash

# Railway Build Script for FreshMart
echo "🚀 Starting FreshMart build process..."

# Set memory limits
export NODE_OPTIONS="--max-old-space-size=1024"
export COMPOSER_MEMORY_LIMIT=1G

# Clear any existing caches
echo "📁 Clearing caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# Install PHP dependencies with optimizations
echo "📦 Installing PHP dependencies..."
composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --no-scripts

# Install Node dependencies
echo "🔧 Installing Node dependencies..."
npm ci --production=false --silent

# Build assets
echo "🎨 Building assets..."
npm run build

# Generate optimized caches
echo "⚡ Generating optimized caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage bootstrap/cache

# Verify build
echo "✅ Build verification..."
if [ -f "public/build/manifest.json" ]; then
    echo "✓ Assets built successfully"
else
    echo "❌ Asset build failed"
    exit 1
fi

echo "🎉 Build completed successfully!"
