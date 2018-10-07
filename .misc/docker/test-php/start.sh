#!/usr/bin/env bash

composer install

php bin/console lint:yaml config
php bin/console lint:yaml translations
php bin/console lint:twig templates
php vendor/bin/phpcs -p src
php vendor/bin/php-cs-fixer fix src --dry-run --diff -vvv
