#!/bin/bash
# Manual build script untuk Railway

echo "🚀 Building FreshMart..."

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction
npm ci --silent

# Build assets
npm run build

# Laravel optimizations
php artisan storage:link --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completed!"
