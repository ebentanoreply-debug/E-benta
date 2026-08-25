#!/bin/bash
set -e

echo "==> [Docker] Configuring Apache port to ${PORT:-10000}..."
sed -i "s/80/${PORT:-10000}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

echo "==> [Docker] Creating storage symbolic link..."
php artisan storage:link --force || true

echo "==> [Docker] Running database migrations..."
php artisan migrate --force

echo "==> [Docker] Running database seeders (once-only / idempotent)..."
php artisan db:seed --force || true

echo "==> [Docker] Optimizing application caches..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "==> [Docker] Starting Apache web server..."
exec apache2-foreground
