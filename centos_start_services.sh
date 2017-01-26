#!/usr/bin/env bash
echo "starting supervisor"
/usr/bin/python /usr/bin/supervisord -c /etc/supervisor/supervisord.conf

echo "starting gearman-job-server"
systemctl start gearmand
echo "starting php-fpm"
systemctl start php-fpm
echo "starting mysql"
systemctl start mysql
echo "starting redis-server"
systemctl start redis
echo "restarting nginx"
systemctl start nginx