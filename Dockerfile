FROM ubuntu:16.04
COPY scripts/entrypoint.sh /root/entrypoint.sh

RUN cd / && mkdir data
COPY . /data/

RUN apt-get -y update
RUN apt-get -y install npm php7.0 curl

RUN curl -sL https://deb.nodesource.com/setup_9.x | bash

RUN apt-get -y install nodejs

RUN npm install discord.js

RUN ["chmod", "+x", "/root/entrypoint.sh"]

ENTRYPOINT ["/root/entrypoint.sh"]

