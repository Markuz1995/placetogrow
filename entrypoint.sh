#!/bin/bash

set -e

# Esperar a que MySQL esté disponible (usando wait-db.sh)
/usr/local/bin/wait-db.sh db

# Ejecutar migraciones
php artisan migrate --force

# Generar clave de aplicación si no está configurada
if ! php artisan key:check --quiet; then
    php artisan key:generate --force
fi

# Otros comandos de inicialización (opcional)
# ...

# Iniciar servidor de desarrollo (en este caso `php artisan serve`)
php artisan serve --host=0.0.0.0 --port=8000
