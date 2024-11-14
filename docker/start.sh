#!/bin/bash

# Generar key de Laravel si no existe
php artisan key:generate --force

# Cache de configuración y rutas
php artisan config:cache
php artisan route:cache

# Iniciar PHP-FPM en segundo plano
php-fpm &

# Verificar que PHP-FPM está corriendo
while ! nc -z localhost 9000; do
  sleep 1
done

# Iniciar nginx en primer plano
nginx -g 'daemon off;'