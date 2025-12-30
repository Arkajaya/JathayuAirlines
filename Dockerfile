# Multi-stage build for Laravel app with PHP extensions intl and zip enabled
# Stage 1: build frontend assets with Node
FROM node:20-bullseye AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci --silent
COPY . .
RUN npm run build --silent || true

# Stage 2: PHP with required extensions and Composer
## Composer stage: run composer in a composer image to avoid requiring extensions in final image
FROM composer:2 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
# prefer dist and no scripts to speed up builds; tolerate some network hiccups by retrying
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts --no-progress || composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist


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


WORKDIR /var/www/html

# Copy composer.json first to leverage cache
## Copy composer artifacts from composer_builder stage (vendor, lock)
COPY --from=composer_builder /app/vendor /var/www/html/vendor
COPY --from=composer_builder /app/composer.lock /var/www/html/composer.lock

# Copy application files
COPY . .

# Copy built frontend assets from node stage (if present)
COPY --from=node_builder /app/public/build public/build

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache || true

EXPOSE 9000

CMD ["php-fpm"]
