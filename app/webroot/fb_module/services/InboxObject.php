<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/13/17
 * Time: 10:13 PM
 */

namespace Services;


class InboxObject extends AppService
{
    //declare variables
    private $has_order = 0; //has order or not
    private $message = null; //inbox content
    private $attachments = null; //attachment of inbox
    private $username = null; //fb full name of user of fb-app get via graph
    private $group_id = null; //group_id
    private $conversation_id = null; //
    private $type = 0; //type =0, this is a inbox message
    private $fb_user_id = null; //fb-user-id, get via graph api
    private $fb_user_name = null; //fb full name of user of fb-app get via graph
    private $fb_page_id = null; //page_id  of fanpage facebook
    private $fb_unix_time = null; // unix time facebook sent message to server
    private $is_read = 0; //default message is not read yet
    private $is_parent = 0; // is this message is parent message, which was sent from beginning to server
    private $is_page = 0; //boolean, is this a inbox of fanpage
    private $message_id = null; //String, a mid of facebook - message id
    private $action = "vừa gửi tin nhắn"; //String, message to send to browser


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getHasOrder()
    {
        return $this->has_order;
    }

    /**
     * @param int $has_order
     */
    public function setHasOrder($has_order)
    {
        $this->has_order = $has_order;
    }

    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param null $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return null
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param null $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @return null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param null $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return null
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @param null $group_id
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
    }

    /**
     * @return null
     */
    public function getConversationId()
    {
        return $this->conversation_id;
    }

    /**
     * @param null $conversation_id
     */
    public function setConversationId($conversation_id)
    {
        $this->conversation_id = $conversation_id;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return null
     */
    public function getFbUserId()
    {
        return $this->fb_user_id;
    }

    /**
     * @param null $fb_user_id
     */
    public function setFbUserId($fb_user_id)
    {
        $this->fb_user_id = $fb_user_id;
    }

    /**
     * @return null
     */
    public function getFbUserName()
    {
        return $this->fb_user_name;
    }

    /**
     * @param null $fb_user_name
     */
    public function setFbUserName($fb_user_name)
    {
        $this->fb_user_name = $fb_user_name;
    }

    /**
     * @return null
     */
    public function getFbPageId()
    {
        return $this->fb_page_id;
    }

    /**
     * @param null $fb_page_id
     */
    public function setFbPageId($fb_page_id)
    {
        $this->fb_page_id = $fb_page_id;
    }

    /**
     * @return null
     */
    public function getFbUnixTime()
    {
        return $this->fb_unix_time;
    }

    /**
     * @param null $fb_unix_time
     */
    public function setFbUnixTime($fb_unix_time)
    {
        $this->fb_unix_time = $fb_unix_time;
    }

    /**
     * @return int
     */
    public function getIsRead()
    {
        return $this->is_read;
    }

    /**
     * @param int $is_read
     */
    public function setIsRead($is_read)
    {
        $this->is_read = $is_read;
    }

    /**
     * @return int
     */
    public function getIsParent()
    {
        return $this->is_parent;
    }

    /**
     * @param int $is_parent
     */
    public function setIsParent($is_parent)
    {
        $this->is_parent = $is_parent;
    }

    /**
     * @return int
     */
    public function getIsPage()
    {
        return $this->is_page;
    }

    /**
     * @param int $is_page
     */
    public function setIsPage($is_page)
    {
        $this->is_page = $is_page;
    }

    /**
     * @return null
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * @param null $message_id
     */
    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }



    /**
     * detect mid, message_id from callback
     * @param callback $data
     * @return string $mid
     */

    public function get_mid_from_callback_data($data){

        $mid = !empty($data['messaging'][0]['message']['mid']) ? $data['messaging'][0]['message']['mid'] : null;

        //set cache if message is not existed
        $isExisting = false;
        if ($mid) {
            $isExisting = $this->redis->get($mid);
        }
        if (! $isExisting) {
            $this->set_cache_by_mid($data);
        }

        return $mid;
    }


    /**
     * @param $callback_data
     */
    private function set_cache_by_mid($callback_data){

        $this->log->debug('$callback_data', $callback_data);

        $mid = $callback_data['messaging'][0]['message']['mid'];

        $this->log->debug('$mid', $mid);

        $sender = $callback_data['messaging'][0]['sender']['id'];
        //set sender id
        $this->setFbUserId($sender);
        //
        $page_id = $callback_data['id'];
        $this->setFbPageId($page_id);

        $storage = array(
            'sender_id' => $sender,
            'page_id' => $page_id
        );
        //store cache in 10 min
        $this->redis->set($mid, $storage, 600);
    }

}