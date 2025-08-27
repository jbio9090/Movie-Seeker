FROM php:apache

# Install Composer
RUN apt-get update && apt-get install -y unzip curl \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer


RUN a2enmod rewrite
RUN a2ensite 000-default.conf

# PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql
