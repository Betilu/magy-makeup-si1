#!/bin/sh

# Salir si ocurre algún error
set -e

echo "🚀 Iniciando despliegue en Render..."

# Caché de configuración y rutas para optimizar
echo "Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones (IMPORTANTE: Solo si tienes la base de datos conectada)
# Render detectará las variables de entorno de la BD automáticamente si las vinculaste.
echo "Running Migrations..."
php artisan migrate --force

echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
