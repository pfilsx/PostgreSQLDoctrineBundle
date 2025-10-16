FROM php:8.3-cli-alpine

RUN  apk add --update linux-headers \
     && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
     && pecl install xdebug && docker-php-ext-enable xdebug \
     && apk del -f .build-deps

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet

WORKDIR /app