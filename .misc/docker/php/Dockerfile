FROM php:7.3-fpm

RUN apt-get update \
    && apt-get install -y zip git \
    && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install pdo_mysql opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh \
      /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it

COPY php.ini /usr/local/etc/php/

WORKDIR /app

COPY start.sh /opt/docker/
RUN chmod +x /opt/docker/start.sh
CMD ["/opt/docker/start.sh"]
