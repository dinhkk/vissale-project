<?php
define ( 'GROUP_ID', null );
require_once dirname ( __FILE__ ) . '/../../../FB.php';
echo 'START CLIENT AT ' . date ( 'd-m-Y H:i:s' );
$fb = new FB ();
echo 'Load page' . PHP_EOL;
$pages = $fb->loadFanpge ( GROUP_ID );
if (! $pages) {
	echo 'Not found page' . PHP_EOL;
}
$client = new GearmanClient ();
// Add a job server to the client, can give any ip where job server to add.
$client->addServer ( 'localhost', 4730 );
// For each user add a gearman job to do
foreach ( $pages as $fb_page_id ) {
	// tao ra 10 client
	// Add a background task to be run in parallel.
	echo "Process for page_id=$fb_page_id" . PHP_EOL;
	print $client->doBackground ( 'fetchOrder', $fb_page_id );
	echo 'Processing ...' . PHP_EOL;
}