FROM php:7.3-cli

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN apt-get install -y git \
    && apt-get install -y zsh

# install pgsl
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# install zip
RUN apt-get install zip unzip

# Install zip
RUN apt-get install -y libzip-dev && docker-php-ext-install zip

# Install bcmath
RUN docker-php-ext-install bcmath

# Install opcache
RUN docker-php-ext-install opcache

# install xdebug
RUN pecl install xdebug-2.7.0beta1 && docker-php-ext-enable xdebug

# install swoole
RUN pecl install swoole-4.2.12 && docker-php-ext-enable swoole

# install amqp
RUN apt-get install -y librabbitmq-dev && pecl install amqp-1.9.4 && docker-php-ext-enable amqp

# Install pcov
RUN pecl install pcov && docker-php-ext-enable pcov

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# enable non-sudo user
RUN apt-get install sudo
RUN adduser --disabled-password --gecos '' docker
RUN adduser docker sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

WORKDIR /app
