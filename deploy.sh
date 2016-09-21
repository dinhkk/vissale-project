#!/usr/bin/env bash

git pull

cd app/

composer install &

cd webroot/fb_module/src/facebook_api

composer install &
