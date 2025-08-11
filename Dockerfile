FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath \
    && a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for better caching)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Set up Laravel directories and permissions
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Run composer scripts
RUN composer dump-autoload --optimize

# Create a simple debug endpoint
RUN echo '<?php phpinfo(); ?>' > public/info.php \
    && echo '<?php' > public/debug.php \
    && echo 'echo "Laravel Debug Info:<br>";' >> public/debug.php \
    && echo 'echo "PHP Version: " . PHP_VERSION . "<br>";' >> public/debug.php \
    && echo 'echo "Environment: " . ($_ENV["APP_ENV"] ?? "NOT SET") . "<br>";' >> public/debug.php \
    && echo 'echo "App Key: " . (($_ENV["APP_KEY"] ?? false) ? "SET" : "NOT SET") . "<br>";' >> public/debug.php \
    && echo 'echo "Database Host: " . ($_ENV["DB_HOST"] ?? "NOT SET") . "<br>";' >> public/debug.php \
    && echo '?>' >> public/debug.php

# Configure Apache DocumentRoot and ServerName
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy and setup startup script
COPY docker/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# Expose port 80
EXPOSE 80

# Start with startup script
CMD ["/usr/local/bin/startup.sh"]