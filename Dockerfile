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
    nginx \
    netcat-openbsd \
    && docker-php-ext-install sodium \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

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
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www
RUN chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Configurar PHP-FPM
RUN echo "listen = 127.0.0.1:9000" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo "clear_env = no" >> /usr/local/etc/php-fpm.d/www.conf

# Crear directorios de logs
RUN mkdir -p /var/log/nginx
RUN touch /var/log/nginx/error.log /var/log/nginx/access.log
RUN chmod 777 /var/log/nginx/error.log /var/log/nginx/access.log

# Exponer puerto
EXPOSE 80

# Script de inicio
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]