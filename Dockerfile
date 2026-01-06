
FROM php:8.3-fpm

# Install system dependencies and required libraries
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        build-essential \
        autoconf \
        pkg-config \
        libzip-dev \
        zlib1g-dev \
        libicu-dev \
        libpq-dev \
        default-libmysqlclient-dev \
        libonig-dev \
        unzip \
        git \
        curl \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
    ; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    docker-php-ext-configure gd --with-jpeg --with-freetype

RUN set -eux; \
    docker-php-ext-install -j"$(nproc)" zip intl pdo pdo_mysql pdo_pgsql mbstring gd opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Debug: show PHP and Composer versions at build time
RUN php -v && /usr/bin/composer --version

# Install PHP dependencies (production)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy project files
COPY . .

# Laravel permission
RUN chown -R www-data:www-data storage bootstrap/cache public || true

# Enable OPcache recommended settings and optimize application caches
RUN printf '%s\n' "[opcache]" \
    "opcache.enable=1" \
    "opcache.memory_consumption=256" \
    "opcache.interned_strings_buffer=16" \
    "opcache.max_accelerated_files=10000" \
    "opcache.revalidate_freq=2" \
    "opcache.save_comments=1" \
    "opcache.fast_shutdown=1" > /usr/local/etc/php/conf.d/opcache-recommended.ini || true

# Optimize Composer autoload and cache Laravel config/routes/views for faster boot
RUN composer dump-autoload -o --no-dev || true
RUN php artisan config:cache --no-interaction || true
RUN php artisan route:cache --no-interaction || true
RUN php artisan view:cache --no-interaction || true
