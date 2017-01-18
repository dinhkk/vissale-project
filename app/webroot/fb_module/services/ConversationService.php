<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/29/16
 * Time: 9:44 PM
 */

namespace Services;


use Dompdf\Exception;

class ConversationService extends AppService
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * $type = "unknown" "message" "conversations" "comment"
     *
     * **/
    public function detectCallbackRequest($data)
    {

        if ( empty($data['object']) || $data['object'] != 'page') {
            return "unknown";
        }

        if ( !empty($data['entry'][0]['messaging'])) {
            return "message";
        }

        //comment or conversation changes
        $field = $data['entry'][0]['changes'][0]['field'];

        if ( $field=='conversations' ) {
            return "conversations";
        }

        //comment detect
        $comment_data = $data['entry'][0]['changes'][0]['value'];
        if ($field === 'feed' && $comment_data['item'] === 'comment' && $comment_data['verb'] === 'add') {
            return "comment";
        }

        return "unknown";
    }


    /**
     * @param $data
     * @param $fanPageConfig
     * @param $groupConfig
     * @return bool
     * tasks : write to DB, push to faye
     *
     */
    public function handleInboxMessage($data, $fanPageConfig, $groupConfig){
        $this->log->debug('PROCESS MESSENGER PLATFORM', []);
        $inboxObject = new \Services\InboxObject();

        $sender = null;
        $page_id = null;

        if ( $inboxObject->get_mid_from_callback_data($data) ) {
            $sender = $inboxObject->getFbUserId();
            $page_id = $inboxObject->getPageId();
        }

        $messageService = new MessageService();
        $inboxConversation = $messageService->getConversationInbox($sender, $page_id);

        //do nothing if conversation not exists
        if (! $inboxConversation ){
            $this->log->debug("inboxConversation not found", []);
            return false;
        }

        //if exist conversation, do more handle message
        //save new inboxConversation to DB
        $inboxObject->setInboxObjectFromCallbackData( $data, $inboxConversation );
        $this->createInboxMessage($inboxObject);
        //push to faye socket
        $this->log->debug("inbox message sent time =>" . ($data['time'] / 1000), []);
        $this->log->debug("created inbox message time =>" . time(), []);
        $this->postJSONFaye("/channel_group_{$inboxObject->getGroupId()}", $inboxObject->to_array(), [], null);

        die();
    }

    //
    public function createInboxMessage(InboxObject $inboxObject)
    {
        $this->log->debug("creating createInboxMessage()", []);

        $inboxMessage = new \InboxMessage();
        $inboxMessage->fb_conversation_id = $inboxObject->getConversationId();
        $inboxMessage->group_id = $inboxObject->getGroupId();
        //need to update customer id
        $inboxMessage->fb_customer_id = 0;
        $inboxMessage->fb_user_id = $inboxObject->getFbUserId();
        $inboxMessage->fb_user_name = $inboxObject->getFbUserName();
        $inboxMessage->fb_page_id = $inboxObject->getFbPageId();
        $inboxMessage->page_id = $inboxObject->getPageId();
        $inboxMessage->message_id = $inboxObject->getMessageId();
        $inboxMessage->content = $inboxObject->getMessage();
        $inboxMessage->attachments = '{"attachments":null,"shares":null}';
        $inboxMessage->user_created = $inboxObject->getFbUnixTime();
        $inboxMessage->created = date("Y-m-d H:i:s");
        $inboxMessage->modified = date("Y-m-d H:i:s");

        try {
            $inboxMessage->save();
        } catch (Exception $ex) {

            $this->log->error("Error saving createInboxMessage()", ['error' => $ex->getMessage() ] );
        }

    }


    /**
     * @param $messageData ,fields: conversation_id , message_id
     * process this with gearman system
     */
    public function update_inbox_conversation_messenger_id(Array $messageData)
    {
        //
        $job = "update_inbox_conversation_messenger_id";

        InboxGearmanClient::getInstance($job)->delivery($messageData);
    }

}