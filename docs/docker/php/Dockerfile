FROM php:7.2-fpm

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-configure opcache --enable-opcache
RUN docker-php-ext-install opcache
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN apt-get update -y
RUN apt-get install -y zip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
