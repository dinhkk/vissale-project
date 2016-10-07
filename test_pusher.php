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

$data['username'] = 'DINHKK';
$data['message'] = 'hello world group:124';
$pusher->trigger('vissale_channel_124', 'my_event', $data);