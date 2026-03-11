FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y git unzip

COPY . .

RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install --no-dev --optimize-autoloader

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000