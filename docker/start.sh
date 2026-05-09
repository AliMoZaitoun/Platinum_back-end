#!/bin/sh
set -e

echo "Waiting for database connection..."

until php artisan db:monitor --databases=pgsql 2>/dev/null; do
    echo "PostgreSQL not ready, retrying in 3 seconds..."
    sleep 3
done

echo "Database is up - executing commands"

php artisan storage:link --force

php artisan config:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

echo "Starting PHP-FPM..."

php-fpm

# php artisan serve --host=0.0.0.0 --port=${PORT:-8080}