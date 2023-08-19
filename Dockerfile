FROM php:8.2-fpm

# Linux Library
# docker Package 'php8.2-intl' has no installation candidate => intl however was good as it was. You just missed to install libicu-dev
RUN apt-get update && \
    apt-get install -y \
    libicu-dev \
    libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
    libonig-dev \
    git \
    zip \
    curl

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install mbstring

RUN docker-php-ext-enable intl mbstring

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./codeigniter4-v4.3.7/composer.* ./
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# PHP Extension
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# copy app
COPY . /var/www/html

# composer dump autoload
RUN composer dump-autoload --optimize

RUN groupadd sanryuugroup
RUN adduser sanryuu
RUN adduser sanryuu sanryuugroup
RUN usermod -aG sanryuugroup sanryuu

# permissions folder
RUN chown -R sanryuu:sanryuugroup .
RUN chmod -R 755 .
USER sanryuu

EXPOSE 9000