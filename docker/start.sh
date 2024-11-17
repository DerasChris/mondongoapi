#!/bin/bash

# Verificar credenciales de Firebase
if [ ! -f "/var/www/firebase_credentials.json" ]; then
    echo "Error: Firebase credentials not found"
    exit 1
fi

# Cache de configuración y rutas
php artisan config:cache
php artisan route:cache

# Iniciar PHP-FPM en segundo plano
php-fpm &

# Iniciar nginx en primer plano
nginx -g 'daemon off;'

# Detener contenedores y eliminar redes, volúmenes, etc.
docker-compose down

# Construir y levantar los contenedores
docker-compose up --build -d

# Verificar que los contenedores estén corriendo
docker ps