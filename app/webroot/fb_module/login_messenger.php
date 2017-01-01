<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 12/20/16
 * Time: 5:24 PM
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/src/core/fbapi.php';

$action = "register";

//
if (empty($_GET['group_id'])) {
    die('NO_GROUP');
}
if ( !empty($_GET['action']) && $_GET['action']=="update" ) {
    $action = "update";
}


if ($action == "update" && (empty($_GET['group_id']) || !is_numeric($_GET['group_id'])) ) {
    die('NO_GROUP');
}

$_SESSION['group_id'] = $_GET['group_id'];

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

$loginUrl = $helper->getLoginUrl(FB_APP_DOMAIN . "/messenger_login_callback.php?action={$action}", $permissions);
header("Location: $loginUrl");