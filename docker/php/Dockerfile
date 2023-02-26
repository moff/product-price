FROM php:8.2.0-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
    && pecl install -n mcrypt \
	&& docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get -y update \
    && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Install xdebug
RUN pecl install xdebug-3.2.0alpha2 && docker-php-ext-enable xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy PHP-FPM config
COPY ./php/www.conf /usr/local/etc/php-fpm.d/www.conf

# ADD and set Group
RUN addgroup --gid 1000 laravel && \
    adduser --gid 1000 laravel --shell /bin/sh && \
    chown -R laravel:laravel /var/www/html

# set working directory for PHP
#WORKDIR /var/www

#CMD ["php-fpm"]
