FROM node:16

RUN apt update ; apt install rsync php -y

WORKDIR /usr/src/app

RUN npm install http-server -g
RUN npm install -g @vue/cli
RUN npm install -g @vue/compiler-sfc
RUN npm install -g @vue/cli-plugin-babel
RUN npm install -g @vue/cli-service

ENTRYPOINT ["/docker-run/run.sh"]

