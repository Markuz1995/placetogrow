# FROM php:8.2-fpm

# # Install necessary packages
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip \
#     default-mysql-client \
#     nodejs \
#     npm \
#     && rm -rf /var/lib/apt/lists/*

# # Install PHP extensions
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Set working directory
# WORKDIR /var/www/html

# # Copy application files and configuration
# COPY . .

# # Copy and rename the environment file
# COPY .env.example .env

# # Install PHP dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Install JavaScript dependencies
# RUN npm install && npm run production

# # Generate application key
# RUN php artisan key:generate

# # Set permissions
# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# # Copy wait-db.sh script and set executable permissions
# COPY wait-db.sh /usr/local/bin/wait-db.sh
# RUN chmod +x /usr/local/bin/wait-db.sh

# # Expose port 8000 (assuming you will use it with `php artisan serve`)
# EXPOSE 8000

# # Command to run the application
# CMD php artisan serve --host=0.0.0.0 --port=8000
