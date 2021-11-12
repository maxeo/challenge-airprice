#!/bin/bash


php /docker-run/include/run.env.php
bash /docker-run/include/run.npm-install.sh
bash /docker-run/include/run.node-modules-sync.sh
bash /docker-run/include/run.build.sh
bash /docker-run/include/run.serve.sh
