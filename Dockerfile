# Gunakan image dasar resmi PHP 8.2 dari Docker Hub
FROM php:8.2-fpm

# Set working directory di dalam container
WORKDIR /var/www/html

# Install dependensi sistem + Nginx + Supervisor
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev unzip libpq-dev nodejs npm \
    nginx supervisor

# Konfigurasi dan install ekstensi PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_pgsql zip gd exif bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin file-file aplikasi
COPY . .

# Salin konfigurasi Nginx yang akan kita buat
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# Install dependensi Composer & Build frontend
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build

# Beri izin
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Buat file konfigurasi Supervisor
RUN echo "[supervisord]\nnodaemon=true\n\n[program:nginx]\ncommand=/usr/sbin/nginx -g 'daemon off;'\n\n[program:php-fpm]\ncommand=/usr/local/sbin/php-fpm" > /etc/supervisor/conf.d/supervisord.conf

# Expose port yang akan digunakan Nginx (ini yang penting!)
EXPOSE 8080

# Jalankan Supervisor
CMD ["/usr/bin/supervisord"]