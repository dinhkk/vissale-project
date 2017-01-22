<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 12/1/16
 * Time: 2:59 PM
 */

namespace Services;

use Dompdf\Exception;
use Facebook\Facebook;

class MessageService extends AppService
{
    private $conversation_id;
    private $conversation;
    private $message;
    private $isPage = false;
    private $page_id;
    private $sender_id;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool|mixed
     */
    public function createMessage()
    {
        try {
            $message = \InboxMessage::create($this->message);

            return $message->id;

        } catch (Exception $ex) {
            $this->log->error($ex->getMessage());
            return false;
        }
    }

    /**
     * @param $data
     */
    public function modifyCallbackData($data)
    {
        $this->message['attachments'] = json_decode($data['messaging'][0]['message']['attachments']);
        $this->message['content'] = $data['messaging'][0]['message']['text'];
        $this->message['fb_user_id'] = $data['messaging'][0]['sender']['id'];
        $this->message['page_id'] = $data['id'];
        $this->message['user_created'] = $data['time'];
        $this->message['message_id'] = $data['messaging'][0]['message']['mid'];
    }

    /**
     * @param $page
     * @param $data
     */
    public function initMessage($page, $data)
    {
        $this->page_id = $data['id'];
        $this->sender_id = $data['messaging'][0]['sender']['id'];

        //validate is page
        if ($this->page_id == $this->sender_id) {
            $this->isPage = true;
        }


    }

    /**
     * @param $messages
     * @return array
     */
    public function getInboxAttachments($messages)
    {
        $attachments = array(
            'attachments' => null,
            'shares' => null,
        );
        if ( !empty($messages[0]['attachments']) ) {
            $attachments['attachments'] = $messages[0]['attachments'];
        }

        if ( !empty($messages[0]['shares']) && $this->isImageUrl($messages[0]['shares']['data'][0]['link'])) {
            $attachments['shares'] = $messages[0]['shares'];
        }

        return $attachments;
    }


    /**
     * @param $sender_id
     * @param $page_id
     * @return null
     */
    public function getConversationInbox($sender_id, $page_id){

        //check redis first

        $inbox = $this->getConversationInboxFromRedis($sender_id, $page_id);
        if ( empty($inbox) ) {
            $inbox = $this->getConversationInboxFromDB($sender_id, $page_id);
        }

        return $inbox;
    }

    /**
     * @param $sender_id
     * @param $page_id
     */
    public function getConversationInboxFromRedis($sender_id, $page_id)
    {
        $redisKey = $sender_id.$page_id;

        return $this->redis->get($redisKey);
    }

    public function getConversationInboxFromDB($sender_id, $page_id)
    {
        $this->log->debug("getConversationInboxFromDB", []);
        $options = array(
            'conditions' => array(
                'messenger_fb_id = ? AND page_id = ?', $sender_id, $page_id
            )
        );
        $conversation = \Conversation::find('first', $options);

        $this->log->debug("getConversationInboxFromDB", [
            'sender' => $sender_id,
            'page_id' => $page_id,
            'Conversation' => !empty($conversation) ? $conversation->id : null
        ]);

        return !empty($conversation) ? $conversation->to_array() : null;
    }


    public function isExistedInboxMessage($message_id)
    {
        $key = "created_" . $message_id;
        $inboxM = $this->redis->get($key);

        if (! empty($inboxM) ) {
            $this->log->debug("redis found created message_id = {$message_id}", []);
            return true;
        }


        //find from DB
        $options = array(
            'conditions' => array(
                'message_id = ?', $message_id
            )
        );
        $inboxM = \InboxMessage::find('first', $options);

        if (! empty($inboxM) ) {
            $this->log->debug("DB found created message_id = {$message_id}", []);
            return true;
        }

        return false;
    }
}