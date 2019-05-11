#!/usr/bin/env bash

composer install

wait-for-it mysql:3306 -t 600
bin/console doctrine:migrations:migrate --no-interaction

mkdir -p public/upload
chmod a+rw public/upload

php-fpm
