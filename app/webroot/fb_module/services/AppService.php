<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/29/16
 * Time: 8:43 PM
 */

namespace Services;

use Services\DebugService;
use Pusher;

class AppService
{
    protected $log;

    public function __construct()
    {
        $this->log = DebugService::getInstance();
    }

    public function sendToPusher($request)
    {
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

        $data['username'] = $request['username'];
        $data['message'] = $request['message'];
        $data['action'] = $request['action'];

        $pusher->trigger("vissale_channel_{$request['group_id']}", 'my_event', $data);
    }

    public function postJSONFaye($channel, Array $data = [], Array $ext = [], $server = null)
    {
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
}