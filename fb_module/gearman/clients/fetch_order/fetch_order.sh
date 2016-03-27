PID_FILE=$0.pid
[ -f $PID_FILE ] && {
   pid=`cat $PID_FILE`
   ps -p $pid && {
      echo -e "/usr/bin/php /var/www/fbsale.dinhkk.com/public_html/fb_module/gearman/clients/fetch_order/fetch_order.php processing ..."
      exit
   }
   rm -f $PID_FILE
}

echo $$ > $PID_FILE
      /usr/bin/php /var/www/fbsale.dinhkk.com/public_html/fb_module/gearman/clients/fetch_order/fetch_order.php
