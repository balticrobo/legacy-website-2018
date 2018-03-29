#!/usr/bin/env bash

docker-php-ext-install pdo pdo_mysql
docker-php-ext-configure opcache --enable-opcache
docker-php-ext-install opcache
pecl install xdebug
docker-php-ext-enable xdebug

apt-get update -yqq
apt-get install -yqq zip git

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

composer install

php-fpm
