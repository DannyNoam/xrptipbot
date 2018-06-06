#!/bin/sh
cd /var/log

if [ ! -e "app.log" ] ; then
    touch "app.log"
fi

while [ 1 ]; do
    php /data/fetch_twitter_pbs.php >/var/log/app.log &
    sleep 15
    php /data/process_twitter_messages.php >/var/log/app.log &
    sleep 15
done