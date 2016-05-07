<?php
define ( 'WORKER_NAME', 'FC_WORKER_1' );
require_once dirname ( __FILE__ ) . '/../../../FB.php';
$worker = new GearmanWorker ();
$worker->addServer ( 'localhost', 4730 );
// Register and add callback function
$worker->addFunction ( 'fetchConversation', 'fetchConversation' );
// worker will execute the task whenever it finds by running in loop waiting for jobs.
// Each time a job is received, the callback function(call_update_user_information) will run.
while ( 1 ) {
	$worker->work ();
}
// Below function will be called for worker when client add a task and worker receives it.
function fetchConversation($job) {
	// Moi worker se xu ly cho 1 page
	$fb_page_id = $job->workload ();
	echo date ( 'd-m-Y H:i:s' ) . ' => ' . WORKER_NAME . "dang xu ly fb_page_id={$fb_page_id}" . PHP_EOL;
	// thuc hien xu ly
	$fb = new FB ();
	$fb->fetchConversation( $fb_page_id, WORKER_NAME, gethostname () );
	echo date ( 'd-m-Y H:i:s' ) . ' => ' . WORKER_NAME . "da xu ly XONG fb_page_id={$fb_page_id}" . PHP_EOL;
	//
	return true;
}