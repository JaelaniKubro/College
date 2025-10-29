# Gunakan image PHP 8.2 dengan Composer dan Nginx
FROM php:8.2-fpm

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy semua file ke container
COPY . .

# Install dependensi Laravel
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Salin file environment default
RUN cp .env.example .env

# Generate key Laravel
RUN php artisan key:generate

# Set permission ke folder penting
RUN chmod -R 777 storage bootstrap/cache

# Copy konfigurasi nginx
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Jalankan nginx dan PHP-FPM
CMD service nginx start && php-fpm

EXPOSE 80
