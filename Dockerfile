FROM php:8.0.2-apache

RUN apt-get update && apt-get install -y libmcrypt-dev nano cron \
    && docker-php-ext-install pdo pdo_mysql

COPY apache.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

CMD cron && apache2-foreground
