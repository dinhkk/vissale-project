#!/usr/bin/env bash
cd ..
cd logs/
truncate -s 0 error.log
truncate -s 0 access.log
truncate -s 0 vissale.com.error.log
truncate -s 0 app.vissale.error.log
cd fbsale
rm -rf ./*
