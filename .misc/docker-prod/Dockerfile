FROM php:7.3 AS code
RUN apt-get update && apt-get install -y zip git
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /app
COPY ./ /app/
ENV APP_ENV=prod
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-suggest \
    && php bin/console assets:install

FROM node:lts AS asset
WORKDIR /app
COPY ./ /app/
RUN yarn && yarn build

FROM node:lts AS inky
RUN npm install foundation-cli --global
WORKDIR /app/mail
COPY _mail/ /app/mail/
RUN yarn && yarn build

FROM alpine:latest
WORKDIR /app
COPY --from=code /app/bin/ /app/bin/
COPY --from=code /app/config/ /app/config/
COPY --from=code /app/public/ /app/public/
COPY --from=asset /app/public/build/ /app/public/build/
COPY --from=inky /app/public/email/ /app/public/email/
COPY --from=code /app/src/ /app/src/
COPY --from=code /app/templates/ /app/templates/
COPY --from=inky /app/templates/_mail/ /app/templates/_mail/
COPY --from=code /app/translations/ /app/translations/
COPY --from=code /app/vendor/ /app/vendor/
COPY --from=code /app/composer.json /app/composer.json
COPY --from=code /app/composer.lock /app/composer.lock
