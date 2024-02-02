FROM php:8.3-fpm

COPY ./docker/images/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz_custom.conf

EXPOSE 9000

CMD ["php-fpm"]
