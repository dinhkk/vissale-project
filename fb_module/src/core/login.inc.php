<?php
if (empty($_GET['group_id'])) {
    echo 'NO_GROUP';
    exit(0);
}
require_once dirname(__FILE__) . '/fbapi.php';
require_once dirname(__FILE__) . '/../db/FBDBProcess.php';
$db = new FBDBProcess();
$config = $db->loadConfigByGroup($_GET['group_id'], '"fb_app_id","fb_app_secret_key","fb_app_version"');
if (! $config) {
    die('CONFIG_NOTFOUND');
}
$fb = fbapi_instance($config);
$helper = $fb->getRedirectLoginHelper();
$permissions = array(
    'manage_pages',
    'read_page_mailboxes',
    'pages_show_list',
    'publish_pages',
    'user_posts'
); // optional
   
// if (empty ( $_GET ['trans_id'] )) {
   // echo 'NO_TRANSACTION';
   // exit ( 0 );
   // }
$_SESSION['group_id'] = $_GET['group_id'];
$FB_LOGIN_URL = $helper->getLoginUrl(FB_APP_DOMAIN . '/callback.php', $permissions);