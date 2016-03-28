<?php
/**
 * Thuc hien dong bo noi dung conversation
*/
// test
require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
if ($fb->fetchOrder( 6, 'WORKER_1','localhost' )) {
	echo 'SUCCESS';
	exit ( 0 );
}
echo 'ERROR';
exit ( 0 );