# Multi-stage build for Laravel app with PHP extensions intl and zip enabled
# Stage 1: build frontend assets with Node
FROM node:20-bullseye AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci --silent
COPY . .
RUN npm run build --silent || true

# Stage 2: PHP with required extensions and Composer
FROM php:8.3-fpm-bullseye

ARG UID=1000
ARG GID=1000

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        build-essential \
        g++ \
        autoconf \
        pkg-config \
        libicu-dev \
        libzip-dev \
        zlib1g-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        git \
        unzip \
        curl \
    && docker-php-ext-install intl zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Copy composer from official composer image for reliability
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer.json first to leverage cache
COPY composer.json composer.lock ./
# Try a normal composer install; on failure print diagnostics and retry
# with targeted ignore for ext-intl and ext-zip so CI builders without
# those extensions can still complete the build. Avoid ignoring in
# production images if possible — prefer installing extensions.
RUN set -eux; \
    php -v; \
    php -m || true; \
    composer --version || true; \
    composer diagnose || true; \
    composer install --no-dev --optimize-autoloader --no-interaction || (echo "Composer install failed, retrying with targeted ignores..."; composer diagnose || true; composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-req=ext-intl --ignore-platform-req=ext-zip)

# Copy application files
COPY . .

# Copy built frontend assets from node stage (if present)
COPY --from=node_builder /app/public/build public/build

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache || true

EXPOSE 9000

CMD ["php-fpm"]
