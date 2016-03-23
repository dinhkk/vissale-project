<?php
set_time_limit ( 0 );
require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
$fb->fetchConversation ();