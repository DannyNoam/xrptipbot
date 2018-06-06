FROM nginx:stable

RUN apt-get -y update

RUN apt-get -y install php7.0 php-cli php-mbstring unzip git-core curl

COPY . /etc/nginx

RUN mkdir /composer

COPY composer.json /composer

RUN mkdir ~/tmp && curl -sS https://getcomposer.org/installer -o composer-setup.php

RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN mv /etc/nginx/certificates /etc
