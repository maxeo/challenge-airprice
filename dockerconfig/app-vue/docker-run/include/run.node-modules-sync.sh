#!/bin/bash

if [ "$SYNC_LIB" == "true" ]; then
rsync -auv --delete  /usr/src/app/node_modules/ /docker-hidden/node_modules/  > /dev/null 2>&1 &
fi
