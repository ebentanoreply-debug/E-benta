FROM php:8.4-apache

# Install required system packages & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    ca-certificates \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd opcache bcmath \
    && a2enmod rewrite

# Install Node.js (v20) and npm for Vite frontend asset build
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure Apache DocumentRoot to Laravel public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess overrides in Apache
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy application files
COPY . .

# Install PHP dependencies and compile Vite frontend assets
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm ci || npm install \
    && npm run build \
    && rm -rf node_modules

# Ensure Laravel storage and bootstrap cache directories exist and set permissions
RUN mkdir -p /var/www/storage/framework/cache /var/www/storage/framework/sessions /var/www/storage/framework/views /var/www/storage/logs \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 10000

# Configure port dynamically from Render's $PORT, link storage, run migration and seed-once command, cache routes/views/config, and start Apache
CMD sh -c "sed -i \"s/80/\${PORT:-10000}/g\" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && php artisan storage:link --force && php artisan app:init-db && php artisan config:cache && php artisan route:cache && php artisan view:cache && apache2-foreground"
