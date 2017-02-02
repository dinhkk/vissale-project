<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/29/16
 * Time: 7:16 PM
 */

/**
 * Cau hinh App facebook
 */

if (!defined("BASE_URL")) {
    define('BASE_URL', 'https://vissale.com/');
}

if (!defined("FB_APP_CALLBACK_URL")) {
    define('FB_APP_CALLBACK_URL', 'https://vissale.com/fb_module/fb_callback.php');
}
if (!defined("FB_APP_VERIFY_TOKEN")) {
    define('FB_APP_VERIFY_TOKEN', '0aaffee84f94dc316242d01bb7c94690');
}
if (!defined("FB_APP_ID")) {
    define('FB_APP_ID', '967811573302640');
}
if (!defined("FB_APP_SECRET")) {
    define('FB_APP_SECRET', '51b9c0cac5a277d1c86e356ad2a13b64');
}
if (!defined("FB_API_VER")) {
    define('FB_API_VER', 'v2.5');
}
if (!defined("FB_APP_DOMAIN")) {
    define('FB_APP_DOMAIN', 'http://login.vissale.com/');
}
if (!defined("CALLBACK_AFTER_SYNCPAGE")) {
    define('CALLBACK_AFTER_SYNCPAGE', 'https://vissale.com/FBPage');
}

/**
 * Trang thoi don hang mac dinh
 */

if (!defined("ORDER_STATUS_SUCCESS")) {
    define('ORDER_STATUS_SUCCESS', 5); // don hang da thanh cong

}
if (!defined("ORDER_STATUS_CANCELED")) {
    define('ORDER_STATUS_CANCELED', 9); // don hang da bi huy
}
if (!defined("ORDER_STATUS_DEFAULT")) {
    define('ORDER_STATUS_DEFAULT', 10); // trang thai mac dinh khi tao don hang

}

//mysql define
if (!defined("DB_HOST")) {
    define('DB_HOST', 'localhost');
}
if (!defined("DB_NAME")) {
    define('DB_NAME', 'fbsale');
}
if (!defined("DB_USER")) {
    define('DB_USER', 'fbsale');
}
if (!defined("DB_PASS")) {
    define('DB_PASS', '@abc12345');
}
if (!defined("APP_PATH")) {
    define('APP_PATH', '/var/www/vissale.com');
}


//job
if (!defined("SCHEDULE_START_TIME")) {
    define("SCHEDULE_START_TIME", "schedule_start_time"); //
}
if (!defined("SCHEDULE_END_TIME")) {
    define("SCHEDULE_END_TIME", "schedule_end_time"); //
}
if (!defined("JOB_START")) {
    define('JOB_START', 'job_start');
}
if (!defined("JOB_END")) {
    define('JOB_END', 'job_end');
}

//define log
if (!defined("ALLOW_KLOGGER")) {
    define('ALLOW_KLOGGER', true);
}

//push
if (!defined("FAYE_SERVER")) {
    define('FAYE_SERVER', 'http://vissale.com:8000');
}

require_once MODULE_PATH . '/php-activerecord/ActiveRecord.php';
require_once MODULE_PATH . '/PearLog/Log.php';
$module_path = MODULE_PATH;

ActiveRecord\Config::initialize(function ($cfg) use ($module_path) {

    $db_host = DB_HOST;
    $db_name = DB_NAME;
    $username = DB_USER;
    $password = DB_PASS;

    $cfg->set_model_directory($module_path . '/models');
    $cfg->set_connections(
        array('development' => "mysql://$username:$password@{$db_host}/{$db_name}?charset=utf8mb4")
    );

    //$cfg->set_cache("memcache://localhost");

    //set logs

//    $log_file = APP_PATH . '/logs/phpar.log';
//
//    if (ALLOW_KLOGGER && file_exists($log_file) and is_writable($log_file)) {
//        //include 'Log.php';
//
//        $logger = Log::singleton('file', $log_file, 'ident', array('mode' => 0664, 'timeFormat' => '%Y-%m-%d %H:%M:%S'));
//        $cfg->set_logging(true);
//        $cfg->set_logger($logger);
//
//
//    } else {
//        log_message('warning', 'Cannot initialize logger. Log file does not exist or is not writeable');
//    }


});



/*function createLog($message)
{
    $current_time = date ( 'Y-m-d H:i:s' );
    $logModel = new LogModel();
    $logModel->content = $message;
    $logModel->created_at = $current_time;
    $logModel->save();
}*/

