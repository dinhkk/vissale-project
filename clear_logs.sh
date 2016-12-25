#!/usr/bin/env bash
cd ..
cd /var/www/vissale.com/logs
truncate -s 0 error.log
truncate -s 0 access.log
truncate -s 0 vissale.com.error.log
truncate -s 0 app.vissale.error.log

rm -rf /var/www/vissale.com/logs/fbsale/*
