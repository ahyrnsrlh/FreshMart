# Use a proven Laravel-ready PHP image
FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        gd \
        bcmath \
        pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy and install composer dependencies first (for better Docker layer caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# Copy and install npm dependencies
COPY package.json package-lock.json ./
RUN npm ci

# Copy application code
COPY . .

# Complete composer installation
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Set up Laravel
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache public/storage \
    && chmod -R 775 storage bootstrap/cache \
    && chmod +x start.sh

# Use the start script
CMD ["./start.sh"]

# Start command
CMD ["./start.sh"]
