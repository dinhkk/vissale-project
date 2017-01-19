<?php
require_once dirname ( __FILE__ ) . '/../src/caching/FBSCaching.php';
require_once dirname ( __FILE__ ) . '/../src/caching/RedisCaching.php';
$caching = new FBSCaching ();
$redis = RedisCaching::getInstance();
$redis->clearAll();

echo $caching->clearCache () ? 'SUCCESS' : 'ERROR';