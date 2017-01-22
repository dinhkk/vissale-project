<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/21/17
 * Time: 5:36 PM
 */

require_once "/var/www/vissale.dev/htdocs/app/webroot/fb_module/vendor/autoload.php";

$redis = Services\RedisService::getInstance();
$prefix =  $redis->getGroupPrefix(34234) ;

//$redis->set($prefix . "key_1", "aaaa");
//$redis->set($prefix . "key_2", "bbbb");
//$redis->set($prefix . "key_3", "ccccc");

var_dump( $redis->get($prefix . "key_1") );
var_dump( $redis->get($prefix . "key_2") );
var_dump( $redis->get($prefix . "key_3") );


//gearman

$gmc   = new GearmanClient();
$server = '127.0.0.1';
$port = 4730;

$gmc->addServer($server, $port);


//
$gmc->doBackground("delete_redis_cache_by_group_id", json_encode(array(
    'group_id' => 34234
)));

//$keysToDel = $redis->findKeysByPrefix($prefix);

//var_dump( $keysToDel );

//$redis->deleteKeys($keysToDel);


var_dump( $redis->get($prefix . "key_1") );
var_dump( $redis->get($prefix . "key_2") );
var_dump( $redis->get($prefix . "key_3") );