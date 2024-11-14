#!/bin/bash

# Iniciar PHP-FPM en segundo plano
php-fpm &

# Iniciar nginx en primer plano
nginx -g 'daemon off;'