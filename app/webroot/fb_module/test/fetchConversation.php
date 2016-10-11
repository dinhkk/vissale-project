<?php
/*require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
$fb->fetchConversation ( 8, 'WORKER_1', '45.117.80.243' );*/

require_once dirname(__FILE__) . '/../src/core/config.php';
require_once dirname(__FILE__) . '/../FB.php';
require_once dirname(__FILE__) . '/../src/db/FBDBProcess.php';

$db = new FBDBProcess();

$db->loadConversation(null,null, "1109781745757296_1110150235720447");
