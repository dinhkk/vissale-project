<?php
/**
 * Cau hinh App facebook
 */
define('FB_APP_CALLBACK_URL', 'https://vissale.com/fb_module/fb_callback.php');
define('FB_APP_VERIFY_TOKEN', '0aaffee84f94dc316242d01bb7c94690');
define('FB_APP_ID', '967811573302640');
define('FB_APP_SECRET', '51b9c0cac5a277d1c86e356ad2a13b64');
define('FB_API_VER', 'v2.5');
define('FB_APP_DOMAIN', 'http://login.vissale.com/');
define('CALLBACK_AFTER_SYNCPAGE', 'https://vissale.com/FBPage');

/**
 * Trang thoi don hang mac dinh
 */

define('ORDER_STATUS_SUCCESS', 5); // don hang da thanh cong
define('ORDER_STATUS_CANCELED', 9); // don hang da bi huy
define('ORDER_STATUS_DEFAULT', 10); // trang thai mac dinh khi tao don hang

define('DB_HOST', 'localhost');
define('DB_NAME', 'fbsale');
define('DB_USER', 'fbsale');
define('DB_PASS', '@abc12345');

define('APP_PATH', '/var/www/vissale.com');

//job
define("SCHEDULE_START_TIME", "schedule_start_time"); //
define("SCHEDULE_END_TIME", "schedule_end_time"); //
define('JOB_START', 'job_start');
define('JOB_END', 'job_end');


$path_orm = dirname(__DIR__);
require_once $path_orm . '/php-activerecord/ActiveRecord.php';
require_once $path_orm . '/PearLog/Log.php';

ActiveRecord\Config::initialize(function ($cfg) use($path_orm) {

    $db_host = DB_HOST;
    $db_name = DB_NAME;
    $username = DB_USER;
    $password = DB_PASS;

    $cfg->set_model_directory( $path_orm . '/models');
    $cfg->set_connections(
        array('development' => "mysql://$username:$password@{$db_host}/{$db_name}?charset=utf8")
    );

    //set logs

    $log_file = APP_PATH . '/logs/phpar.log';

    if (file_exists($log_file) and is_writable($log_file)) {
        //include 'Log.php';

        $logger = Log::singleton('file', $log_file, 'ident', array('mode' => 0664, 'timeFormat' => '%Y-%m-%d %H:%M:%S'));
        $cfg->set_logging(true);
        $cfg->set_logger($logger);
    } else {
        log_message('warning', 'Cannot initialize logger. Log file does not exist or is not writeable');
    }


});


function createLog($message)
{
    $current_time = date ( 'Y-m-d H:i:s' );
    $logModel = new LogModel();
    $logModel->content = $message;
    $logModel->created_at = $current_time;
    $logModel->save();
}

