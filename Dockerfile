# Utiliza la imagen base de PHP 8.2 FPM
FROM php:8.2-fpm

# Actualiza e instala dependencias necesarias
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
    npm \
    && rm -rf /var/lib/apt/lists/*

# Instala extensiones PHP necesarias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación al contenedor
COPY . .

# Copia y renombra el archivo de entorno
COPY .env.example .env

# Instala las dependencias PHP sin dev y optimiza el autoloader
RUN composer install --no-dev --optimize-autoloader

# Instala las dependencias JavaScript
RUN npm install && npm run build

# Genera la clave de la aplicación si no está configurada
RUN php artisan key:check --quiet || php artisan key:generate --force

# Establece los permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copia el script wait-db.sh y establece permisos ejecutables
COPY wait-db.sh /usr/local/bin/wait-db.sh
RUN chmod +x /usr/local/bin/wait-db.sh

# Expone el puerto 8000 (asumiendo que se usa para `php artisan serve`)
EXPOSE 8000

# Comando para iniciar la aplicación
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
