FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    curl \
    libpq \
    libpq-dev \
    oniguruma-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    linux-headers \
    make \
    autoconf \
    g++

RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
       pdo_pgsql \
       bcmath \
       pcntl \
       intl \
       zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN addgroup -g 1000 app && adduser -G app -g app -s /bin/sh -D app \
    && chown -R app:app /var/www/html

USER app

CMD ["php-fpm"]


