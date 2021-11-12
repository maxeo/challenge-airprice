#!/bin/bash

dos2unix ../dockerconfig/reverse_proxy/docker-run/run.sh
dos2unix ../dockerconfig/app-vue/docker-run/run.sh
dos2unix ../dockerconfig/api-webserver/docker-run/run.sh

chmod +x ../dockerconfig/reverse_proxy/docker-run/run.sh
chmod +x ../dockerconfig/app-vue/docker-run/run.sh
chmod +x ../dockerconfig/api-webserver/docker-run/run.sh