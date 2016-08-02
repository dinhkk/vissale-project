<?php
/**
 * Thuc hien dong bo noi dung conversation 
 */
require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
if ($fb->syncChat ( 6, 'inbox' )) {
	echo 'SUCCESS';
	exit ( 0 );
}
echo 'ERROR';
exit ( 0 );
