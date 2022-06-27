FROM php:8.0.5

RUN apt update \
        && apt install -y \
            g++ \
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev \
            libcurl4-openssl-dev \
            pkg-config \
            libssl-dev \
        && docker-php-ext-install \
            intl \
            opcache \
            pdo

RUN pecl install mongodb \
            &&  echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=80
EXPOSE 80