#!/bin/bash
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