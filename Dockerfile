FROM php:8.2-fpm-alpine

# Install dependencies required for the GD extension (image manipulation)
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd

# Install PDO MySQL for database connectivity
# Install msmtp for sending emails
RUN docker-php-ext-install pdo pdo_mysql \
    && apk add --no-cache msmtp

# Configure PHP to use msmtp and set upload limits
RUN echo "sendmail_path = /usr/bin/msmtp -t" > /usr/local/etc/php/conf.d/mail.ini \
    && printf "upload_max_filesize = 25M\npost_max_size = 25M\nmemory_limit = 256M\n" > /usr/local/etc/php/conf.d/uploads.ini

# Copy initialization script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set working directory
WORKDIR /var/www/html

EXPOSE 9000
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]