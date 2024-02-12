#!/bin/bash

cd /app
ls -la .
composer install --no-interaction --no-scripts

php-fpm
