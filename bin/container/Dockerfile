ARG ALPINE_VERSION=3.21
ARG SRC_DIR
FROM alpine:${ALPINE_VERSION}

# Setup document root
WORKDIR /app

# Install packages and remove default server definition
RUN apk add --no-cache \
  curl \
  php83 \
  php83-ctype \
  php83-curl \
  php83-dom \
  php83-fileinfo \
  php83-fpm \
  php83-gd \
  php83-intl \
  php83-mbstring \
  php83-mysqli \
  php83-opcache \
  php83-openssl \
  php83-phar \
  php83-session \
  php83-tokenizer \
  php83-xml \
  php83-xmlreader \
  php83-xmlwriter \
  supervisor

# RUN ln -s /usr/bin/php83 /usr/bin/php
RUN ln -s /usr/sbin/php-fpm83 /usr/sbin/php-fpm

# Configure PHP-FPM
ENV PHP_INI_DIR=/etc/php83
COPY fpm-pool.conf ${PHP_INI_DIR}/php-fpm.d/www.conf
COPY php.ini ${PHP_INI_DIR}/conf.d/custom.ini

# Make sure files/folders needed by the processes are accessible when they run under the nobody user
RUN chown -R nobody:nobody /app /run

# Switch to use a non-root user from here on
USER nobody

# Add application
COPY --chown=nobody --from=src . /app/

# Expose the port nginx is reachable on
EXPOSE 9000

# Let supervisord start nginx & php-fpm
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
CMD ["php-fpm", "-F"]

# Configure a healthcheck to validate that everything is up&running
# HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping || exit 1
