FROM phusion/baseimage:latest

RUN apt-get -y update --fix-missing

RUN apt-get -y install php-curl php7.0 php-mysql curl php-cli php-mbstring unzip git-core

COPY run.sh /app/

COPY composer.json /app/

RUN chmod u+x /app/run.sh

RUN mkdir ~/tmp && curl -sS https://getcomposer.org/installer -o composer-setup.php

RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN cd /app && composer install

ENTRYPOINT /app/run.sh