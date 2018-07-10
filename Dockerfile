FROM php:7.2-apache

# Install mysql extension
RUN apt-get update && docker-php-ext-install mysqli

# Install CH CA certificate
RUN curl -so /etc/ssl/certs/wisvch.crt https://ch.tudelft.nl/certs/wisvch.crt && \
    chmod 644 /etc/ssl/certs/wisvch.crt && \
    update-ca-certificates

# Create log folder
RUN mkdir /var/log/php && touch /var/log/php/error.log && chown www-data:www-data /var/log/php/error.log

# Copy project files
COPY . /var/www/html/

EXPOSE 80

