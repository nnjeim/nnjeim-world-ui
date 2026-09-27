FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci --no-audit --no-fund

COPY resources ./resources
COPY vite.config.js ./

RUN npm run build

FROM composer:2 AS composer

FROM php:8.4-apache-bookworm

RUN apt-get update \
    && apt-get install --no-install-recommends --yes unzip \
    && a2enmod headers rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer install \
        --classmap-authoritative \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
    && rm -f database/database.sqlite \
    && touch database/database.sqlite \
    && APP_ENV=local \
        APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= \
        DB_CONNECTION=sqlite \
        DB_DATABASE=/var/www/html/database/database.sqlite \
        php -d memory_limit=1G artisan world:install --no-interaction \
    && composer clear-cache \
    && rm -f /usr/local/bin/composer \
    && mkdir -p \
        bootstrap/cache \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && chown -R www-data:www-data bootstrap/cache database storage

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD php -r 'exit(@file_get_contents("http://127.0.0.1/up") === false ? 1 : 0);'

CMD ["apache2-foreground"]
