#!/usr/bin/env bash
echo "restarting programs"
supervisorctl restart all
echo "supervisor status"
supervisorctl status
