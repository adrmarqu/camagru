#!/bin/sh

# Crear configuración de msmtp a partir de las variables de entorno
cat <<EOF > /etc/msmtprc
defaults
auth           on
tls            on
tls_trust_file /etc/ssl/certs/ca-certificates.crt
logfile        /var/log/msmtp.log

account        gmail
host           smtp.gmail.com
port           587
from           ${MAIL_USER}
user           ${MAIL_USER}
password       ${MAIL_PASSWORD}

account default : gmail
EOF

# Permisos estrictos requeridos por msmtp
chmod 600 /etc/msmtprc
chown www-data:www-data /etc/msmtprc

# Archivo de log
touch /var/log/msmtp.log
chmod 666 /var/log/msmtp.log
chown www-data:www-data /var/log/msmtp.log

# Iniciar PHP-FPM
exec docker-php-entrypoint php-fpm
