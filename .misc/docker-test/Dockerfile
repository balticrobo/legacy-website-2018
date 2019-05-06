FROM php:7.3

RUN apt-get update \
    && apt-get install -y zip git \
    && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY .misc/docker-test/php.ini /usr/local/etc/php/

COPY . /app/
WORKDIR /app

COPY .misc/docker-test/start.sh /opt/docker/
RUN chmod +x /opt/docker/start.sh
CMD ["/opt/docker/start.sh"]
