#!/bin/bash

if [ "$SYNC_LIB" == "true" ]; then
rsync -auv --delete  /var/www/html/vendor/ /docker-hidden/vendor/  > /dev/null 2>&1 &
fi
