#!/bin/bash
set -e # Keluar segera jika ada perintah yang gagal

# Buat direktori socket jika belum ada & atur izin
mkdir -p /var/run/php
chown -R www-data:www-data /var/run/php

# Jalankan migrasi database
echo "Running database migrations..."
php artisan migrate --force

# Jalankan server menggunakan Supervisor
echo "Starting server..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf