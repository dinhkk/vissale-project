<?php
/**
 * Thuc hien dong bo noi dung conversation 
 */
require_once dirname ( __FILE__ ) . '/../FB.php';
$group_chat_id = intval ( $_GET ['group_chat_id'] );
if (! $group_chat_id) {
	echo 'ERROR';
	exit ( 0 );
}
$type = $_GET ['type'];
if (($type !== 'comment') && ($type !== 'inbox')) {
	echo 'ERROR';
	exit ( 0 );
}
$message = trim ( $_GET ['message'] );
if (empty ( $message )) {
	echo 'ERROR';
	exit ( 0 );
}
$fb = new FB ();
if ($fb->chat ( $group_chat_id, $message, $type )) {
	echo 'SUCCESS';
	exit ( 0 );
}
echo 'ERROR';
exit ( 0 );