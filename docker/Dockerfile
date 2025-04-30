FROM php:8.1-fpm-alpine
# ARG ALPINE_VERSION=3.19.0
# FROM alpine:${ALPINE_VERSION}
LABEL Maintainer="BruteCode"
LABEL Description="Lightweight container with Nginx 1.24 & PHP 8.0 based on Alpine Linux."

# Setup document root
WORKDIR /var/www

# Install system deps
RUN apk add --no-cache \
    bash \
    git \
    curl \
    oniguruma-dev \
    libzip-dev \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    mysql-client \
    zlib-dev \
    libxml2-dev \
    g++ \
    make \
    autoconf \
    nginx \
    runit

    # PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        xml \
        bcmath \
        pcntl \
        intl \
        gd \
        opcache
        
# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy the application code
COPY . /var/www

# Add a www user and set permissions for necessary directories
# ARG nginxUID=1000
# ARG nginxGID=1000

# RUN adduser -D -u ${nginxUID} -g ${nginxGID} -s /bin/sh www && \
#   mkdir -p /var/www && \
#   mkdir -p /var/cache/nginx && \
#   chown -R www:www /var/www && \
#   chown -R www:www /run && \
#   chown -R www:www /var/lib/nginx && \
#   chown -R www:www /var/log/nginx

# Copy php.ini
COPY ./docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Expose port 9000
EXPOSE 8081
