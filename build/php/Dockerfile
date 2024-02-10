FROM php:7.4-apache

LABEL author="Amin Shokri"

RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql

# ZIP extension
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

#ffmpeg code
#RUN apt-get install -y ffmpeg

#.htaccess file for script security
RUN a2enmod rewrite