#!/bin/bash

# cd /var/www

chmod -R 777 storage
# chmod -R 777 .env
composer install
php artisan key:generate
php artisan migrate

php-fpm
