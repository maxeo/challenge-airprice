#!/bin/bash


bash /docker-run/include/run.env.sh
bash /docker-run/include/run.chown.sh
bash /docker-run/include/run.composer-install.sh
bash /docker-run/include/run.composer-sync.sh
bash /docker-run/include/run.serve.sh
