#!/usr/bin/env bash

echo "restart supervisor"
# /usr/bin/python /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
service supervisor restart

echo "restart gearman-job-server"

systemctl restart gearman-job-server
echo "restart php-fpm"
systemctl restart php-fpm
echo "restart mysql"
systemctl restart mysql
echo "restart redis-server"
systemctl restart redis
echo "restart nginx"
systemctl restart nginx