<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 10/7/16
 * Time: 4:24 PM
 */

require_once("vendor/autoload.php");

$options = array(
    'cluster' => 'ap1',
    'encrypted' => true
);
$pusher = new Pusher(
    '290cab8409da897eb293',
    'dd521c32ac671af0f630',
    '256841',
    $options
);

$data['message'] = 'hello world';
$pusher->trigger('vissale_channel_173', 'my_event', $data);