FROM php:7.1-apache

RUN apt-get update \
 && apt-get install -y \
    zlib1g-dev \
    unzip \
 && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    zip \
    opcache
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN a2enmod rewrite
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf