FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    apt-utils \
    g++ \
    git \
    libicu-dev \
    libjpeg-dev \
    libonig-dev \
    libpng-dev \
    libxml2-dev \
    libxslt-dev \
    libzip-dev \
    locales \
    openssl \
    unzip

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-configure intl

RUN docker-php-ext-install calendar dom gd intl mbstring opcache pdo pdo_mysql xsl zip

RUN pecl install apcu && docker-php-ext-enable apcu

WORKDIR /var/www/