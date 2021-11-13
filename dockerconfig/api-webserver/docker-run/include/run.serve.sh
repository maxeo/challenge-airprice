#!/bin/bash

cd /var/www/html


# Reset data on startup
php artisan migrate:fresh --seed

php artisan serve --port="${APP_PORT:=3000}" --host=0.0.0.0