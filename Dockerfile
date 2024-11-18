FROM php:8.2-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    supervisor \
    libxml2-dev \
    nginx \
    && docker-php-ext-install pdo_mysql xml zip soap

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD /var/www/html/init.sh && service supervisor start

EXPOSE 8005
