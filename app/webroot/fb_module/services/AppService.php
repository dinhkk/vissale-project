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
use Facebook\Facebook;

class AppService
{
    protected $log;
    protected $redis;
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

    public function _getTelcoByPhone($phone)
    {
        $list_telco = array(
            'viettel' => array('098', '8498', '097', '8497', '096', '8496', '0169', '84169', '0168', '84168', '0167', '84167',
                '0166', '84166', '0165', '84165', '0164', '84164', '0163', '84163', '0162', '84162'),
            'vina' => array('8488', '8491', '8494', '84123', '84124', '84125', '84127', '84129', '091',
                '094', '0123', '0124', '0125', '0127', '0129'),
            'mobi' => array('8490', '8493', '84120', '84121', '84122', '84126', '84128', '8489', '090',
                '093', '0120', '0121', '0122', '0126', '0128'),
            'vietnamobile' => array('8492', '84188', '88186', '092', '0188'),
            'sphone' => array('8495', '095'),
            'gmobile' => array('8499', '84199', '099', '0199'),
        );

        $dauso = strlen($phone) === 11 ? substr($phone, 0, 4) : substr($phone, 0, 5);

        //return $dauso;

        if (in_array($dauso, $list_telco['viettel'])) {
            return 'viettel';
        } elseif (in_array($dauso, $list_telco['vina'])) {
            return 'vina';
        } elseif (in_array($dauso, $list_telco['mobi'])) {
            return 'mobi';
        } elseif (in_array($dauso, $list_telco['vietnamobile'])) {
            return 'vietnamobile';
        } elseif (in_array($dauso, $list_telco['sphone'])) {
            return 'sphone';
        } elseif (in_array($dauso, $list_telco['gmobile'])) {
            return 'gmobile';
        }
        return '';
    }

    function setRequestMessageData($phone, $msg_content, $fb_user_name, $group_id, $fb_conversation_id, $fb_user_id, $page_id, $message_time, $is_parent, $is_page, $message_id)
    {
        $request = [];

        $request['has_order'] = $phone ? 1 : 0;
        $request['message'] = $msg_content;
        $request['username'] = $fb_user_name;
        $request['group_id'] = $group_id;
        $request['conversation_id'] = $fb_conversation_id;
        $request['type'] = 0;
        $request['fb_user_id'] = $fb_user_id;
        $request['fb_user_name'] = $fb_user_name;
        $request['fb_page_id'] = $page_id;
        $request['fb_unix_time'] = $message_time;
        $request['is_read'] = 0;
        $request['is_parent'] = $is_parent;
        $request['is_page'] = $is_page;
        $request['message_id'] = $message_id;
        $request['action'] = "vừa gửi tin nhắn";

        return $request;
    }

    public function countReplyNoPhone($conversation_id)
    {
        $conversation = \Conversation::find($conversation_id);
        if (!$conversation) {
            return 0;
        }

        return $conversation->count_reply_nophone;
    }

    public function countReplyHasPhone($conversation_id)
    {
        $conversation = \Conversation::find($conversation_id);
        if (!$conversation) {
            return 0;
        }

        return $conversation->count_reply_hasphone;
    }

    /* $field = count_reply_hasphone, count_reply_nophone
     * $type = 0: no phone, 1: has phone
     *
     */
    public function updateCountReply($conversation_id, $type)
    {
        if (!in_array($type, [0, 1])) {
            return false;
        }

        if ($type == 0) {
            $field = 'count_reply_nophone';
        }
        if ($type == 1) {
            $field = 'count_reply_hasphone';
        }

        $conversation = \Conversation::find($conversation_id);
        if (!$conversation) {
            return false;
        }

        $conversation->$field += 1;

        return $conversation->save();
    }

    /*
     * Get message user information
     * get from redis cache
     * get from fb graph api
     * **/
    public function getFBUserProfile($fb_user_id, Facebook $fbApiInstance, $pageToken)
    {
        $fbObject = $fbApiInstance->get("/{$fb_user_id}", $pageToken);
        return json_decode($fbObject->getBody(), true);
    }

    /*
     * $type = "unknown" "message"
     *
     * **/
    public function detectCallbackRequest($data)
    {
        //$type = "unknown";
        if ( empty($data['object']) || $data['object'] != 'page') {
            return "unknown";
        }

        if ( !empty($data['entry'][0]['messaging'])) {
            return "message";
        }

        return "unknown";
    }
}
