#!/usr/bin/env bash

composer install

/opt/docker/wait-for-it.sh mysql:3306 -t 600
bin/console doctrine:migrations:migrate --no-interaction

php-fpm
