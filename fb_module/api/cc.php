<?php
require_once dirname ( __FILE__ ) . '/../src/caching/FBSCaching.php';
$caching = new FBSCaching ();
echo $caching->clearCache () ? 'SUCCESS' : 'ERROR';