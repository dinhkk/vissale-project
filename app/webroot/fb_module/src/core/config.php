<?php

if (!defined("APP_ENV")) {
    define('APP_ENV', 'production');
}
if (!defined("MODULE_PATH")) {
    define('MODULE_PATH', dirname(__DIR__));
}


switch (APP_ENV) {
    case 'local':
        include_once("env/local.php");
        break;

    case 'development':
        include_once("env/development.php");
        break;

    case 'production':
        include_once("env/production.php");
        break;
}
