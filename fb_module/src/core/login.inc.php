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
$loginUrl = $helper->getLoginUrl ( "http://{$_SERVER['SERVER_NAME']}/fanpage/test/callback.php", $permissions );

//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';