<?php
/**
 * Thuc hien dong bo noi dung conversation 
 */
require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
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
if ($fb->syncChat ( $group_chat_id, $type )) {
	echo 'SUCCESS';
	exit ( 0 );
}
echo 'ERROR';
exit ( 0 );