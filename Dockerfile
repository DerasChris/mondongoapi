# Etapa de construcción
FROM php:8.2-fpm as builder

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar MongoDB
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . /var/www

# Instalar dependencias
RUN composer install --no-interaction --no-dev --optimize-autoloader
RUN npm install && npm run build

# Etapa final
FROM nginx:alpine

# Copiar configuración de nginx
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Copiar archivos de la aplicación
COPY --from=builder /var/www /var/www

# Copiar PHP-FPM
COPY --from=builder /usr/local/bin/php /usr/local/bin/php
COPY --from=builder /usr/local/etc/php /usr/local/etc/php
COPY --from=builder /usr/local/lib/php /usr/local/lib/php
COPY --from=builder /usr/local/sbin/php-fpm /usr/local/sbin/php-fpm

# Establecer permisos
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Exponer puerto
EXPOSE 80

# Iniciar nginx y php-fpm
CMD ["nginx", "-g", "daemon off;"]