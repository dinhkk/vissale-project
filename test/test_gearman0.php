<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/19/17
 * Time: 8:21 AM
 */

$gmc   = new GearmanClient();
$server = '127.0.0.1';
$port = 4730;

$gmc->addServer($server, $port);

for ($i = 0 ; $i <= 20; $i++) {
    $gmc->doBackground("test_worker", json_encode(array(
        'message' => 'message-' . $i,
        'time'      => time(),
        'host'    => gethostname(),
    )));
}