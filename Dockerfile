FROM php:8.2-fpm

# Install system deps
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install intl zip pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working dir
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy project
COPY . .

# Permission
RUN chown -R www-data:www-data storage bootstrap/cache
