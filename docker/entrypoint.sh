#!/bin/bash
set -e

echo "Starting entrypoint script..."

# Configure nginx to use the PORT environment variable
PORT=${PORT:-80}
echo "Configuring nginx to listen on port $PORT..."
sed -i "s/\${PORT:-80}/$PORT/g" /etc/nginx/sites-available/default

# Wait for database to be ready (optional, but recommended)
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database at $DB_HOST:$DB_PORT..."
    timeout=30
    while ! nc -z "$DB_HOST" "${DB_PORT:-3306}" 2>/dev/null; do
        timeout=$((timeout - 1))
        if [ $timeout -le 0 ]; then
            echo "Database connection timeout!"
            break
        fi
        echo "Waiting for database... ($timeout seconds remaining)"
        sleep 1
    done
fi

# Create storage directories if they don't exist
echo "Creating storage directories..."
mkdir -p /var/www/storage/framework/cache/data
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

# Set permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Run Laravel optimizations
echo "Running Laravel optimizations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (optional - remove if you prefer to run manually)
if [ "$APP_ENV" = "production" ]; then
    echo "Running migrations..."
    php artisan migrate --force --no-interaction
fi

# Create symbolic link for storage
if [ ! -L /var/www/public/storage ]; then
    echo "Creating storage link..."
    php artisan storage:link
fi

echo "Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
