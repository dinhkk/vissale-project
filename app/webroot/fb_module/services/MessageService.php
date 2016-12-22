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

    public function getConversation()
    {

    }

    public function createConversation()
    {

    }

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

    public function modifyCallbackData($data)
    {
        $this->message['attachments'] = json_decode($data['messaging'][0]['message']['attachments']);
        $this->message['content'] = $data['messaging'][0]['message']['text'];
        $this->message['fb_user_id'] = $data['messaging'][0]['sender']['id'];
        $this->message['page_id'] = $data['id'];
        $this->message['user_created'] = $data['time'];
        $this->message['message_id'] = $data['messaging'][0]['message']['mid'];
    }

    public function initMessage($page, $data)
    {
        $this->page_id = $data['id'];
        $this->sender_id = $data['messaging'][0]['sender']['id'];

        //validate is page
        if ($this->page_id == $this->sender_id) {
            $this->isPage = true;
        }


    }

    public function getConversationRedis($page_id, $sender_id)
    {

    }

    public function getInboxAttachments($messages)
    {
        $attachments = array(
            'attachments' => [],
            'shares' => [],
        );
        if ( !empty($messages[0]['attachments']) ) {
            $attachments['attachments'] = $messages[0]['attachments'];
        }

        if ( !empty($messages[0]['shares']) && $this->isImageUrl($messages[0]['shares']['data'][0]['link'])) {
            $attachments['shares'] = $messages[0]['shares'];
        }

        return $attachments;
    }

}