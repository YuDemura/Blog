FROM php:7.4.0-fpm
COPY php.ini /usr/local/etc/php/
RUN apt-get update \ 
	&& docker-php-ext-install pdo_mysql