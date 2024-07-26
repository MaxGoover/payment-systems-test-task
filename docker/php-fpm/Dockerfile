ARG PHP_VERSION=8.3

FROM php:${PHP_VERSION}-fpm-alpine

RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash

#postgres
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql

ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

COPY ./ /var/www
WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm

EXPOSE 9000



