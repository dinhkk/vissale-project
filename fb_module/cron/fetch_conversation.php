<?php
/**
 * Thuc hien lay nhung inbox moi cua khach hang
 * va tu dong reply lai khach hang
 */
set_time_limit ( 0 );
require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
$fb->fetchConversation ();