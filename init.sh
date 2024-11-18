#!/bin/sh
set -e

composer install --optimize-autoloader || { echo 'Composer install failed'; exit 1; }
if [ ! -d "/var/www/html/.git" ]; then chown -R www-data:www-data /var/www/html; fi
php artisan migrate --force || { echo 'Migrate failed'; exit 1; }
cp .env.example .env
php artisan key:generate

echo "Initialization complete!"
