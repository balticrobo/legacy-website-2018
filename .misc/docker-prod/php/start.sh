#!/usr/bin/env bash

composer install --no-dev --optimize-autoloader --no-scripts --no-suggest
php bin/console assets:install
