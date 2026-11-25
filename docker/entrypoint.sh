#!/bin/sh
set -eu

cd /var/www/html

PORT="${PORT:-3000}"

echo "========================================"
echo "Lost & Found Gunadarma"
echo "PORT: ${PORT}"
echo "========================================"

# Validasi port
case "$PORT" in
    ''|*[!0-9]*)
        echo "ERROR: PORT tidak valid: ${PORT}"
        exit 1
        ;;
esac

# Sesuaikan port Apache
sed -i "s/^Listen .*/Listen 0.0.0.0:${PORT}/" /etc/apache2/ports.conf

sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf

# Tampilkan konfigurasi aktual
echo "=== Apache Listen ==="
grep "^Listen" /etc/apache2/ports.conf

echo "=== Apache VirtualHost ==="
grep "VirtualHost" /etc/apache2/sites-available/000-default.conf

# Periksa konfigurasi Apache
apache2ctl configtest

# Cache konfigurasi Laravel
php artisan config:cache

exec "$@"
