# Gunakan image dasar resmi PHP 8.2 dari Docker Hub
FROM php:8.2-fpm

# Set working directory di dalam container
WORKDIR /var/www/html

# Install dependensi sistem yang dibutuhkan oleh Laravel & package Anda
# Termasuk lib-lib untuk gd dan postgresql
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    libpq-dev \
    nodejs \
    npm

# Konfigurasi dan install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install \
    pdo pdo_pgsql \
    zip \
    gd \
    exif \
    bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin file-file aplikasi
COPY . .

# Install dependensi Composer (tanpa dev)
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist --optimize-autoloader

# Hapus cache Composer
RUN composer clear-cache

# Beri izin pada folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Build aset frontend
RUN npm install && npm run build

# Expose port yang digunakan oleh php-fpm
EXPOSE 9000

# Perintah default untuk menjalankan aplikasi
CMD ["php-fpm"]