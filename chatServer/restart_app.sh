pm2 stop app
pm2 start app.js -x -- --prod --log-date-format "YYYY-MM-DD HH:mm Z"
pm2 logs
