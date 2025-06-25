# Simple Laravel Docker setup for Railway
FROM php:8.2-cli

# Install minimal system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libonig-dev \
    netcat-traditional \
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

# Create comprehensive start script with maximum debugging and port verification
RUN echo '#!/bin/bash' > /app/simple-start.sh && \
    echo 'set -x' >> /app/simple-start.sh && \
    echo 'export PORT=${PORT:-8000}' >> /app/simple-start.sh && \
    echo 'echo "🚀 FreshMart Starting on port: $PORT"' >> /app/simple-start.sh && \
    echo 'echo "🌍 Environment variables:"' >> /app/simple-start.sh && \
    echo 'printenv | grep -E "(PORT|RAILWAY_)" | head -10' >> /app/simple-start.sh && \
    echo 'echo "📋 Current directory: $(pwd)"' >> /app/simple-start.sh && \
    echo 'echo "📁 Key files check:"' >> /app/simple-start.sh && \
    echo 'ls -la artisan public/index.php bootstrap/app.php || true' >> /app/simple-start.sh && \
    echo 'echo "🔧 PHP Version:"' >> /app/simple-start.sh && \
    echo 'php --version' >> /app/simple-start.sh && \
    echo 'echo "📦 Creating directories..."' >> /app/simple-start.sh && \
    echo 'mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache' >> /app/simple-start.sh && \
    echo 'chmod -R 777 storage bootstrap/cache 2>/dev/null || true' >> /app/simple-start.sh && \
    echo 'echo "🧹 Laravel commands..."' >> /app/simple-start.sh && \
    echo 'php artisan --version || echo "Artisan failed"' >> /app/simple-start.sh && \
    echo 'php artisan config:clear 2>/dev/null || echo "Config clear failed"' >> /app/simple-start.sh && \
    echo 'echo "🔍 Port availability check:"' >> /app/simple-start.sh && \
    echo 'netstat -ln | grep ":$PORT " || echo "Port $PORT is available"' >> /app/simple-start.sh && \
    echo 'echo "🌐 Starting server on 0.0.0.0:$PORT"' >> /app/simple-start.sh && \
    echo 'php artisan serve --host=0.0.0.0 --port=$PORT &' >> /app/simple-start.sh && \
    echo 'SERVER_PID=$!' >> /app/simple-start.sh && \
    echo 'echo "🔥 Server started with PID: $SERVER_PID"' >> /app/simple-start.sh && \
    echo 'sleep 3' >> /app/simple-start.sh && \
    echo 'echo "🔍 Port check after server start:"' >> /app/simple-start.sh && \
    echo 'netstat -ln | grep ":$PORT " || echo "❌ Server not listening on port $PORT"' >> /app/simple-start.sh && \
    echo 'echo "🧪 Testing local health check..."' >> /app/simple-start.sh && \
    echo 'curl -f http://localhost:$PORT/health && echo "✅ Health check passed!" || echo "❌ Health check failed"' >> /app/simple-start.sh && \
    echo 'echo "📊 Process status:"' >> /app/simple-start.sh && \
    echo 'ps aux | grep artisan || true' >> /app/simple-start.sh && \
    echo 'echo "✅ Keeping server running..."' >> /app/simple-start.sh && \
    echo 'wait $SERVER_PID' >> /app/simple-start.sh && \
    chmod +x /app/simple-start.sh

# Use simple start script
CMD ["/app/simple-start.sh"]
