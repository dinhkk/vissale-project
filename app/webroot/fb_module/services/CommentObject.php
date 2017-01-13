<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 11/29/16
 * Time: 8:05 PM
 */

namespace Services;

class CommentObject extends AppService
{

    private $has_order = 0; //has order or not
    private $message = null; //String, = content of comment
    private $attachment =  null; //String, json string of comment attachment
    private $username = null; // fb full name of sender, who sent comment
    private $group_id = 0; // int, group id of system
    private $conversation_id = 0; //int conversation_id in DB
    private $fb_user_id = null; //String, the scope fb-user-id of app, got via graph api
    private $fb_user_name = null; //String full-name of user
    private $fb_page_id = null; // String, page-id of facebook fan-page
    private $fb_unix_time = 0; //int, the unix timestamp facebook sent message
    private $is_parent = 0; //int, is this a first comment, parant comment
    private $type = 1;// int, this is a comment
    private $is_read = 0; //int, default message is unread
    private $post_id = null; //String, post_id of page-post , photo,
    private $action = "vừa gửi nhận xét";


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
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param null $attachment
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
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
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @param int $group_id
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
    }

    /**
     * @return int
     */
    public function getConversationId()
    {
        return $this->conversation_id;
    }

    /**
     * @param int $conversation_id
     */
    public function setConversationId($conversation_id)
    {
        $this->conversation_id = $conversation_id;
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
     * @return int
     */
    public function getFbUnixTime()
    {
        return $this->fb_unix_time;
    }

    /**
     * @param int $fb_unix_time
     */
    public function setFbUnixTime($fb_unix_time)
    {
        $this->fb_unix_time = $fb_unix_time;
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
    public function getType()
    {
        return $this->type;
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
     * @return null
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param null $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}