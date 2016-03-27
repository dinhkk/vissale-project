<?php
/**
 * Tu dong lay don hang, reply comment cua khach hang trong post tren fanpage
 */
set_time_limit ( 0 );
require_once dirname ( __FILE__ ) . '/../FB.php';
$fb = new FB ();
$fb->fetchOrder ();