FROM php:8.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
        unzip \
        git \
        libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

ENV PORT=8080
EXPOSE 8080

CMD ["sh", "-c", "mkdir -p $(dirname \"$DB_DATABASE\") && touch \"$DB_DATABASE\" && php artisan migrate --force && php artisan db:seed --force && php artisan config:cache && php artisan serve --host 0.0.0.0 --port ${PORT:-8080}"]
