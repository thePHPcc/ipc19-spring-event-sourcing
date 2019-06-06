FROM php:7.3-fpm-alpine

RUN apk update && apk add util-linux sqlite-dev
RUN docker-php-ext-install pdo_sqlite
