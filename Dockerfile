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

# Create ultra-simple start script with debug output
RUN echo '#!/bin/bash' > /app/simple-start.sh && \
    echo 'set -x' >> /app/simple-start.sh && \
    echo 'echo "=== FRESHMART STARTUP DEBUG ==="' >> /app/simple-start.sh && \
    echo 'export PORT=${PORT:-8000}' >> /app/simple-start.sh && \
    echo 'echo "PORT: $PORT"' >> /app/simple-start.sh && \
    echo 'echo "PWD: $(pwd)"' >> /app/simple-start.sh && \
    echo 'echo "Files:"' >> /app/simple-start.sh && \
    echo 'ls -la public/index.php artisan bootstrap/app.php || true' >> /app/simple-start.sh && \
    echo 'echo "=== LARAVEL SETUP ==="' >> /app/simple-start.sh && \
    echo 'mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache' >> /app/simple-start.sh && \
    echo 'chmod -R 777 storage bootstrap/cache 2>/dev/null || true' >> /app/simple-start.sh && \
    echo 'php artisan config:clear || echo "Config clear failed"' >> /app/simple-start.sh && \
    echo 'echo "=== TESTING PHP SERVER ==="' >> /app/simple-start.sh && \
    echo 'echo "Testing if we can start PHP server..."' >> /app/simple-start.sh && \
    echo 'cd /app' >> /app/simple-start.sh && \
    echo 'echo "<?php echo \"PHP Server Test OK\"; ?>" > test.php' >> /app/simple-start.sh && \
    echo 'php -S 0.0.0.0:$PORT test.php &' >> /app/simple-start.sh && \
    echo 'TEST_PID=$!' >> /app/simple-start.sh && \
    echo 'sleep 2' >> /app/simple-start.sh && \
    echo 'curl http://localhost:$PORT/ && echo " - Test server OK" || echo " - Test server FAILED"' >> /app/simple-start.sh && \
    echo 'kill $TEST_PID 2>/dev/null || true' >> /app/simple-start.sh && \
    echo 'rm test.php' >> /app/simple-start.sh && \
    echo 'echo "=== STARTING LARAVEL ==="' >> /app/simple-start.sh && \
    echo 'php artisan serve --host=0.0.0.0 --port=$PORT --no-reload &' >> /app/simple-start.sh && \
    echo 'SERVER_PID=$!' >> /app/simple-start.sh && \
    echo 'echo "Laravel server PID: $SERVER_PID"' >> /app/simple-start.sh && \
    echo 'sleep 5' >> /app/simple-start.sh && \
    echo 'echo "=== SERVER STATUS CHECK ==="' >> /app/simple-start.sh && \
    echo 'ps aux | grep php' >> /app/simple-start.sh && \
    echo 'netstat -ln | grep ":$PORT"' >> /app/simple-start.sh && \
    echo 'echo "=== HEALTH CHECK TEST ==="' >> /app/simple-start.sh && \
    echo 'curl -v http://localhost:$PORT/health || echo "Health check failed"' >> /app/simple-start.sh && \
    echo 'curl -v http://localhost:$PORT/ || echo "Root route failed"' >> /app/simple-start.sh && \
    echo 'echo "=== KEEPING SERVER ALIVE ==="' >> /app/simple-start.sh && \
    echo 'tail -f /dev/null' >> /app/simple-start.sh && \
    chmod +x /app/simple-start.sh

# Use simple start script
CMD ["/app/simple-start.sh"]
