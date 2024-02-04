FROM php:8.3-fpm AS base

COPY ./docker/images/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz_custom.conf

RUN apt-get update && \
    apt-get install --no-install-recommends -y \
        7zip \
        less \
        locales \
        nano \
        zip \
        && \
    apt-get -qy autoremove && \
    apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* && \
    rm -rf /tmp/*

RUN sed -i '/^# cs_CZ.UTF-8 /s/^# //' /etc/locale.gen && \
	locale-gen cs_CZ.UTF-8 && \
	ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

USER www-data

EXPOSE 9000

CMD ["php-fpm"]


#-----------------------------------------------------------------------------------------------------------------------

FROM base AS development


#-----------------------------------------------------------------------------------------------------------------------

FROM base AS production

COPY . /app
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
