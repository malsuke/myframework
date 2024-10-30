FROM php:8.3.7-apache

ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt update
RUN apt install -y unzip libpq-dev libicu-dev libonig-dev libzip-dev zlib1g-dev locales vim \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

RUN docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    # ctype \
    # curl \
    # dom \
    # fileinfo \
    # filter \
    # hash \
    intl \
    # json \
    # mbstring \
    # openssl \
    # pcre \
    # pdo_sqlite \
    # session \
    # tokenizer \
    # xml \
    zip

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

CMD ["apache2-foreground"]