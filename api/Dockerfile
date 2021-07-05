FROM php:7.4-fpm-alpine

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions gd mysqli pdo_mysql bcmath

RUN install-php-extensions @composer-2.0.2

RUN install-php-extensions xdebug-^2.8

WORKDIR /var/www/html
