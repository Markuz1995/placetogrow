FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client \
    nodejs \
    npm

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

COPY .env.example .env

RUN composer install

RUN npm install

RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY wait-db.sh /usr/local/bin/wait-db.sh

RUN chmod +x /usr/local/bin/wait-db.sh

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
