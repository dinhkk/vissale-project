<?php
require_once dirname(__FILE__) . '/src/core/fbapi.php';
require_once dirname(__FILE__) . '/src/db/FBDBProcess.php';
$db = new FBDBProcess();
$config = $db->loadConfigByGroup(1, '"fb_app_id","fb_app_secret_key","fb_app_version"');
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
$FB_LOGIN_URL = $helper->getLoginUrl('http://job.8386.vn/reg_cb.php', $permissions);
header("Location: $FB_LOGIN_URL");