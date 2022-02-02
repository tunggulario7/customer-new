FROM php:7.4.3-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    && apt install -y zlib1g-dev libmemcached-dev git libicu-dev zip libzip-dev zip libpq-dev \
    && apt-get install -y  software-properties-common \
#    && apt-get install -y php7.4-common php7.4-cli \
    && pecl install apcu
#    && pecl install mcrypt \
#    && pecl install mysql \
#    && pecl install pdo_mysql
#    && docker-php-ext-enable apcu \
#    && docker-php-ext-configure zip \
#    && docker-php-ext-install zip \
#    && docker-php-ext-install pdo pdo_mysql php-mysql php-mbstring

# \
#    RUN apt-get update \
#      && apt-get install -y --no-install-recommends \
#        sudo \
#        procps \
#        curl \
#        libmemcached-dev \
#        libz-dev \
#        libpq-dev \
#        libjpeg-dev \
#        libpng-dev \
#        libfreetype6-dev \
#        libssl-dev \
#        libmcrypt-dev \
#        cron \
#      && rm -rf /var/lib/apt/lists/*


# Install php extensions.
RUN docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install bcmath \
#    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo \
#    && docker-php-ext-install mysql \
#    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
#    && docker-php-ext-enable mysql \
#    && docker-php-ext-enable pdo_mysql \
#    && docker-php-ext-install php-mysqli \
#    && docker-php-ext-install php-mbstring \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache

WORKDIR /var/www

COPY ./php.ini /usr/local/etc/php/

## RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer