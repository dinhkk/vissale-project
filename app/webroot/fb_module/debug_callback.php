<?php
require_once dirname(__FILE__) . '/src/core/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['hub_mode'] == 'subscribe' && $_GET['hub_verify_token'] == FB_APP_VERIFY_TOKEN) {
    echo $_GET['hub_challenge'];
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $path = "/var/www/fbsale.vingrowth.com/htdocs/app/webroot/fb_module/debug_callback.log";
    $content = json_decode(file_get_contents('php://input'), true);
    file_put_contents( $path, print_r($content, true) );
}

die(0);