#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "Clearing cache..."
php artisan optimize:clear

echo "Caching..."
php artisan optimize:cache

echo "Running migrations..."
php artisan migrate --seed --force