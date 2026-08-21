FROM php:8.5-fpm-alpine

ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true \
    PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser

RUN apk add --no-cache \
    git \
    curl \
    ca-certificates \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev \
    linux-headers \
    nodejs \
    npm \
    chromium \
    nss \
    freetype \
    freetype-dev \
    harfbuzz \
    ttf-freefont \
    font-dejavu # خطوط أساسية لتجنب مشكلة مربعات النصوص

RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

RUN npm install -g puppeteer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:clear || true

EXPOSE 8080

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

COPY docker/start.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

USER www-data
CMD ["/bin/sh", "/entrypoint.sh"]