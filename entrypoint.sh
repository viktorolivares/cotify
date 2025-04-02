#!/bin/sh

# Espera a que MySQL esté listo
echo "Esperando a MySQL en $DB_HOST:$DB_PORT..."

until mysqladmin ping -h"$DB_HOST" -P"$DB_PORT" --silent; do
    echo "Aún no responde MySQL..."
    sleep 2
done

echo "✅ ¡MySQL está arriba!"

# Generar APP_KEY si no existe
if [ ! -f /var/www/.env ]; then
    echo "❌ No se encontró .env. ¿Seguro que está montado?"
else
    if grep -q "APP_KEY=" /var/www/.env && ! grep -q "APP_KEY=base64" /var/www/.env; then
        echo "🔑 Generando APP_KEY..."
        php artisan key:generate
    fi
fi

# Crear symlink al storage
echo "🔗 Creando storage:link..."
php artisan storage:link

# Ejecutar migraciones y seeders
echo "📦 Migrando y seteando seeders..."
php artisan migrate --force
php artisan db:seed --force

# Limpieza de cache por si acaso
php artisan config:clear

echo "🚀 Listo, arrancando PHP-FPM..."
exec php-fpm
