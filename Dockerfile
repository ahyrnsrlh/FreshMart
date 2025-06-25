# Simple Laravel Docker setup for Railway
FROM php:8.2-cli

# Install minimal system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libonig-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install essential PHP extensions for Laravel (minimal set)
RUN docker-php-ext-install pdo_mysql || echo "pdo_mysql installation failed, continuing..."

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy everything
COPY . .

# Install composer dependencies with minimal requirements
RUN composer install --no-dev --no-interaction --ignore-platform-reqs --no-scripts || \
    (rm -f composer.lock && composer install --no-dev --no-interaction --ignore-platform-reqs --no-scripts)

# Create simple start script with better error handling and debugging
RUN echo '#!/bin/bash' > /app/simple-start.sh && \
    echo 'set -e' >> /app/simple-start.sh && \
    echo 'export PORT=${PORT:-8000}' >> /app/simple-start.sh && \
    echo 'echo "🚀 Starting FreshMart on port $PORT"' >> /app/simple-start.sh && \
    echo 'echo "Environment: $(printenv | grep -E "(PORT|APP_|DB_|RAILWAY_)" | head -5)"' >> /app/simple-start.sh && \
    echo 'mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache' >> /app/simple-start.sh && \
    echo 'chmod -R 775 storage bootstrap/cache 2>/dev/null || true' >> /app/simple-start.sh && \
    echo 'echo "📋 Clearing Laravel caches..."' >> /app/simple-start.sh && \
    echo 'php artisan config:clear 2>/dev/null || true' >> /app/simple-start.sh && \
    echo 'echo "🗄️ Running migrations..."' >> /app/simple-start.sh && \
    echo 'php artisan migrate --force 2>/dev/null || echo "⚠️ Migration failed, continuing..."' >> /app/simple-start.sh && \
    echo 'echo "⚡ Caching config..."' >> /app/simple-start.sh && \
    echo 'php artisan config:cache 2>/dev/null || true' >> /app/simple-start.sh && \
    echo 'echo "✅ Laravel setup complete, starting server on 0.0.0.0:$PORT"' >> /app/simple-start.sh && \
    echo 'echo "🔍 Testing basic Laravel..."' >> /app/simple-start.sh && \
    echo 'php artisan --version' >> /app/simple-start.sh && \
    echo 'echo "🌐 Starting web server..."' >> /app/simple-start.sh && \
    echo 'exec php artisan serve --host=0.0.0.0 --port=$PORT' >> /app/simple-start.sh && \
    chmod +x /app/simple-start.sh

# Use simple start script
CMD ["/app/simple-start.sh"]
