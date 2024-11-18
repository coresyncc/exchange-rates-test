FROM php:8.2-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    unzip \
    supervisor \
    libxml2-dev \
    nginx \
    && docker-php-ext-install pdo_mysql xml zip soap bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY nginx.conf /etc/nginx/nginx.conf


WORKDIR /var/www/html

CMD /var/www/html/init.sh && service supervisor start

EXPOSE 8005
