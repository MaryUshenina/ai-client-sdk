FROM php:8.2-cli

WORKDIR /app

# Установим зависимости
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install

CMD ["./vendor/bin/phpunit", "--testdox"]
