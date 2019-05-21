FROM node:lts AS inky
RUN npm install foundation-cli --global
WORKDIR /app/mail
COPY _mail/ /app/mail/
RUN yarn && yarn build

FROM node:lts AS asset
WORKDIR /app
COPY ./ /app/
RUN yarn && yarn build

FROM php:7.3
RUN apt-get update && apt-get install -y zip git && rm -r /var/lib/apt/lists/*
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /app
COPY ./ /app/
ENV APP_ENV=prod
COPY --from=inky /app/public/email/ /app/public/email/
COPY --from=inky /app/templates/_mail/ /app/templates/_mail/
COPY --from=asset /app/public/build/ /app/public/build/
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-suggest \
    && php bin/console assets:install
