# Proyecto PLACE TO GROW

This project is a web application developed with Laravel 11 and PHP 8.2. Below are the instructions to set up and run the development environment.

## Project Documentation
You can access the project documentation [here](https://markuz1995.github.io/placetogrow-wiki/).

## Configuration

### Requirements

Before you begin, make sure you have the following tools installed on your machine:

```bash
# Required Tools
- PHP 8.2
- Composer
- Node.js and npm
- MySQL (or another compatible database system)
- Git
```

### Install PHP dependencies:

```bash
composer install
```

### Install Node.js dependencies:

```bash
npm install
```

### Copy the environment file and configure variables:

```bash
cp .env.example .env

# Open the .env file and configure the following variables according to your environment:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### Generate the application key:

```bash
php artisan key:generate
```

### Create symbolic link for public storage:

```bash
php artisan storage:link
```

### Create base users with roles (example):

```bash
# Create admin user:
php artisan create:admin admin@admin.com admin

# Create guest user:
php artisan create:guest user@user.com user
```

### Run migrations and seeders (optional):

```bash
php artisan migrate --seed
```

## Run development server

### Start Laravel development server:

```bash
php artisan serve
```

### Compile frontend assets (if using Inertia.js, React, and Tailwind CSS):

```bash
npm run dev
```

### Access the application:

```bash
# Abre tu navegador web y ve a:
http://localhost:8000
```
