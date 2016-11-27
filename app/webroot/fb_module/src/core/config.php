<?php
/**
 * Cau hinh App facebook
 */
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
        array('development' => "mysql://$username:$password@{$db_host}/{$db_name}?charset=utf8mb4")
    );

    $cfg->set_cache("memcached://localhost");

    //set logs

    $log_file = APP_PATH . '/logs/phpar.log';

    if (ALLOW_KLOGGER && file_exists($log_file) and is_writable($log_file)) {
        //include 'Log.php';

        $logger = Log::singleton('file', $log_file, 'ident', array('mode' => 0664, 'timeFormat' => '%Y-%m-%d %H:%M:%S'));
        $cfg->set_logging(true);
        $cfg->set_logger($logger);
    } else {
        log_message('warning', 'Cannot initialize logger. Log file does not exist or is not writeable');
    }


});


/**
 * define pushing notification
 * $data = array('data' => uniqid());
 * $ext = array('ext' => 'sdssdf');
 * $channel = "/foo";
 * $url = "http://vissale.dev:8000/faye";
 */
if (!function_exists("postJSONFaye")) {
    function postJSONFaye($channel, Array $data = [], Array $ext = [], $server = null)
    {
        if (empty($server)) {
            $server = FAYE_SERVER;
        }

        $body = json_encode(array(
            'channel' => $channel,
            'data' => $data,
            'ext' => $ext,
        ));

        $curl = curl_init($server);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body),
        ));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}
/*function createLog($message)
{
    $current_time = date ( 'Y-m-d H:i:s' );
    $logModel = new LogModel();
    $logModel->content = $message;
    $logModel->created_at = $current_time;
    $logModel->save();
}*/

