#!/usr/bin/env bash

cd .git/
chmod -R g+rwX .
chgrp -R nginx .
find . -type d -exec chmod g+s '{}' +

git pull

composer instatll

cd app

composer install
