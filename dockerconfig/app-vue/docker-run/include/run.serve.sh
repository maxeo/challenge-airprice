#!/bin/bash



if [ "$VUE_ENV" == "prod" ]; then
    #PROD
    cd /usr/src/app/dist

    echo "" > /usr/src/server_output.log

    php -S 0.0.0.0:5000 &> /usr/src/server_output.log 2>&1 &

    tail -f /usr/src/server_output.log
else
    #DEV
    cd /usr/src/app
    vue ui -H 0.0.0.0 > /dev/null 2>&1 &
    vue-cli-service serve > /dev/null 2>&1 &

    tail -f /dev/null
fi



