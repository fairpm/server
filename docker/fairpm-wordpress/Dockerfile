ARG FRANKENPHP_TAG="1.5.0-php8.4.7-bookworm@sha256:661bbd11ce8b9bbf51ba6e13d1cb7ea533466984142d936411df325922c4cdb1"
ARG COMPOSER_TAG="2.9.1@sha256:7384cf9fa70b710af02c9f40bec6e44472e07138efa5ab3428a058087c0d2724"

FROM composer:${COMPOSER_TAG} AS composer_img
FROM dunglas/frankenphp:${FRANKENPHP_TAG} AS base

COPY --from=composer_img /usr/bin/composer /usr/bin/composer

RUN install-php-extensions apcu gd intl mysqli opcache sqlite3

RUN groupadd --gid 100000 app \
    && useradd --uid 100000 --gid 100000 --create-home --shell /bin/bash app \
    && chown -R app:app /config /data \
    && apt update \
    && apt install -y curl default-mysql-client less

COPY docker/fairpm-wordpress/Caddyfile /etc/caddy/Caddyfile
COPY docker/fairpm-wordpress/php.local.ini /usr/local/etc/php/conf.d/php.local.ini

WORKDIR /app
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]

################
FROM base AS dev

# xdebug is still not enabled by default.  uncomment the line in docker-compose.override.yml to enable.
RUN install-php-extensions xdebug

RUN apt update \
    && apt install sudo \
    && adduser app sudo \
    && echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

USER app

################
FROM base AS prod

COPY . /app
RUN chown -R app:app /app

USER app
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader --working-dir=/app

