#!/bin/bash

cd /var/www/html
php artisan serve --port="${APP_PORT:=3000}" --host=0.0.0.0