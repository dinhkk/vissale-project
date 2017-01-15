<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/29/16
 * Time: 9:44 PM
 */

namespace Services;


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

    public function handleInboxMessage($data, $fanPageConfig, $groupConfig){
        $this->log->debug('PROCESS MESSENGER PLATFORM');
        $inbox = new \Services\InboxObject();

        $sender = null;
        $page_id = null;
        if ( $inbox->get_mid_from_callback_data($data) ) {
            $sender = $inbox->getFbUserId();
            $page_id = $inbox->getFbPageId();
        }

        $messageService = new MessageService();
        $conversationInbox = $messageService->getConversationInbox($sender, $page_id);

        if (! $conversationInbox ){

        }
    }

    /**
     * @param $message_id
     * process this with gearman system
     */
    public function update_inbox_conversation_messenger_fb_id($message_id)
    {

    }
}