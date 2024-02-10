FROM php:8.3-fpm-alpine

RUN apk add postgresql-dev && docker-php-ext-install pdo_pgsql

RUN apk add autoconf g++ linux-headers make
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN echo -e "[XDebug]\n"\
	"xdebug.client_host=host.docker.internal\n"\
	"xdebug.start_with_request=trigger\n"\
	"xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
