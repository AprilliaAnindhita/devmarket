FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .

RUN mkdir -p storage/downloads public/uploads/thumbnails \
    && chown -R www-data:www-data storage public/uploads

EXPOSE 80
CMD ["apache2-foreground"]
