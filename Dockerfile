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
# Instalar msmtp para enviar correos electrónicos
RUN docker-php-ext-install pdo pdo_mysql \
    && apk add --no-cache msmtp

# Configurar PHP para usar msmtp
RUN echo "sendmail_path = /usr/bin/msmtp -t" > /usr/local/etc/php/conf.d/mail.ini

# Copiar script de inicialización
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Configurar el directorio de trabajo
WORKDIR /var/www/html

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]