#!/bin/bash

if [ ! -e "app.log" ] ; then
    touch "app.log"
fi

sleep 10; cd /app/; while true; do node app.js > app.log; echo $(date)" Crashed. Restarting..."; done
