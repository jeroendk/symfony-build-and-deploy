FROM php:7.4-fpm

RUN apt-get update --fix-missing \
    && apt-get install -y git curl \
    && apt-get install -y libpng-dev \
    && apt-get install -y zlib1g-dev  libzip-dev libicu-dev g++ \
    && docker-php-ext-install \
    zip \
    intl \
    mysqli \
    pdo pdo_mysql


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer

RUN ln -snf /usr/share/zoneinfo/Europe/Amsterdam /etc/localtime

WORKDIR /var/www/html/symfony

