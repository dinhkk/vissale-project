#!/usr/bin/env bash
echo "starting supervisor"
/usr/bin/python /usr/bin/supervisord -c /etc/supervisor/supervisord.conf

echo "starting gearman-job-server"
systemctl start gearman-job-server
echo "starting php5.6-fpm"
systemctl start php5.6-fpm
echo "starting mysql"
systemctl start mysql
echo "starting redis-server"
systemctl start redis-server
echo "restarting nginx"
systemctl start nginx