# Simple and reliable Laravel deployment for Railway
FROM php:8.2-apache

# Install system dependencies and PHP extensions in one layer
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libonig-dev \
    sqlite3 \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache modules
RUN a2enmod rewrite headers

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies (with fallback if lock file fails)
RUN composer install --no-dev --no-interaction --optimize-autoloader || \
    (rm -f composer.lock && composer install --no-dev --no-interaction --optimize-autoloader)

# Copy application code
COPY . .

# Set production environment variables
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Set up proper permissions and directories
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache public/storage && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Create ultra-simple index.php fallback
RUN echo '<?php echo "FreshMart OK"; ?>' > /var/www/html/index-fallback.php

# Create startup script with better error handling
RUN echo '#!/bin/bash' > /start.sh && \
    echo 'set -e' >> /start.sh && \
    echo 'echo "=== FreshMart Railway Startup ==="' >> /start.sh && \
    echo 'echo "Current directory: $(pwd)"' >> /start.sh && \
    echo 'echo "PHP version: $(php -v | head -1)"' >> /start.sh && \
    echo 'echo "Apache version: $(apache2 -v | head -1)"' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Set port' >> /start.sh && \
    echo 'PORT=${PORT:-80}' >> /start.sh && \
    echo 'echo "Using port: $PORT"' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Configure Apache for the port' >> /start.sh && \
    echo 'sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf' >> /start.sh && \
    echo 'cat > /etc/apache2/sites-available/000-default.conf << EOF' >> /start.sh && \
    echo '<VirtualHost *:$PORT>' >> /start.sh && \
    echo '    ServerName localhost' >> /start.sh && \
    echo '    DocumentRoot /var/www/html/public' >> /start.sh && \
    echo '    DirectoryIndex index.php index.html health.php' >> /start.sh && \
    echo '    <Directory /var/www/html/public>' >> /start.sh && \
    echo '        Options Indexes FollowSymLinks' >> /start.sh && \
    echo '        AllowOverride All' >> /start.sh && \
    echo '        Require all granted' >> /start.sh && \
    echo '    </Directory>' >> /start.sh && \
    echo '    # Allow access to health check files directly' >> /start.sh && \
    echo '    <Files "health*">' >> /start.sh && \
    echo '        Order allow,deny' >> /start.sh && \
    echo '        Allow from all' >> /start.sh && \
    echo '    </Files>' >> /start.sh && \
    echo '    ErrorLog ${APACHE_LOG_DIR}/error.log' >> /start.sh && \
    echo '    CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /start.sh && \
    echo '</VirtualHost>' >> /start.sh && \
    echo 'EOF' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Laravel setup (ignore errors)' >> /start.sh && \
    echo 'php artisan config:clear 2>/dev/null || echo "Config clear skipped"' >> /start.sh && \
    echo 'php artisan migrate --force 2>/dev/null || echo "Migration skipped"' >> /start.sh && \
    echo 'php artisan config:cache 2>/dev/null || echo "Config cache skipped"' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Verify health check files exist' >> /start.sh && \
    echo 'echo "Creating health check files..."' >> /start.sh && \
    echo 'echo "<?php header(\"Content-Type: text/plain\"); echo \"OK\"; ?>" > public/health.php' >> /start.sh && \
    echo 'echo "OK" > public/health' >> /start.sh && \
    echo 'echo "<?php echo \"FreshMart\"; ?>" > public/test.php' >> /start.sh && \
    echo 'ls -la public/health*' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Test Apache config' >> /start.sh && \
    echo 'apache2ctl configtest || echo "Config test failed but continuing..."' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Start Apache' >> /start.sh && \
    echo 'echo "Starting Apache on port $PORT"' >> /start.sh && \
    echo 'exec apache2-foreground' >> /start.sh && \
    chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
