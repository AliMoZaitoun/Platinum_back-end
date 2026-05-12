#!/bin/sh
set -e

DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-5432}

echo "Checking connection to $DB_HOST on port $DB_PORT..."

until nc -z $DB_HOST $DB_PORT; do
    echo "Waiting for Database Host ($DB_HOST)..."
    sleep 2
done

echo "Database is up - executing commands"

php artisan config:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

php artisan serve --host=0.0.0.0 --port=$PORT