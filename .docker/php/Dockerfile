
FROM php:fpm-alpine
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY ./composer.json /var/www/html/
RUN composer update
RUN composer install
RUN mkdir -p /var/www/html/config/cache/search_tours/
RUN chmod -R 777 /var/www/html/config/cache/search_tours/



