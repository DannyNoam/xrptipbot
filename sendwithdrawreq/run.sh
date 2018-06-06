#!/bin/bash

cd /var/log

if [ ! -e "app.log" ] ; then
    touch "app.log"
fi

echo "* *     * * *   root    php /data/processOne.php >/var/log/app.log" >> /etc/crontab
cron && tail -f app.log
