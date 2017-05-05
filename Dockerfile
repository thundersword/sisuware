FROM daocloud.io/php:5.6-apache
RUN docker-php-ext-install pdo_mysql
COPY ./www /var/www/html
COPY ./php.ini /usr/local/etc/php/
RUN chown -R www-data:www-data /var/www/html