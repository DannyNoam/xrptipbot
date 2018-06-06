FROM phusion/baseimage:latest

RUN apt-get -y update

RUN apt-get -y install php-curl php7.0 php-mysql

COPY run.sh /app/

RUN chmod u+x /app/run.sh

ENTRYPOINT /app/run.sh