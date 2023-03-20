FROM php:8.1-apache

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

RUN apt-get update -y && apt-get install -y libicu-dev unzip zip

COPY  --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install gettext intl pdo_mysql

# COPY /path/to/local/php.ini /usr/local/etc/php/php.ini

# COPY php.ini /usr/local/etc/php/


RUN apt update && \
    git \
    zip \
    unzip \
    vim \
    docker-php-ext-install pdo_mysql bcmath && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug