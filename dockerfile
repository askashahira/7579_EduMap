# Menggunakan PHP 8.2 dengan Apache sebagai base image
FROM php:8.2-apache

# Mengatur maintainer
LABEL maintainer="EduMap Project"

# Install system dependencies, termasuk libzip-dev untuk ekstensi zip
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions, termasuk zip
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# =================================================================
# OPTIMISASI LAYER CACHE
# =================================================================
# 1. Salin HANYA file definisi dependensi terlebih dahulu
COPY composer.json composer.lock ./

# 2. Jalankan instalasi dependensi PHP. Layer ini akan di-cache
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# 3. Lakukan hal yang sama untuk NPM
COPY package.json package-lock.json ./
RUN npm install

# 4. BARU setelah itu, salin sisa kode aplikasi
COPY . .
# =================================================================

# Build asset frontend
RUN npm run build

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy custom Apache configuration dari file terpisah (lebih bersih)
# Pastikan Anda punya file '000-default.conf' di direktori yang sama
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Atur ownership & permissions HANYA SEKALI di akhir
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]