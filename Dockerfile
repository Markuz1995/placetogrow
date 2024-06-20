FROM php:8.3.7-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    sudo \
    openssh \
    libxml2-dev \
    oniguruma-dev \
    autoconf \
    gcc \
    g++ \
    make \
    pkgconfig \
    npm \
    nodejs \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    ssmtp \
    icu-dev \
    linux-headers

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mbstring xml pcntl gd zip sockets pdo pdo_mysql bcmath soap intl

RUN pecl channel-update pecl.php.net \
    && pecl install pcov swoole \
    && docker-php-ext-enable pcov swoole

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -L -o /tmp/roadrunner.tar.gz https://github.com/spiral/roadrunner-binary/releases/download/v2.4.2/roadrunner-2.4.2-linux-amd64.tar.gz \
    && tar -xzvf /tmp/roadrunner.tar.gz -C /tmp \
    && cp /tmp/roadrunner-2.4.2-linux-amd64/rr /usr/bin/rr

WORKDIR /app

COPY . .

RUN npm install


RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate

RUN composer require laravel/octane spiral/roadrunner \
    && php artisan octane:install --server="swoole"

CMD php artisan migrate --force && php artisan octane:start --server="swoole" --host="0.0.0.0"


EXPOSE 8000
