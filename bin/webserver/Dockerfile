#Quickfix - Basebox for PHP7.2 Library now uses Debian "10" Buster, superceeding #libcurl3, stretch is most compatible at this time whilst devs workout backport.
#https://github.com/docker-library/php/issues/865

FROM php:7.2-apache-stretch
#Surpresses debconf complaints of trying to install apt packages interactively
#https://github.com/moby/moby/issues/4032#issuecomment-192327844
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get -y update --fix-missing --no-install-recommends && apt-get -y upgrade \
&& apt-get -yq install --fix-missing apt-utils nano wget dialog build-essential git curl libcurl3 libcurl3-dev zip openssl \
libsqlite3-dev libsqlite3-0 mysql-client libicu-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& pecl install xdebug-2.6.0 \
&& docker-php-ext-enable xdebug \
&& pecl install redis-4.0.1 \
&& docker-php-ext-enable redis \
&& docker-php-ext-install pdo_mysql \ 
&& docker-php-ext-install pdo_sqlite \
&& docker-php-ext-install mysqli \
&& docker-php-ext-install curl \
&& docker-php-ext-install tokenizer \
&& docker-php-ext-install json \
&& docker-php-ext-install zip \
&& docker-php-ext-install -j$(nproc) intl \
&& docker-php-ext-install mbstring \
&& docker-php-ext-install gettext \
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&& docker-php-ext-install -j$(nproc) gd \
&& a2enmod rewrite headers
