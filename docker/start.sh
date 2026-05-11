#!/bin/sh
set -e

echo "Waiting for database connection..."

until nc -z platinum-db 5432; do
    echo "PostgreSQL is unavailable - sleeping"
    sleep 2
done

echo "Database is up - executing commands"

php artisan config:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

php-fpm
