#!/usr/bin/env bash

git pull

cd app/

composer install &

path_fb_module="webroot/fb_module"

cd $path_fb_module && pwd

composer install &

path_facebook_api="src/facebook_api"

cd $path_facebook_api && pwd

composer install &


