FROM php:8.2-fpm

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
    npm \
    nginx

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar MongoDB
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar nginx
COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . /var/www

# Instalar dependencias
RUN composer install --no-interaction --no-dev --optimize-autoloader
RUN npm install

# Permisos de almacenamiento
RUN chmod -R 777 storage bootstrap/cache

# Configurar PHP-FPM para escuchar en TCP en lugar de socket Unix
RUN echo "listen = 9000" >> /usr/local/etc/php-fpm.d/www.conf

# Exponer puerto
EXPOSE 80

# Script de inicio
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]