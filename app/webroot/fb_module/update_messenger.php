<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/1/17
 * Time: 3:53 PM
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/src/core/fbapi.php';

$action = "register";

//validate action

$fb = fbapi_messenger_instance();
$helper = $fb->getRedirectLoginHelper();

$permissions = array(
    'manage_pages',
    'read_page_mailboxes',
    'publish_pages',
    //'user_posts',
    //'publish_actions',
    'pages_messaging',
    //'pages_messaging_phone_number',
    //'pages_messaging_subscriptions'

); // optional

$loginUrl = $helper->getLoginUrl(FB_APP_DOMAIN . "/messenger_login_callback.php", $permissions);
header("Location: $loginUrl");