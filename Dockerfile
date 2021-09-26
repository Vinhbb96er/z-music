FROM php:7.2-fpm-alpine

WORKDIR /var/www/html

RUN apk update && apk add --no-cache \
    build-base shadow supervisor \
    php7-common \
    php7-pdo \
    php7-pdo_mysql \
    php7-mysqli \
    php7-mcrypt \
    php7-mbstring \
    php7-xml \
    php7-openssl \
    php7-json \
    php7-phar \
    php7-zip \
    php7-gd \
    php7-dom \
    php7-session \
    php7-zlib \
    php-bcmath \
    php-tokenizer

#COPY .docker/php-custom.ini /usr/local/etc/php/conf.d/custom.ini

RUN apk add curl wget nano

# Install composer 1.x
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.16

# Install npm
RUN apk add --update nodejs nodejs-npm

# Add and Enable PHP-PDO Extenstions for PHP connect Mysql
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

COPY . .
RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www



# Production
# RUN composer install
# RUN npm install
