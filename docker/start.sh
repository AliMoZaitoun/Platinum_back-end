#!/bin/bash
set -e

echo "Waiting for database connection ($DB_CONNECTION)..."

until php artisan db:monitor --databases=$DB_CONNECTION 2>/dev/null; do
    echo "DB ($DB_CONNECTION) not ready, retrying in 3 seconds..."
    sleep 3
done

echo "upload_max_filesize=20M" > /usr/local/etc/php/conf.d/uploads.ini
echo "post_max_size=20M" >> /usr/local/etc/php/conf.d/uploads.ini

find /var/www -type d -exec chmod 755 {} \;
find /var/www -type f -exec chmod 644 {} \;

chgrp -R www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

php artisan storage:link --force

php artisan migrate --force
php artisan config:cache
php artisan route:cache

php-fpm