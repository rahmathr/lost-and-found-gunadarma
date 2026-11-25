#!/bin/sh
set -eu

cd /var/www/html

# Build the Laravel configuration cache at container startup so Render
# environment variables are read at runtime. Do not run database migrations
# automatically here; migrations must be executed deliberately.
php artisan config:cache

exec "$@"
