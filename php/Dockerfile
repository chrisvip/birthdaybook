FROM php:8.0-apache

RUN a2enmod rewrite

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

WORKDIR /var/www/bdbook

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["bash", "./Docker.sh"]
