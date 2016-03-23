<?php
/**
 * Dong bo noi dung conversation
 */
set_time_limit ( 0 );
require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
$fb->syncConversation (null,null,null);