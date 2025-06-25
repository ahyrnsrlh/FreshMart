# Simple Laravel Docker setup for Railway
FROM php:8.2-cli

# Install minimal system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install only essential PHP extensions
RUN docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy everything
COPY . .

# Install composer dependencies with minimal requirements
RUN composer install --no-dev --no-interaction --ignore-platform-reqs --no-scripts || \
    (rm -f composer.lock && composer install --no-dev --no-interaction --ignore-platform-reqs --no-scripts)

# Create simple start script
RUN echo '#!/bin/bash' > /app/simple-start.sh && \
    echo 'php artisan migrate --force 2>/dev/null || true' >> /app/simple-start.sh && \
    echo 'php artisan config:cache 2>/dev/null || true' >> /app/simple-start.sh && \
    echo 'exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}' >> /app/simple-start.sh && \
    chmod +x /app/simple-start.sh

# Use simple start script
CMD ["/app/simple-start.sh"]
