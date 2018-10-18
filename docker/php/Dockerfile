FROM php:7.2-cli

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN apt-get install -y git \
    && apt-get install -y zsh \
    && apt-get install -y sudo

# install zip
RUN apt-get install zip unzip

# Install bcmath
RUN docker-php-ext-install bcmath

# Install opcache
RUN docker-php-ext-install opcache

# install xdebug
RUN pecl install xdebug-2.6.1 && docker-php-ext-enable xdebug

# install swoole
RUN pecl install swoole-4.2.3 && docker-php-ext-enable swoole

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# enable non-sudo user
RUN apt-get install sudo
RUN adduser --disabled-password --gecos '' docker
RUN adduser docker sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

WORKDIR /app
