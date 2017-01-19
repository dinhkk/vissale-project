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

$gmc->doBackground("create_fb_conversation_messages_worker", json_encode(array(
    'level'   => 'aaa',
    'message' => 'bbb',
    'ts'      => time(),
    'host'    => gethostname(),
)));