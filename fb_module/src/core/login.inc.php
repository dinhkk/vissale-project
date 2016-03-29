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

if (empty ( $_GET ['trans_id'] )) {
	echo 'NO_TRANSACTION';
	exit ( 0 );
}
if (empty ( $_GET ['group_id'] )) {
	echo 'NO_GROUP';
	exit ( 0 );
}
$trans_id = $_GET ['trans_id'];
$group_id = $_GET ['group_id'];
$FB_LOGIN_URL = $helper->getLoginUrl ( FB_APP_DOMAIN . '/callback.php', $permissions ) . "&transid=$trans_id&group_id=$group_id";