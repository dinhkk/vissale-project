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
        $field = $data['entry']['changes'][0]['field'];

        if ( $field=='conversations' ) {
            return "conversations";
        }

        //comment detect
        $comment_data = $data['changes'][0]['value'];
        if ($field === 'feed' && $comment_data['item'] === 'comment' && $comment_data['verb'] === 'add') {
            return "comment";
        }

        return "unknown";
    }
}