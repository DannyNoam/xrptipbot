FROM phusion/baseimage:latest

COPY . /app/

RUN apt-get -y update

RUN apt-get -y install curl

RUN curl -sL https://deb.nodesource.com/setup_9.x | bash

RUN apt-get -y install nodejs

RUN cd /app && npm install casinocoin-libjs node-fetch

ENTRYPOINT /app/run.sh