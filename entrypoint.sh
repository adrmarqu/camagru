#!/bin/sh

# Create msmtp configuration from environment variables
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

# Strict permissions required by msmtp
chmod 600 /etc/msmtprc
chown www-data:www-data /etc/msmtprc

# Log file setup
touch /var/log/msmtp.log
chmod 666 /var/log/msmtp.log
chown www-data:www-data /var/log/msmtp.log

# Start PHP-FPM
exec docker-php-entrypoint php-fpm
