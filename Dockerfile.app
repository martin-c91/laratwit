FROM php:7.3-apache
MAINTAINER Martin Chea<martinchea@gmail.com>

RUN a2enmod rewrite && service apache2 restart
RUN docker-php-ext-install pdo pdo_mysql
##todo: install xdebug
RUN apt-get update
RUN apt-get -y install gnupg2 zip unzip

#install composer and node
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash - && apt-get install -y nodejs

#
COPY mysite.conf /etc/apache2/sites-enabled/000-default.conf
#COPY php.ini /usr/local/etc/php

#
WORKDIR /app
#COPY . /app

#RUN chown -R www-data:www-data /app && mv .env.example .env
#
#RUN composer install --no-dev
#RUN php artisan key:generate --ansi
#
#RUN npm install
#RUN npm run production

EXPOSE 80
