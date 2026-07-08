FROM php:8.2-fpm-alpine

# Instalar dependencias necesarias para la extensión GD (Manipulación de imágenes)
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd

# Instalar PDO MySQL para la conexión segura a la base de datos
RUN docker-php-ext-install pdo pdo_mysql

# Configurar el directorio de trabajo
WORKDIR /var/www/html

EXPOSE 9000
CMD ["php-fpm"]