#!/bin/sh
set -eu

cd /var/www/html

PORT="${PORT:-3000}"

# Sesuaikan port Apache dengan port dari platform
sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf

# Cache konfigurasi Laravel
php artisan config:cache

exec "$@"
