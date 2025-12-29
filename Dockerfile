FROM php:8.2-fpm

# Install system dependencies (LENGKAP)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    libicu-dev \
    libpq-dev \
    pkg-config \
    unzip \
    git \
    curl \
    && docker-php-ext-install intl zip pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy project files
COPY . .

# Laravel permission
RUN chown -R www-data:www-data storage bootstrap/cache
