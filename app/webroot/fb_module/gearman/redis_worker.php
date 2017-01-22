<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/21/17
 * Time: 5:48 PM
 */

cli_set_process_title ( "redis_worker.php" );

$worker = new GearmanWorker();
$worker->addServer("127.0.0.1", 4730);

//initial functions
$path = dirname( __DIR__ ) . "/vendor/autoload.php";
include_once($path);

#delete_redis_cache_by_group_id
$worker->addFunction("delete_redis_cache_by_group_id", "delete_redis_cache_by_group_id");

#set_redis_created_inbox
$worker->addFunction("set_redis_created_inbox", "set_redis_created_inbox");

//initial functions
$path = dirname( __DIR__ ) . "/vendor/autoload.php";
include_once($path);

#delete_redis_cache_by_group_id
function delete_redis_cache_by_group_id(GearmanJob $job){
    $workload = json_decode( $job->workload(), true );
    // Save the logs to the database, write them to a single file, index them, ship them to splunk, whatever
    $appService = new \Services\AppService();
    $logObject = $appService->getLogObject();
    $logObject->debug("redis_worker get data", ['data' => $workload]);

    $group_id = $workload['group_id'];

    $redis = Services\RedisService::getInstance();
    $prefix =  $redis->getGroupPrefix($group_id) ;
    $keysToDel = $redis->findKeysByPrefix($prefix);
    $redis->deleteKeys($keysToDel);

    $logObject->debug("redis_worker deleted keys", ['keys' => $keysToDel]);
}

#set cache created inbox
function set_redis_created_inbox(GearmanJob $job)
{
    $workload = json_decode( $job->workload(), true );
    $appService = new \Services\AppService();
    $logObject = $appService->getLogObject();
    $logObject->debug("redis_worker set created inbox", ['inbox' => $workload]);

    $message_id = $workload['message_id'];
    $redis = Services\RedisService::getInstance();
    $key = "created_" . $message_id;
    $redis->set($key, 1, 600);

    $logObject->debug("set cache created key", ['key' => $key]);
}


//loop
while (1) {
    print "\nRedisWorker =>> Waiting for job...\n";
    $ret = $worker->work(); // work() will block execution until a job is delivered
    if ($worker->returnCode() != GEARMAN_SUCCESS) {
        break;
    }
}