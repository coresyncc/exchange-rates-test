#!/bin/sh
set -e

composer install --no-dev --optimize-autoloader || { echo 'Composer install failed'; exit 1; }
chown -R www-data:www-data /var/www/html
php artisan migrate --force || { echo 'Migrate failed'; exit 1; }
cp .env.example .env
php artisan key:generate

echo "Initialization complete!"
