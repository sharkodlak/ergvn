#!/bin/bash

cd /app
ls -la .
composer install --no-interaction --no-scripts
chown -R www-data:www-data /app

php-fpm
