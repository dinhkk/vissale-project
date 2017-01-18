<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/13/17
 * Time: 9:32 PM
 */

//connect
$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379, 1); // 2.5 sec timeout. 100ms delay between reconnection attempts.

//init options
$redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);

//test methods
/*
 * method info();
 **/
//var_dump( $redis->info() );
//var_dump( $redis->info("COMMANDSTATS") );
//var_dump( $redis->info("CPU") );



//test setkey
// $redis->set('key', 'value1');
//$redis->set('key', 'value2222');

//$redis->pSetEx('key', 3000, 'value');

//$array = ["a", "b"];
//$redis->setex('key', 3, $array);

// var_dump( $redis->get('mid.1484450712376:166d2de119') );

$redis->flushDb();

