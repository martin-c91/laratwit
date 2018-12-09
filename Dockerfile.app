FROM laratwit_apache2
# virtualhost
#backup original .conf enabled file
RUN mv /etc/apache2/sites-enabled/000-default.conf /etc/apache2/sites-enabled/000-default.conf.backup
COPY mysite.conf /etc/apache2/sites-enabled/000-default.conf
#COPY php.ini /usr/local/etc/php

#RUN service apache2 restart
#RUN git clone https://github.com/martin-c91/laratwit.git /app
ADD ./ /app
WORKDIR /app

#permission
RUN chown -R www-data:www-data /app && mv .env.example .env

RUN composer install --no-dev
RUN php artisan key:generate --ansi

RUN npm install
RUN npm run production

#post install

# Expose apache.

#CMD service apache2 star
