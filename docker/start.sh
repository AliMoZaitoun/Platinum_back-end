#!/bin/bash
set -e  # stop on any error

php artisan migrate --force
php artisan config:cache
php artisan route:cache

# This must be last — it's what keeps the process alive
php artisan serve --host=0.0.0.0 --port=8080
