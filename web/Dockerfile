FROM nginx:stable

COPY nginx.conf /etc/nginx/nginx.conf
COPY www /usr/share/nginx/html

#RUN apt-get -y update
#RUN apt-get -y install php7.0 php7.0-cgi php7.0-fpm
#
#RUN sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /etc/php/7.0/cli/php.ini
#
#COPY www /usr/share/nginx/html
#COPY nginx.conf /etc/nginx/nginx.conf
#
#RUN usermod -u 1000 www-data
#
#RUN touch /var/run/nginx.pid && \
#  touch /var/log/nginx/app.log && \
#  mkdir /var/cache/nginx/client_temp && \
#  mkdir /var/cache/nginx/proxy_temp && \
#  mkdir /var/cache/nginx/fastcgi_temp && \
#  mkdir /var/cache/nginx/uwsgi_temp && \
#  mkdir /var/cache/nginx/scgi_temp && \
#  chown -R www-data:www-data /var/run/nginx.pid && \
#  chown -R www-data:www-data /var/cache/nginx && \
#  chown -R www-data:www-data /var/log/nginx && \
#  chmod -R 755 /var/log/nginx
#
#RUN sed -i 's/;listen.mode = 0660/listen.mode = 0660/g' /etc/php/7.0/fpm/pool.d/www.conf
##RUN sed -i 's/;listen.owner = www-data/listen.owner = nginx/g' /etc/php/7.0/fpm/pool.d/www.conf
##RUN sed -i 's/;listen.group = nginx/listen.group = nginx/g' /etc/php/7.0/fpm/pool.d/www.conf
#RUN sed -i 's/;listen.allowed_clients/listen.allowed_clients/g' /etc/php/7.0/fpm/pool.d/www.conf
#RUN /etc/init.d/php7.0-fpm start
#
##USER www-data