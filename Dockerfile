# Use Ubuntu-based PHP image for better compatibility
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd intl

# Get latest Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /app

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction

# Copy package.json and install npm dependencies
COPY package.json package-lock.json ./
RUN npm ci

# Copy the rest of the application code
COPY . .

# Build frontend assets
RUN npm run build

# Set up Laravel
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache public/storage \
    && chmod -R 775 storage bootstrap/cache \
    && chmod +x start.sh

# Use the start script
CMD ["./start.sh"]
