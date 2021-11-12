#!/bin/bash

#/var/www/html/.env
echo "" > /var/www/html/.env


echo -e "APP_NAME=${APP_NAME:=Laravel}" >> /var/www/html/.env
echo -e "APP_ENV=${APP_ENV:=local}" >> /var/www/html/.env
echo -e "APP_KEY=${APP_KEY}" >> /var/www/html/.env
echo -e "APP_DEBUG=${APP_DEBUG:=false}" >> /var/www/html/.env
echo -e "APP_URL=${APP_URL:=http://127.0.0.1}" >> /var/www/html/.env
echo -e "APP_TIMEZONE=${TZ:=Europe/Rome}" >> /var/www/html/.env
echo -e "APP_LOCALE=${APP_LOCALE:=it_IT}" >> /var/www/html/.env
echo -e "APP_PROXY_SCHEMA=${APP_PROXY_SCHEMA:=http}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "LOG_CHANNEL=${LOG_CHANNEL:=stack}" >> /var/www/html/.env
echo -e "LOG_LEVEL=${LOG_LEVEL:=warning}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "DB_CONNECTION=${DB_CONNECTION:=mysql}" >> /var/www/html/.env
echo -e "DB_HOST=${DB_HOST:=localhost}" >> /var/www/html/.env
echo -e "DB_PORT=${DB_PORT:=3306}" >> /var/www/html/.env
echo -e "DB_DATABASE=${DB_DATABASE}" >> /var/www/html/.env
echo -e "DB_USERNAME=${DB_USERNAME}" >> /var/www/html/.env
echo -e "DB_PASSWORD=${DB_PASSWORD}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "BROADCAST_DRIVER=${BROADCAST_DRIVER:=log}" >> /var/www/html/.env
echo -e "CACHE_DRIVER=${CACHE_DRIVER:=file}" >> /var/www/html/.env
echo -e "FILESYSTEM_DRIVER=${FILESYSTEM_DRIVER:=local}" >> /var/www/html/.env
echo -e "QUEUE_CONNECTION=${QUEUE_CONNECTION:=sync}" >> /var/www/html/.env
echo -e "SESSION_DRIVER=${SESSION_DRIVER:=file}" >> /var/www/html/.env
echo -e "SESSION_LIFETIME=${SESSION_LIFETIME:=120}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "MEMCACHED_HOST=${MEMCACHED_HOST:=127.0.0.1}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "REDIS_HOST=${REDIS_HOST:=127.0.0.1}" >> /var/www/html/.env
echo -e "REDIS_PASSWORD=${REDIS_PASSWORD:=null}" >> /var/www/html/.env
echo -e "REDIS_PORT=${REDIS_PORT:=6379}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "MAIL_MAILER=${MAIL_MAILER:=smtp}" >> /var/www/html/.env
echo -e "MAIL_HOST=${MAIL_HOST:=mailhog}" >> /var/www/html/.env
echo -e "MAIL_PORT=${MAIL_PORT:=1025}" >> /var/www/html/.env
echo -e "MAIL_USERNAME=${MAIL_USERNAME:=null}" >> /var/www/html/.env
echo -e "MAIL_PASSWORD=${MAIL_PASSWORD:=null}" >> /var/www/html/.env
echo -e "MAIL_ENCRYPTION=${MAIL_ENCRYPTION:=null}" >> /var/www/html/.env
echo -e "MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS:=null}" >> /var/www/html/.env
echo -e "MAIL_FROM_NAME=${MAIL_FROM_NAME}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "AWS_ACCESS_KEY_ID=${AWS_ACCESS_KEY_ID}" >> /var/www/html/.env
echo -e "AWS_SECRET_ACCESS_KEY=${AWS_SECRET_ACCESS_KEY}" >> /var/www/html/.env
echo -e "AWS_DEFAULT_REGION=${AWS_DEFAULT_REGION:=us-east-1}" >> /var/www/html/.env
echo -e "AWS_BUCKET=" >> /var/www/html/.env
echo -e "AWS_USE_PATH_STYLE_ENDPOINT=${AWS_DEFAULT_REGION:=false}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "PUSHER_APP_ID=${PUSHER_APP_ID}" >> /var/www/html/.env
echo -e "PUSHER_APP_KEY=${PUSHER_APP_KEY}" >> /var/www/html/.env
echo -e "PUSHER_APP_SECRET=${PUSHER_APP_SECRET}" >> /var/www/html/.env
echo -e "PUSHER_APP_CLUSTER=${AWS_DEFAULT_REGION:=mt1}" >> /var/www/html/.env
echo -e "" >> /var/www/html/.env
echo -e "MIX_PUSHER_APP_KEY=${PUSHER_APP_KEY}" >> /var/www/html/.env
echo -e "MIX_PUSHER_APP_CLUSTER=${PUSHER_APP_CLUSTER}" >> /var/www/html/.env
echo -e ""

