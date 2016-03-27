<?php
require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
$fb->fetchConversation ( 8, 'WORKER_1', '45.117.80.243' );