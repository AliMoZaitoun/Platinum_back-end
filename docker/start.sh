#!/bin/bash
set -e

echo "Waiting for database connection..."
until php artisan db:monitor --databases=pgsql 2>/dev/null; do
    echo "DB not ready, retrying in 3 seconds..."
    sleep 3
done

php artisan migrate --force
php artisan config:cache
php artisan route:cache

php artisan serve --host=0.0.0.0 --port=$PORT
