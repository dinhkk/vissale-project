<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 12/10/16
 * Time: 4:57 PM
 */


define('FAYE_SERVER', 'https://vissale.com:8001/');
function postJSONFaye($channel, Array $data = [], Array $ext = [], $server = null) {

    if (empty($server)) {
        $server = FAYE_SERVER;
    }

    $body = json_encode(array(
        'channel' => $channel,
        'data' => $data,
        'ext' => $ext,
    ));

    $curl = curl_init($server);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($body),
    ));

    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
}

$channel = "/channel_group_457";
$data = array(
    'title' => 'tieu de',
    'message' => 'noi dung message'
);
$curlResult = postJSONFaye($channel, $data);

var_dump($curlResult);