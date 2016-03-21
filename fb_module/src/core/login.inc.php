<?php
require_once dirname ( __FILE__ ) . '/fbapi.php';
$fb = fbapi_instance ();
$helper = $fb->getRedirectLoginHelper ();
$permissions = array (
		'manage_pages',
		'read_page_mailboxes',
		'pages_show_list',
		'publish_pages',
		'user_posts' 
); // optional
$FB_LOGIN_URL = $helper->getLoginUrl ( "http://{$_SERVER['SERVER_NAME']}/fb_module/callback.php", $permissions );