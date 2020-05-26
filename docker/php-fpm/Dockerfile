FROM php:fpm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions apcu imagick intl mcrypt opcache pdo_mysql mysqli xdebug zip amqp gd

COPY symfony.ini /usr/local/etc/php/conf.d/
COPY symfony.ini /usr/local/etc/php/conf.d/
COPY xdebug.ini  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www/tinyhelpdesk