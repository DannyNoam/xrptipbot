FROM phusion/baseimage:latest

COPY . /app/

RUN apt-get -y update

RUN apt-get -y install curl php7.0 php-mysql

RUN curl -sL https://deb.nodesource.com/setup_9.x | bash

RUN apt-get -y install nodejs

RUN cd /app && npm install node-fetch twilio fs casinocoin-libjs

ENTRYPOINT /app/run.sh