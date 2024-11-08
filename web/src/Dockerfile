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

# Setup NewRelic
ARG NEW_RELIC_AGENT_VERSION=
ARG NEW_RELIC_LICENSE_KEY
ARG NEW_RELIC_APP_NAME
RUN curl -L https://download.newrelic.com/php_agent/archive/${NEW_RELIC_AGENT_VERSION}/newrelic-php5-${NEW_RELIC_AGENT_VERSION}-linux.tar.gz | tar -C /tmp -zx \
    && NR_INSTALL_USE_CP_NOT_LN=1 NR_INSTALL_SILENT=1 /tmp/newrelic-php5-${NEW_RELIC_AGENT_VERSION}-linux/newrelic-install install \
    && rm -rf /tmp/newrelic-php5-* /tmp/nrinstall*
COPY ./config/conf.d/newrelic.ini /usr/local/etc/php/conf.d/newrelic.ini

RUN sed -i \
    -e "s/newrelic.license[[:space:]]*=[[:space:]]*.*/newrelic.license = ${NEW_RELIC_LICENSE_KEY}/" \
    -e "s/newrelic.appname[[:space:]]*=[[:space:]]*.*/newrelic.appname = ${NEW_RELIC_APP_NAME}/" \
    /usr/local/etc/php/conf.d/newrelic.ini


WORKDIR /var/www
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

CMD ["apache2-foreground"]