<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/14/17
 * Time: 8:52 AM
 */


cli_set_process_title ( "inbox_worker.php" );

$worker = new GearmanWorker();
$worker->addServer("127.0.0.1", 4730);

$worker->addFunction("inbox_log", function (GearmanJob $job) {

    $workload = json_decode($job->workload());
    // Save the logs to the database, write them to a single file, index them, ship them to splunk, whatever
    printf(
        "Log line receieved - (%s @ %s) [%s] %s\n"
        , date(DATE_ISO8601, $workload->ts)
        , $workload->host
        , $workload->level
        , json_encode($workload->message)
    );

    // You can do more interesting things too, like scan for specific errors
    // and send out warnings, or having rolling counts of errors to alert on, etc
});


while (1) {
    print "Waiting for job...\n";
    $ret = $worker->work(); // work() will block execution until a job is delivered
    if ($worker->returnCode() != GEARMAN_SUCCESS) {
        break;
    }
}