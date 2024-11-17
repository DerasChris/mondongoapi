#!/bin/bash

# Verificar credenciales de Firebase de manera más flexible
if [ ! -f "/var/www/firebase_credentials.json" ]; then
    echo "Warning: Firebase credentials not found, creating empty file"
    echo "{}" > /var/www/firebase_credentials.json
fi

# Cache de configuración y rutas
php artisan config:cache
php artisan route:cache

# Iniciar PHP-FPM en segundo plano
php-fpm &

# Iniciar nginx en primer plano
nginx -g 'daemon off;'