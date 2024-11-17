#!/bin/bash
# Cache de configuración y rutas
php artisan config:cache
php artisan route:cache

# Iniciar PHP-FPM en segundo plano
php-fpm &

# Iniciar nginx en primer plano
nginx -g 'daemon off;'