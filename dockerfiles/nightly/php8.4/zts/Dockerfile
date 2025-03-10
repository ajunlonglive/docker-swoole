FROM php:8.4-zts

ENV DEBIAN_FRONTEND=noninteractive
ENV TERM=xterm-color

ARG DEV_MODE
ENV DEV_MODE=$DEV_MODE

COPY --from=composer:2.8.4 /usr/bin/composer /usr/bin/
COPY ./rootfilesystem/ /

RUN \
    set -ex && \
    apt-get update  && \
    apt-get install -y \
# The auto-reloading feature is supported for non-Alpine images only.
#
# Package "inotify-tools" is pre-installed in latest non-Alpine images. For versioned non-Alpine images, it will be
# installed automatically when needed. For details, please check script "autoreload.sh" and example "00-autoreload".
#
# @see https://github.com/swoole/docker-swoole/blob/master/rootfilesystem/usr/local/boot/autoreload.sh
# @see https://github.com/swoole/docker-swoole/tree/master/examples/00-autoreload
        inotify-tools              \
        libcurl4-openssl-dev       \
        libbrotli-dev              \
        libpq-dev                  \
        libsqlite3-dev             \
        libssl-dev                 \
        supervisor                 \
        unzip                      \
        zlib1g-dev                 \
        --no-install-recommends && \
# PHP extension pdo_mysql is included since 4.8.12+ and 5.0.1+.
    docker-php-ext-install pdo_mysql && \
    pecl channel-update pecl.php.net && \
    pecl install --configureoptions 'enable-redis-igbinary="no" enable-redis-lzf="no" enable-redis-zstd="no"' redis-6.1.0 && \
# PHP extension Redis is included since 4.8.12+ and 5.0.1+.
    docker-php-ext-enable redis && \
    install-swoole.sh master \
        --enable-swoole-thread \
        --enable-swoole-curl   \
        --enable-mysqlnd       \
        --enable-swoole-pgsql  \
        --enable-swoole-sqlite \
        --enable-brotli        \
        --enable-openssl       \
        --enable-sockets    && \
    mkdir -p /var/log/supervisor && \
    rm -rf /var/lib/apt/lists/* /usr/bin/qemu-*-static

ENTRYPOINT ["/entrypoint.sh"]
CMD []

WORKDIR "/var/www/"
