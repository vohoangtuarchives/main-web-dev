FROM php:8.1.8-apache

RUN apt update -y && apt install -y zlib1g-dev libpng-dev libjpeg-dev git zip unzip curl
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt install -y nodejs
RUN docker-php-ext-install pdo_mysql bcmath opcache calendar exif pcntl
RUN docker-php-ext-configure gd --with-jpeg && docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Configure PHP
COPY php.ini $PHP_INI_DIR/conf.d/opcache.ini

# Use the default development configuration
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN a2enmod rewrite headers

