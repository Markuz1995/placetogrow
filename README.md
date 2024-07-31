# Proyecto PLACE TO GROW

Este proyecto es una aplicación web desarrollada con Laravel 11 y PHP 8.2. A continuación se presentan las instrucciones para configurar y ejecutar el entorno de desarrollo.

## Configuración

### Requisitos

Antes de comenzar, asegúrate de tener instaladas las siguientes herramientas en tu máquina:

```bash
# Herramientas necesarias
- PHP 8.2
- Composer
- Node.js y npm
- MySQL (u otro sistema de base de datos compatible)
- Git
```

### Instalar dependencias de PHP:

```bash
composer install
```

### Instalar dependencias de Node.js:

```bash
npm install
```

### Copiar el archivo de entorno y configurar las variables:

```bash
cp .env.example .env

# Abre el archivo .env y configura las siguientes variables según tu entorno:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### Generar la clave de la aplicación:

```bash
php artisan key:generate
```

### Crear el enlace simbólico para el almacenamiento público:

```bash
php artisan storage:link
```

### Crear usuarios base con roles (ejemplo):

```bash
# Crear usuario administrador:
php artisan create:admin

# Crear usuario invitado:
php artisan create:guest
```

### Ejecutar migraciones y sembradores (opcional):

```bash
# Migrations and seeds
php artisan migrate --seed

# Seeds
php artisan db:seed
```

## Ejecutar el servidor de desarrollo

### Iniciar el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

### Compilar los activos de frontend (si estás utilizando Inertia.js, React, y Tailwind CSS):

```bash
npm run dev
```

### Acceder a la aplicación:

```bash
# Abre tu navegador web y ve a:
http://localhost:8000
```
