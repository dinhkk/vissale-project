<?php
require_once dirname ( __FILE__ ) . '/fbapi.php';
$fb = fbapi_instance ();
$helper = $fb->getRedirectLoginHelper ();
$permissions = array (
		'manage_pages',
		'read_page_mailboxes',
		'pages_show_list',
		'publish_pages',
		'read_mailbox' 
); // optional
$FB_LOGIN_URL = $helper->getLoginUrl ( FB_CALLBACK_URL, $permissions );