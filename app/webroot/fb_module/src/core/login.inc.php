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
$app_config = null;
foreach ($config as $conf){
    if ($conf['_key']=='fb_app_id'){
        $app_config['fb_app_id'] = $conf['value'];
    }elseif ($conf['_key']=='fb_app_secret_key'){
        $app_config['fb_app_secret_key'] = $conf['value'];
    }else if ($conf['_key']=='fb_app_version'){
        $app_config['fb_app_version'] = $conf['value'];
    }
}
$fb = fbapi_instance($app_config);

$fb = getAppFB($app_config, $_GET['group_id']);

if (empty($fb)) {
    die('PROCESS_FAIL');
}

$helper = $fb->getRedirectLoginHelper();
$permissions = array(
    'manage_pages',
    'read_page_mailboxes',
    'publish_pages',
    'user_posts',
    //'publish_actions',
    'pages_messaging',
    //'pages_messaging_phone_number',
    //'pages_messaging_subscriptions'

); // optional
   
// if (empty ( $_GET ['trans_id'] )) {
   // echo 'NO_TRANSACTION';
   // exit ( 0 );
   // }
$_SESSION['group_id'] = $_GET['group_id'];
$FB_LOGIN_URL = $helper->getLoginUrl(FB_APP_DOMAIN . '/callback.php', $permissions);