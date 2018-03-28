#!/usr/bin/env bash

apt-get update -yqq
apt-get install -yqq zip git

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

tail -F /dev/null
