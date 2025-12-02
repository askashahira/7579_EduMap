FROM php:8.2-fpm

WORKDIR /var/www/html

# Install dependensi sistem + Nginx + Supervisor
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev unzip libpq-dev nodejs npm \
    nginx supervisor

# Install ekstensi PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_pgsql zip gd exif bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin file konfigurasi Nginx dan PHP-FPM
COPY docker/nginx/default.conf /etc/nginx/sites-available/default
# Konfigurasi PHP-FPM untuk menggunakan socket
RUN echo "[www]\nlisten = /var/run/php/php-fpm.sock\nlisten.owner = www-data\nlisten.group = www-data" > /usr/local/etc/php-fpm.d/zz-docker.conf

# Salin file aplikasi
COPY . .

# Install dependensi & build
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build

# Beri izin
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Buat file konfigurasi Supervisor
RUN echo "[supervisord]\nnodaemon=true\n\n[program:nginx]\ncommand=/usr/sbin/nginx -g 'daemon off;'\n\n[program:php-fpm]\ncommand=/usr/local/sbin/php-fpm" > /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080
CMD ["/usr/bin/supervisord"]