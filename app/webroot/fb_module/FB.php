<?php

require_once dirname(__FILE__) . '/src/db/FBDBProcess.php';
require_once dirname(__FILE__) . '/src/caching/FBSCaching.php';
require_once dirname(__FILE__) . '/src/core/Fanpage.core.php';
require_once dirname(__FILE__) . '/src/core/config.php';
require_once("vendor/autoload.php");

use Services\DebugService;
use Services\MessageService;
use Services\ConversationService;

class FB extends \Services\AppService
{

    private $db = null;
    private $config = null;
    private $caching = null;
    protected $log;
    private $groupConfig;
    private $isPage = false;
    private $msgHasPhone = false;
    private $conversationService;
    private $isAutoReply = false;

    public function __construct()
    {
        parent::__construct();

        $this->caching = new FBSCaching();
        $this->groupConfig = new \Services\GroupConfig();
        $this->conversationService = new ConversationService();

    }

    private function _getDB()
    {
        if ($this->db === null) {
            $this->db = new FBDBProcess();
        }
        return $this->db;
    }

    public function run($callbackData)

    {

        //detect
        $this->log->debug( 'json_content', [
            'fb-json' => json_encode($callbackData),
            'detect-request' => $this->conversationService->detectCallbackRequest($callbackData)
        ] );

        if ($this->conversationService->detectCallbackRequest($callbackData) == "unknown") {
            $this->log->error("request is unknown", $callbackData);
            die();
        }


        $data = $callbackData['entry'][0];
        //run tasks
        //$this->log->debug("CALLBACK DATA:", $data);

        //test page id =
        if ($data['id'] != '569949069823753') {
            $this->log->error("request for page_id is dead {$data['id']}", []);
            die();
        }

        //load page
        $page = $this->_getPageInfo($data['id']);
        $this->pageData = $page;

        if (empty($page)) {
            $this->log->error("page not found", $data);
            die;
        }

        $this->_loadConfig(array(
            'page_id' => $data['id']
        ));

        if (! $this->config) {
            return false;
        }
        //set GroupConfig
        $this->groupConfig->setGroup($page['group_id']);
        $this->groupConfig->setConfig($this->config);
        $this->groupData = $this->getGroup( $page['group_id'] );

        ///
        $this->log->debug("group config {$page['group_id']}", array(
            'isReplyCommentByTime' => $this->groupConfig->isReplyCommentByTime(),
            'group_id' => $page['group_id']
        ));

        $this->log->debug( "request type", array("request" => $this->conversationService->detectCallbackRequest($callbackData)) );

        //handle inbox message
        if ($this->conversationService->detectCallbackRequest($callbackData) == "message") {
            $this->log->debug( "request type message, handling ...", []);

            return $this->conversationService->handleInboxMessage($data, $this->config, $this->groupConfig);
        }

        //

        $field = $data['changes'][0]['field'];
        $comment_data = $data['changes'][0]['value'];
        if ($field === 'feed' && $comment_data['item'] === 'comment' && $comment_data['verb'] === 'add') {
            LoggerConfiguration::logInfo('PROCESS COMMENT');

            return $this->processComment($data['id'], $comment_data);

        } elseif ($field === 'conversations') {

            $this->log->debug('PROCESS CONVERSATION');

            return $this->processConversation($data['id'], $data, $data['time']);
        }
        LoggerConfiguration::logInfo('DONT PROCESS THIS CALLBACK DATA');
        return false;
    }

    private function _getParentComment($parent_id, $page_id, $post_id, $comment_id)
    {
        return ($parent_id == $post_id) || (strpos($parent_id, $page_id) !== false) ? $comment_id : $parent_id;
    }

    protected function processComment($page_id, $comment_data)
    {
        $this->log->debug("call processComment step-1: ", array('page_id' => $page_id, 'comment_data'  => $comment_data, __FILE__, __LINE__));


        $fb_user_id = $comment_data['sender_id'];
        LoggerConfiguration::logInfo("CHECK FB_USER_ID=$fb_user_id");
        if ($this->_isSkipFBUserID($fb_user_id, $page_id)) {
            return false;
        }

        LoggerConfiguration::logInfo("GET PAGE ID=$page_id");
        $page = $this->_getPageInfo($page_id);
        if (! $page || $page['status'] != 0) {
            return false;
        }
        $fanpage_token_key = $page['token'];
        $fb_page_id = $page['id'];
        $group_id = $page['group_id'];
        $post_id = $comment_data['post_id'];
        LoggerConfiguration::logInfo("GET POST ID=$post_id");

        $message = !empty($comment_data['message']) ? $comment_data['message'] : "";
        //thực hiện lấy nội dung comment
        $getComment = $this->_loadFBAPI()->getCommentMessage($comment_data['comment_id'], $fanpage_token_key);
        $comment_attachment = !empty($getComment['attachment']) ? json_encode($getComment['attachment']) : null;

        //check is page page message
        if ($page_id == $fb_user_id) {
            $this->isPage = true;
        }

        if (empty($message) && empty($comment_attachment)) {
            $this->log->error("không lấy được nội dung comment", array('group_id' => $group_id, 'page_id' => $page_id, 'comment_data' => $comment_data, __FILE__, __LINE__));

            die;
        }

        $comment_id = $comment_data['comment_id'];
        $fb_post_id = $post_id;
        $parent_comment_id = $this->_getParentComment($comment_data['parent_id'], $page_id, $post_id, $comment_id);

        /*$product_id = $post['product_id'];
        $bundle_id = $post['bundle_id'];*/
        $product_id = $post_id;
        $bundle_id = 0;

        $price = 0;
        $fb_user_name = $comment_data['sender_name'];
        $comment_time = $comment_data['created_time'];


        LoggerConfiguration::logInfo('CHECK WORD IN BLACKLIST');

        if ($word = $this->_isWordsBlackList($message)) {
            sleep(1); //sleep to avoid banning app
            $this->_hideComment($comment_id, $post_id, $page_id, $fanpage_token_key);
            return false;
        }

        $fb_customer_id = 0;

        LoggerConfiguration::logInfo('PROCESS COMMENT CHAT');

        $added_comment = $this->_processCommentChat($group_id, $page_id, $fb_page_id,
            $post_id, $fb_post_id, $fb_user_id, $fb_user_name, $comment_id,
            $parent_comment_id, $message, $comment_attachment, $fb_customer_id, $comment_time);

        $fb_comment_id = $added_comment['fb_comment_id'];

        $this->log->debug("call processComment step-2: ", array('page_id' => $page_id, 'comment_data'  => $comment_data, 'facebook_comment_id' => $comment_id, 'post_comment_id' => $fb_comment_id, 'message' => $message, __FILE__, __LINE__));

        if ( $fb_comment_id == 0 ) {
            // truong hop loi FB: goi nhieu lan => comment bi trung nhau
            // bo qua (Chua biet co dung khong)
            $this->log->error('THIS COMMENT HAD PROCESSED BEFORE', array(__CLASS__, __FUNCTION__, __LINE__));
            return false;
        }

        $fb_conversation_id = $added_comment['fb_conversation_id'];

        //can dem so luong comment da tra loi.
        $count_replied_has_phone = $this->_getDB()->countRepliedComment($fb_conversation_id, $page_id, 1);
        $count_replied_no_phone = $this->_getDB()->countRepliedComment($fb_conversation_id, $page_id, 0);

        $count_replied_has_phone_parent_comment = $this->_getDB()->countParentPostComment($fb_user_id, $page_id, $post_id, 1);
        $count_replied_no_phone_parent_comment = $this->_getDB()->countParentPostComment($fb_user_id, $page_id, $post_id, 0);

        $phone = $this->_includedPhone($message);
        $this->log->debug('CHECK MESSAGE : ' . $message);
        $this->log->debug('CHECK PHONE : ' . $phone);

        $this->log->debug("Debug count replies of $fb_conversation_id", array(
            "hasPhone" => $count_replied_has_phone,
            "noPhone" => $count_replied_no_phone,
            )
        );


        //process comment has phone
        if ($phone != false) {
            $this->log->debug('PROCESSING COMMENT HAS PHONE -->');


            $this->log->debug('CHECK PHONE IN BLACKLIST');
            if ( $this->_isPhoneBlocked($phone) ) {
                sleep(1);
                $this->_hideComment($comment_id, $post_id, $page_id, $fanpage_token_key);
                return false;
            }
            LoggerConfiguration::logInfo('CREATE ORDER');
            $telco = $this->_getTelcoByPhone($phone);

            $order = $this->_processOrder($phone, $fb_user_id, $fb_user_name, $post_id, $fb_post_id, $page_id, $fb_page_id, $group_id, $product_id, $fb_comment_id, $bundle_id, $price, $telco);

            $fb_customer_id = $order ? $order['fb_customer_id'] : 0;

            $willReply = true;

            if ( $count_replied_has_phone > 0 ){
                $this->log->debug('PROCESS COMMENT HASPHONE -- INSERT ORDER AND NOT AUTO REPLY');
                $willReply = false;
            }

            if ($count_replied_has_phone_parent_comment > 1) {
                $this->log->debug("fb_user_id {$fb_user_id} da de lai sdt tren post_id {$post_id}");
                $willReply = false;
            }

            $this->_processCommentHasPhone($group_id, $fb_page_id, $fb_post_id, $fb_conversation_id, $fb_customer_id,
                                            $parent_comment_id,
                                            $comment_id, $post_id, $page_id,
                                            $fanpage_token_key,
                                            $this->config['reply_comment_has_phone'], $willReply, $fb_user_id, $fb_user_name);


        } //process comment has no phone
        else {
            $this->log->debug('PROCESSING COMMENT HAS NO PHONE -->');


            $willReply = true;

            if ($count_replied_has_phone > 0 && $count_replied_no_phone > 0 ) {
                $willReply = false;
            }
            if ($count_replied_no_phone > 0 ) {
                $willReply = false;
            }


            if ($count_replied_has_phone_parent_comment > 1 && $count_replied_no_phone_parent_comment > 1) {
                $this->log->debug("fb_user_id {$fb_user_id} da de lai sdt tren post_id {$post_id} va da co auto comment ko co sdt");
                $willReply = false;
            }

            if ($count_replied_no_phone_parent_comment > 1) {
                $this->log->debug("da co auto comment ko co sdt 1 lan fb_user_id {$fb_user_id}, post_id {$post_id}");
                $willReply = false;
            }

            $this->log->debug('PROCESS COMMENT NOPHONE');

            $reply_comment_nophone = !empty($this->config['reply_comment_nophone']) ? $this->config['reply_comment_nophone'] : null;
            if (!$reply_comment_nophone) {
                $this->log->error("reply_comment_nophone is empty", array(
                    'group_id' => $group_id,
                    'page_id' => $fb_page_id,

                ));
            }

            $reply_by_scripting = null;
            $this->_processCommentNoPhone($group_id, $fb_page_id, $fb_post_id, $fb_conversation_id,
                $fb_customer_id, $parent_comment_id, $message, $comment_id, $comment_time, $post_id,
                $page_id, $fanpage_token_key, $reply_by_scripting, $this->config['reply_comment_nophone'] ,
                $willReply, $fb_user_id, $fb_user_name);
        }

        //push notification to pusher
        $request['has_order'] = $phone ? 1 : 0;
        $request['message'] = $message;
        $request['attachment'] = $comment_attachment;
        $request['username'] = $fb_user_name;
        $request['group_id'] = $group_id;
        $request['conversation_id'] = $fb_conversation_id;
        $request['fb_user_id'] = $fb_user_id;
        $request['fb_user_name'] = $fb_user_name;
        $request['fb_page_id'] = $page_id;
        $request['fb_unix_time'] = $comment_time;
        $request['is_parent'] = $added_comment['is_parent'];
        $request['type'] = 1;
        $request['is_read'] = 0;
        $request['post_id'] = $post_id;
        $request['action'] = "vừa gửi nhận xét";

        $this->postJSONFaye("/channel_group_{$group_id}", $request, [], null);
        if ($this->isPage) {
            return false;
        }

        $this->sendToPusher($request);
        exit(0); //end process comment
    }

    private $fb_api = null;


    //if $using_messenger, switching to using messenger app;
    private function _loadFBAPI()
    {
//        if ($this->fb_api === null) {
//            $this->fb_api = new Fanpage($this->config, $using_messenger);
//        }
//        return $this->fb_api;

        $this->log->debug("debug data _loadFBAPI()" , [
            'group-config' => $this->config,
            'group-data' => $this->groupData,
            'isAutoReply' => $this->isAutoReply
        ]);

        $appInstance = $this->getFbAppInstance($this->config, $this->groupData, $this->isAutoReply);
        if ( empty($appInstance) ) {
            $this->log->error("app instance is NULL return false", []);
            return false;
        }

        return new Fanpage( $appInstance );
    }

    private function _replyComment($comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key, $fb_user_id = null, $fb_user_name= null)
    {
        if (empty($message)) {
            return false;
        }
        LoggerConfiguration::logInfo("Reply message: $message");

        $this->log->debug("reply for fb_user_id : $fb_user_id:$fb_user_name");

        $attachment = null;
        return $this->_loadFBAPI()->reply_comment($comment_id, $post_id, $fanpage_id, $message, $attachment, $fanpage_token_key,
            $fb_user_id, $fb_user_name);
    }

    private function _processCommentHasPhone($group_id,
                                             $fb_page_id,
                                             $fb_post_id,
                                             $fb_conversation_id,
                                             $fb_customer_id, $parent_comment_id,
                                             $comment_id, $post_id, $fanpage_id,
                                             $fanpage_token_key, $post_reply_phone, $willReply = true,
                                             $fb_user_id = null, $fb_user_name = null)
    {
        $this->isAutoReply = true;

        $this->log->debug("xu ly comment co sdt post-{$fb_post_id}, will reply : {$willReply}");

        if ($willReply==false) {
            return false;
        }

        $message = $this->groupConfig->getReplyMessageForCommentHasPhone();

        $reply_type = 1; // tra loi cho comment co sdt

        $this->log->debug("xu ly comment co sdt post-{$fb_post_id}", array('message' => $message, 'fb_page_id' => $fanpage_id, 'post_id' => $fb_post_id, __FILE__, __LINE__));


        //
        if ($this->groupConfig->isHideCommentHasPhone()) {
            $this->_hideComment($comment_id, $post_id, $fanpage_id, $fanpage_token_key);
        }

        if (!$message || !$this->groupConfig->isReplyCommentByTime() || $this->isPage) {
            return false;
        }

        $this->log->debug("xu ly comment co sdt post-{$fb_post_id}", array('processing to auto comment', 'message' => $message, 'fb_page_id' => $fanpage_id, 'post_id' => $fb_post_id, __FILE__, __LINE__));

        //process auto comment
        if ($replied_comment_id = $this->_replyComment($parent_comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key, $fb_user_id, $fb_user_name)) {
            if ($fb_conversation_id) {
                $comment_time = time();
                $this->_getDB()->createCommentPostV2($group_id, $fanpage_id,
                    $fb_page_id, $post_id,
                    $fb_post_id,
                    $fanpage_id, $replied_comment_id, $fb_conversation_id,
                    $comment_id, $message, null,
                    $fb_customer_id, $comment_time, $reply_type, $fb_user_name);

                $this->_getDB()->updateConversationComment($fb_conversation_id, null, $comment_time, $fb_customer_id, true);
            }
        }

        //process reply private mesage
        $conversation = $this->_loadConversation(null, null, $parent_comment_id);

        //this automate action
        $this->isAutoReply = true;
        $this->_loadFBAPI()->reply_message_from_comment($conversation['id'], $comment_id, null, $conversation['page_id'], $message, $conversation['token'], $conversation['fb_user_id'], $conversation['fb_user_name']);


        //Like is end
        if ($this->groupConfig->isLikeComment()) {
            $this->_likeComment($comment_id, $fanpage_id, $fanpage_token_key);
        }
    }

    private function _processCommentNoPhone($group_id, $fb_page_id, $fb_post_id,
                                            $fb_conversation_id, $fb_customer_id, $reply_comment_id,
                                            $comment, $comment_id, $comment_time, $post_id, $fanpage_id,
                                            $fanpage_token_key, $post_reply_by_scripting, $post_reply_nophone,
                                            $willReply = true, $fb_user_id = null, $fb_user_name= null)
    {
        $this->isAutoReply = true;

        $this->log->debug('processing auto reply comment, which has no phone', array('willReply' => $willReply, 'fb_page_id' => $fanpage_id, 'post_id' => $fb_post_id, __CLASS__, __FUNCTION__, __FILE__, __LINE__));

        $message = $this->groupConfig->getReplyMessageForCommentHasNoPhone();
        if (!$message) {
            $this->log->error("Reply NoPhone Config is Empty.", array('group_id' => $group_id, 'fb_page_id' => $fb_page_id, 'fb_post_id' => $fb_post_id, '__FILE__' => __FILE__, '__LINE__' => __LINE__));
        }

        if ($this->groupConfig->isHideCommentHasNoPhone()) {
            $this->_hideComment($comment_id, $post_id, $fanpage_id, $fanpage_token_key);
        }

        $reply_type = 0;

        if ($willReply == false) {
            return false;
        }

        if (!$message || !$this->groupConfig->isReplyCommentByTime() || $this->isPage) {
            return false;
        }


            $this->log->debug('processing auto reply comment, which has no phone', array(__CLASS__, __FUNCTION__, __FILE__, __LINE__));

        if ($replied_comment_id = $this->_replyComment($reply_comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key, $fb_user_id, $fb_user_name)) {
            if ($fb_conversation_id) {
                $comment_time = time();
                $this->_getDB()->createCommentPostV2($group_id,
                    $fanpage_id, $fb_page_id, $post_id, $fb_post_id, $fanpage_id, $replied_comment_id,
                    $fb_conversation_id, $comment_id, $message, null, $fb_customer_id, $comment_time, $reply_type, $fb_user_name);
            }
        }

        //process reply private message
        $conversation = $this->_loadConversation(null, null, $reply_comment_id);
        $this->_loadFBAPI()->reply_message_from_comment($conversation['id'], $comment_id, null, $conversation['page_id'], $message, $conversation['token'], $conversation['fb_user_id'], $conversation['fb_user_name']);


        //Like is end
        if ($this->groupConfig->isLikeComment()) {
            $this->_likeComment($comment_id, $fanpage_id, $fanpage_token_key);
        }
    }

    private function _processInboxHasPhone($group_id, $fb_conversation_id, $fb_page_id, $thread_id, $fanpage_id,
                                           $fanpage_token_key, $fb_customer_id, $is_update_conversation)
    {
        $this->isAutoReply = true;

        $message = $this->groupConfig->getMessageForInboxHasPhone();

        $this->log->debug("REPLY INBOX IN CASE HAS PHONE", array('message' => $message, 'group_id' => $group_id, 'fb_page_id' => $fb_page_id, '__FILE__' => __FILE__, '__LINE__' => __LINE__,));

        $reply_type = 1;
        if ($message && $this->groupConfig->isReplyInboxByTime()) {
            LoggerConfiguration::logInfo('Reply for hasphone');
            $message_time = time();

            $appInstance = $this->_loadFBAPI();

            if ($appInstance && $message_id = $appInstance->reply_message($fanpage_id, $thread_id, $fanpage_token_key, $message)) {
                
                //update conversation has order
                $this->updateCountReply($fb_conversation_id, 1);
                $this->_getDB()->updateConversationComment($fb_conversation_id, null, $message_time, $fb_customer_id, true);
            }
        }
    }

    private function _processInboxNoPhone($group_id, $fb_conversation_id, $fb_page_id,
                                          $thread_id, $fanpage_id, $fanpage_token_key, $is_update_conversation)
    {
        $this->isAutoReply = true;
        $message = $this->groupConfig->getMessageForInboxHasNoPhone();
        $reply_type = 0;

        $this->log->debug('Reply for nophone', array(
            'reply message' => $message,
            'group_id'  => $group_id,
            'fb_conversation_id'  => $fb_conversation_id,
            '__FILE__' => __FILE__,
            '__LINE__' => __LINE__,
        ));


        if ($message && $this->groupConfig->isReplyInboxByTime()) {

            $message_time = time();
            $appInstance = $this->_loadFBAPI();
            if ($appInstance && $message_id = $appInstance->reply_message($fanpage_id, $thread_id, $fanpage_token_key, $message)) {
                $this->updateCountReply($fb_conversation_id, 0);
            }
        }
    }

    private function _hideComment($comment_id, $post_id, $page_id, $fanpage_token_key)
    {
        LoggerConfiguration::logInfo('Hide comment');

        /*if ( $this->groupConfig->is ) {
        }*/

        return $this->_loadFBAPI()->hide_comment($comment_id, $post_id, $page_id, $fanpage_token_key);
    }

    private function _getPageInfo($page_id)
    {
        $cache_params = array(
            'type' => 'page',
            'page_id' => $page_id
        );
        if ($page = $this->caching->get($cache_params)) {
            return $page;
        }
        if ($page = $this->_getDB()->getPageInfo($page_id)) {
            $this->caching->store($cache_params, $page, CachingConfiguration::PAGE_TTL);
            return $page;
        }
        return null;
    }

    protected function processConversation($page_id, $data, $time)
    {
        $this->log->debug("GET PAGE ID=$page_id", $data);


        $page = $this->_getPageInfo($page_id);
        if (! $page || $page['status'] != 0) {
            return false;
        }


        // $fanpage_token_key = $page['token'];
        $fb_page_id = $page['id'];
        $group_id = $page['group_id'];
        $thread_id = $data['changes'][0]['value']['thread_id'];

        // Load message trong conversation
        $fanpage_token_key = $this->getPageAccessToken( $this->pageData, $this->groupData, false );

        $messages = $this->_loadFBAPI()->get_conversation_messages($thread_id, $page_id, $fanpage_token_key, null, $time, 1);

        $this->log->debug("get messages", array('messages' => $messages, '$page_id' => $page_id, '$data' => $data, '$time' => $time, '__FILE__' => __FILE__, '__LINE__' => __LINE__));

        if (! $messages) {
            $this->log->debug('Not found message');
            // truong hop user xoa inbox => bo qua
            die();
        }

        // customer_id chinh la nguoi bat dau inbox
        $fb_user_id = $messages[0]['from']['id'];
        $msg_content = $messages[0]['message'];
        $msg_attachments = json_encode( (new MessageService)->getInboxAttachments($messages) );

        $fb_user_name = $messages[0]['from']['name'];
        $message_id = $messages[0]['id'];
        $message_time = strtotime($messages[0]['created_time']);


        //check blacklist user
        if ($this->_isSkipFBUserID($fb_user_id, $page_id)) {
            die();
        }

        if ($word = $this->_isWordsBlackList($msg_content)) {
            die();
        }

        //check is page page message
        if ($page_id == $fb_user_id) {
            $this->isPage = true;
        }

        // Kiem tra xem ton tai conversation chua
        $is_parent = 0;
        $conversation = $this->_loadConversation(null, $thread_id, null);
        $fb_customer_id = (!$this->isPage) ? $this->_getDB()->createCustomer($group_id, $fb_user_id, $fb_user_name, null) : 0;
        $is_update_conversation = false;

        $this->log->debug("get conversation", array('$conversation' => $conversation, '$page_id' => $page_id, '$data' => $data, '$time' => $time, '__FILE__' => __FILE__, '__LINE__' => __LINE__));

        $fb_conversation_id = 0;

        //get phone number
        $phone = $this->_includedPhone($msg_content);
        if ($phone && (!$this->isPage)) {
            $this->msgHasPhone = true;
        }

        //nếu conversation ko tồn tại, tiến hành tạo mới và auto-reply, user không phải là page
        if (! $conversation && (!$this->isPage)) {

            $is_parent = 1;

            // chua ton tai conversation => tao moi
            $this->log->debug('CREATE CONVERSATION');

            $fb_conversation_id = $this->_getDB()->saveConversationInbox($group_id, $page_id, $fb_page_id, $fb_user_id, $fb_user_name, $thread_id,
                $time, $fb_customer_id, $msg_content);

            //Bỏ qua auto nếu data của page
            if ($fb_conversation_id && (!$this->isPage)) {

                $this->log->debug("CHECK PHONE", array('content' => $msg_content, 'phone' => $this->_includedPhone($msg_content), '__FILE__' => __FILE__, '__LINE__' => __LINE__,));

                if ($phone) {

                    if ($this->_isPhoneBlocked($phone)) {
                        return false;
                    }

                    $this->log->debug("REPLY INBOX IN CASE INCLUDED PHONE", array('content' => $msg_content, 'phone' => $phone, '__FILE__' => __FILE__, '__LINE__' => __LINE__,));

                    $this->_processInboxHasPhone($group_id, $fb_conversation_id,
                        $fb_page_id, $thread_id, $page_id, $fanpage_token_key, $fb_customer_id, $is_update_conversation);


                } else {
                    LoggerConfiguration::logInfo('REPLY INBOX IN CASE DONT INCLUDED PHONE');
                    $this->_processInboxNoPhone($group_id, $fb_conversation_id, $fb_page_id, $thread_id, $page_id, $fanpage_token_key, $is_update_conversation);
                }
            }

        }

        if ( $conversation ) {
            //tra loi với với inbox đã tồn tại
            $is_update_conversation = true;
            $fb_conversation_id = $conversation['id'];
        }

        if (! $fb_conversation_id) {
            return false;
        }

        //update sender in background via gearman
        //test update message
        //update fb_messenger_id only sender != page_id
        if (!$this->isPage) {

            $this->log->debug('sending request to update messenger_id', [
                'conversation_id' => $conversation['id'],
                'page_id' => $page_id,
                'message_id' => $message_id
            ]);

            $this->conversationService->update_inbox_conversation_messenger_id([
                'conversation_id' => $conversation['id'],
                'page_id' => $page_id,
                'message_id' => $message_id
            ]);
        }



        //reply_type = 1 : co sdt
        //reply_type = 0 : KO co sdt
        //reply for existed conversation
        $reply_type = 0;
        //bỏ qua auto nếu data là của page
        if ($conversation && (!$this->isPage)) {

            $countInboxRepliedHasPhone = $this->countReplyHasPhone($fb_conversation_id);
            $countInboxRepliedNoPhone = $this->countReplyNoPhone($fb_conversation_id);

            if ($countInboxRepliedHasPhone <1  &&
                $phone && !$this->_isPhoneBlocked($phone)
            ) {
                $reply_type = 1;

                //auto inbox has phone
                $this->_processInboxHasPhone($group_id, $fb_conversation_id, $fb_page_id, $thread_id, $page_id,
                    $fanpage_token_key, $fb_customer_id, $is_update_conversation);
            }

            if ($countInboxRepliedNoPhone  < 1 &&
                $countInboxRepliedHasPhone < 1 && !$phone) {
                //auto inbox has no phone
                $this->_processInboxNoPhone($group_id, $fb_conversation_id, $fb_page_id, $thread_id, $page_id, $fanpage_token_key, $is_update_conversation);

            }

            $this->log->debug("count repied has phone : {$countInboxRepliedHasPhone}", array(
               'fb_conversation_id' => $fb_conversation_id,

           ));
            $this->log->debug("count repied has no phone : {$countInboxRepliedNoPhone}");
        }

        //update inbox cũ
        $this->log->debug('SAVE MESSAGE TO CONVERSATION');

        //process order for inbox

        if ($phone && !$this->_isPhoneBlocked($phone) && (!$this->isPage)) {
            $telco = $this->_getTelcoByPhone($phone);
            $this->_processOrder($phone, $fb_user_id, $fb_user_name, 0, 0, $page_id, $fb_page_id, $group_id, 0, 0, 0, 0, $telco);
        }


        //
        $isSave = $this->_getDB()->createConversationMessage($group_id, $fb_conversation_id, $msg_content, $msg_attachments ,$fb_user_id, $message_id, $message_time,
            $fb_page_id, $fb_customer_id, $is_update_conversation, $reply_type, $this->msgHasPhone, $fb_user_name);

        $this->log->debug('is saved ? create inboxConversation', [
            'inbox-conversation' => $isSave,
            'inbox-content' => $msg_content,
            'inbox-message-id' => $message_id,
        ]);

        $this->updateLastConversationUnixTime($fb_conversation_id);

        //push notification to pusher
        $request = $this->setRequestMessageData($phone, $msg_content, $msg_attachments, $fb_user_name, $group_id, $fb_conversation_id, $fb_user_id, $page_id, $message_time, $is_parent, $this->isPage, $message_id);

        //
        $this->postJSONFaye("/channel_group_{$group_id}", $request, [], null);

        //bỏ qua push socket and pusher nếu là page data
        if ($this->isPage) {
            exit(0);
        }
        $this->sendToPusher($request);

        exit(0);//ket thuc su ly conversation
    }


    private function updateLastConversationUnixTime($conv_id)
    {
        try {
            $current_time = time();
            $conv = Conversation::find($conv_id);
            $conv->last_conversation_time = $current_time;
            $conv->save();
        } catch (Exception $ex) {
            LoggerConfiguration::logError($ex->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
        }

    }


    private function _processCommentChat($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $fb_user_id,
                                         $fb_user_name, $comment_id, $parent_comment_id, $comment,$comment_attachment,$fb_customer_id, $comment_time)
    {

        // get comment cha
        $is_parent = 0;
        $fb_conversation_id = 0;
        if ($conversation = $this->_loadConversation(null, null, $parent_comment_id)) {
            $fb_conversation_id = isset($conversation['id']) ? $conversation['id'] : 0;
        }

        if (! $fb_conversation_id) {
            // la comment cap 1 va chua tao conversation => tao conversation
            // tao conversation
            LoggerConfiguration::logInfo('Create conversation comment');

            $conversation_id = $this->_getDB()->saveConversationCommentV2($group_id, $fb_customer_id, $fb_page_id, $page_id, $fb_user_id, $comment_id, $comment_time, $comment, $fb_user_name, $post_id, $fb_post_id);

            $fb_conversation_id = $conversation_id ? $conversation_id : 0;
            $is_parent = 1;

        } else {

            // update comment
            LoggerConfiguration::logInfo('call updateConversationComment()');
            $this->_getDB()->updateConversationComment($fb_conversation_id, $comment, $comment_time, $fb_customer_id);
        }


        $reply_type = 0;
        if ($this->_includedPhone($comment)) {
            $reply_type = 1;
        }

        $fb_comment_id = $this->_getDB()->createCommentPostV2($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $fb_user_id, $comment_id,
            $fb_conversation_id, $parent_comment_id, $comment,$comment_attachment ,$fb_customer_id, $comment_time, $reply_type, $fb_user_name);


        return array(
            'fb_conversation_id' => $fb_conversation_id,
            'fb_comment_id' => $fb_comment_id ? $fb_comment_id : 0,
            'is_parent' => $is_parent
        );
    }

    private function _processOrder($phone, $fb_user_id, $fb_user_name, $post_id,
                                   $fb_post_id, $page_id, $fb_page_id, $group_id, $product_id,
                                   $fb_comment_id, $bundle_id, $price, $telco)
    {
        LoggerConfiguration::logInfo('Create customer');
        $fb_customer_id = $this->_getDB()->createCustomer($group_id, $fb_user_id, $fb_user_name, $phone);

        if (!$fb_customer_id) {
            $fb_customer_id = 0;
        }


        $duplicate_info = $this->_getDB()->getOrderDuplicate($fb_user_id, $post_id, $phone, $group_id);

        $is_duplicate = $duplicate_info ? 1 : 0;
        LoggerConfiguration::logInfo('Create order');
        $order_code = $this->_generateOrderCode();

        if ($order_id = $this->_getDB()->createOrderV2($group_id, $fb_page_id, $fb_post_id, $fb_comment_id, $phone, $product_id, $bundle_id, $fb_user_name,
            $order_code, $fb_customer_id, ORDER_STATUS_DEFAULT, $price, $is_duplicate, $duplicate_info, $telco)) {

            LoggerConfiguration::logInfo('Create order product relation');

            $this->_getDB()->createOrderProduct($order_id, $post_id, $price, 1);

           // $this->debug->log("debug", "_processOrder() => order_id : ", array(__FILE__, __LINE__, $order_id));

            //push notification to pusher
            $request['message'] = "Bạn có đơn hàng mới.";
            $request['username'] = $fb_user_name;
            $request['group_id'] = $group_id;
            $request['order_id'] = $order_id;
            $request['customer_id'] = $fb_customer_id;
            $request['action'] = "vừa tạo đơn hàng.";
            $this->sendToPusher($request);

                return array(
                    'order_id' => $order_id,
                    'fb_customer_id' => $fb_customer_id
                );

            /*}*/

            //push notification
        }

        return false;
    }

    private function _loadConfig($by)
    {
        if ($this->config) {
            return $this->config;
        }
        LoggerConfiguration::logInfo('Load config by: ' . print_r($by, true));
        $caching = new FBSCaching();
        LoggerConfiguration::logInfo('Get config from cache');
        $c_config_data = null;
        $config_data = null;
        if (array_key_exists('page_id', $by)) {
            $cache_params = array(
                'type' => 'config',
                'page_id' => $by['page_id']
            );
            $c_config_data = $caching->get($cache_params);
            if (! $c_config_data) {
                $config_data = $this->_getDB()->loadConfigByPage(null, $by['page_id']);
            }
        } elseif (array_key_exists('group_id', $by)) {
            $cache_params = array(
                'type' => 'config',
                'group_id' => $by['group_id']
            );
            $c_config_data = $caching->get($cache_params);
            if (! $c_config_data) {
                $config_data = $this->_getDB()->loadConfigByGroup($by['group_id']);
            }
        } elseif (array_key_exists('fb_page_id', $by)) {
            $cache_params = array(
                'type' => 'config',
                'fb_page_id' => $by['fb_page_id']
            );
            $c_config_data = $caching->get($cache_params);
            if (! $c_config_data) {
                $config_data = $this->_getDB()->loadConfigByPage($by['fb_page_id']);
            }
        } elseif (array_key_exists('fb_post_id', $by)) {
            $cache_params = array(
                'type' => 'config',
                'fb_post_id' => $by['fb_post_id']
            );
            $c_config_data = $caching->get($cache_params);
            if (! $c_config_data) {
                $config_data = $this->_getDB()->loadConfigByPost($by['fb_post_id']);
            }
        } else
            return null;
        if ($c_config_data) {

            $this->log->debug('Found cache', $c_config_data);

            LoggerConfiguration::logInfo('Found cache');
            $this->config = $c_config_data;
            return $this->config;
        }
        LoggerConfiguration::logInfo('Not found cache');
        if (! $config_data) {
            LoggerConfiguration::logInfo('Not found config from DB');
            return false;
        }
        LoggerConfiguration::logInfo('FOUND config from DB');


        foreach ($config_data as $config) {
            $type = intval($config['type']);
            $val = null;
            switch ($type) {
                default:
                    // text
                    $val = trim($config['value']);
                    break;
                case 1:
                    // json
                    $val = json_decode($config['value'], true);
                    break;
                case 2:
                    // array: 1,2,3,45466,fdfs
                    $val = explode(',', $config['value']);
                    break;
                case 3:
                    // int
                    $val = intval(trim($config['value']));
                    break;
                case 4:
                    // serialize
                    $val = unserialize($config['value']);
            }
            if (isset($val))
                $this->config[$config['_key']] = $val;
        }
        if (! $this->config) {
            LoggerConfiguration::logError('Not found config', __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }


        //$this->log->debug("Config Data", $this->config);


        // store cache
        LoggerConfiguration::logInfo('Store config to cache');
        $storedCache = $caching->store($cache_params, $this->config, CachingConfiguration::CONFIG_TTL);

        if (!$storedCache) {
            $this->log->error("Error store cache config");
        }
        return $this->config;
    }

//    public function _includedPhone($str)
//    {
//        $cont = str_replace(array(
//            '.',
//            '-',
//            ','
//        ), '', $str);
//
//        $cont = preg_replace('/\s+/', '', $cont);
//
//        if (preg_match('/[0-9]{9,13}/', $cont, $matches)) {
//            return $this->_standardInternationlPhoneNumber($matches[0]);
//        }
//
//        return false;
//    }

//    public function _standardInternationlPhoneNumber($phoneNumber)
//    {
//        // Cho viettel????
//        if (substr($phoneNumber, 0, 1) === '0')
//            $phoneNumber = '84' . substr($phoneNumber, 1);
//        else
//            if (substr($phoneNumber, 0, 2) !== '84')
//                $phoneNumber = '84' . $phoneNumber;
//
//            /*
//         * if (strlen($phoneNumber)<10)
//         * return $phoneNumber;
//         * if (substr($phoneNumber, 0, 1)==="+")
//         * $phoneNumber=substr($phoneNumber, 1);
//         * //chuyen ve dang 84
//         * if (substr($phoneNumber, 0, 2)!=="84")
//         * $phoneNumber="84" . substr($phoneNumber, 1);
//         */
//        return $phoneNumber;
//    }

    private function _isPhoneBlocked($phone)
    {
        if ($phone_filter = $this->config['phone_filter']) {

            foreach ($phone_filter as $pattern) {
                $pattern = trim($pattern);
                if (! $pattern) {
                    continue;
                }

                $comparePhone = $this->_includedPhone($pattern);

                //$this->debug->alert("compare =>", array($phone, $comparePhone));

                if (strpos($phone, $comparePhone) !== false) {
                    LoggerConfiguration::logError("This phone=$phone is in blocklist", __CLASS__, __FUNCTION__, __LINE__);
                    return $pattern;
                }
            }
        }
        return false;
    }

    private function _isSkipFBUserID($fb_user_id, $page_id)
    {
        if (strval($page_id) === strval($fb_user_id)) {
            LoggerConfiguration::logInfo("Dont process for fb_user_id=$fb_user_id");
            // return true;
        }

        foreach ($this->config['user_coment_filter'] as $filter_user_id) {
            if ($filter_user_id == $fb_user_id) {
                LoggerConfiguration::logInfo("Dont process for fb_user_id=$fb_user_id");
                return true;
            }
        }
        return false;
    }

    private function _isWordsBlackList(&$message)
    {
        if ($words_blacklist = isset($this->config['words_blacklist']) ? $this->config['words_blacklist'] : '') {
            if ($words = explode(',', $words_blacklist)) {
                foreach ($words as $word) {
                    $word = trim($word);
                    if (empty($word))
                        continue;
                    if (mb_strpos($message, $word) !== false) {
                        LoggerConfiguration::logError("This comment=$message include word=$word that is in blocklist", __CLASS__, __FUNCTION__, __LINE__);
                        return $word;
                    }
                }
            }
        }
        return false;
    }

    public function validatePost($post_id, $fb_page_id)
    {
        // lay page_token
        $page = $this->_getDB()->getPageInfo(null, $fb_page_id);
        if (! $page) {
            LoggerConfiguration::logError("Not found page with id=$fb_page_id", __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        $config = $this->_loadConfig(array(
            'group_id' => $page['group_id']
        ));
        if (! $config) {
            LoggerConfiguration::logError("Not found page with group_id={$page['group_id']}", __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        $post_id = "{$page['page_id']}_{$post_id}";
        $post_detail = $this->_loadFBAPI()->getPostDetail($post_id, $page['token']);
        if (! $post_detail) {
            LoggerConfiguration::logError("Not found post with post_id=$post_id", __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        return $post_id;
    }

    private function _generateOrderCode($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i ++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function createWebHook($group_id)
    {
        $this->_loadConfig(array(
            'group_id' => $group_id
        ));
        if (! $this->config) {
            return false;
        }
        //delete old weebhook
        $this->_loadFBAPI()->deleteWebhook($this->config['fb_app_id'], 'page');
        //create new webhook
        return $this->_loadFBAPI()->createWebhook();
    }

    public function deleteWebHook($group_id)
    {
        $this->_loadConfig(array(
            'group_id' => $group_id
        ));
        if (! $this->config) {
            return false;
        }
        return $this->_loadFBAPI()->deleteWebhook($this->config['fb_app_id'], 'page');
    }

    public function createPageSubscribedApps($page_id)
    {
        $page = $this->_getPageInfo($page_id);
        if (! $page || $page['status'] != 0) {
            return false;
        }
        $fanpage_token_key = $page['token'];
        if (! $this->_loadConfig(array(
            'page_id' => $page_id
        ))) {
            return false;
        }
        return $this->_loadFBAPI()->createPageSubscribedApps($page_id, $fanpage_token_key);
    }

    public function deletePageSubscribedApps($page_id)
    {
        $page = $this->_getPageInfo($page_id);
        if (! $page) {
            return false;
        }
        if (! $this->_loadConfig(array(
            'page_id' => $page_id
        ))) {
            return false;
        }
        $fanpage_token_key = $page['token'];
        return $this->_loadFBAPI()->deletePageSubscribedApps($page_id, $fanpage_token_key);
    }

    public function chat($group_chat_id, &$message, $attachment_url = null, $private_reply=false)
    {
        $this->log->debug('running chat-api');
        $this->log->debug("Chat: group_chat_id=$group_chat_id; msg=$message; private_reply : $private_reply");
        $conversation = $this->_loadConversation($group_chat_id, null, null);
        if (! $conversation) {
            $this->log->error("Not found conversation with conversation_id=$group_chat_id", __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        $this->_loadConfig(array(
            'group_id' => $conversation['group_id']
        ));
        if (! $this->config) {
            $this->log->error('sending chat error', array("Not found config for group_id={$conversation['group_id']}", __CLASS__, __FUNCTION__, __LINE__));
            return false;
        }
        $type = intval($conversation['type']);

        if ($type == 1 && $private_reply) {
            $type = 2; //private reply from comment
        }

        switch ($type) {
            case 1:
                return $this->_chat_comment($conversation, $message, $attachment_url);
            case 0:
                return $this->_chat_inbox($conversation, $message);
            case 2 :
                return $this->_chat_private_reply($conversation, $message);

            default:
                return false;
        }
    }

    private function _loadConversation($fb_conversation_id, $conversation_id, $comment_id)
    {
        $caching = new FBSCaching();
        $cache_params = array(
            'type' => 'conversation'
        );
        if ($fb_conversation_id) {
            $cache_params['fb_conversation_id'] = $fb_conversation_id;
        } elseif ($conversation_id) {
            $cache_params['conversation_id'] = $conversation_id;
        } elseif ($comment_id) {
            $cache_params['comment_id'] = $comment_id;
        }

        $conversation = $caching->get($cache_params);


        if (! $conversation) {

            $conversation = $this->_getDB()->loadConversation($fb_conversation_id, $conversation_id, $comment_id);

            if ($conversation) {
                // store to cache
                LoggerConfiguration::logInfo('Store conversation to cache');
                $caching->store($cache_params, $conversation, CachingConfiguration::CONVERSATION_TTL);
            }
        } else {
            LoggerConfiguration::logInfo('Found conversation from cache');
        }
        return $conversation;
    }

    public function syncChat($group_chat_id)
    {
        $H = date('YmdH');
        $M = date('Ym');
        LoggerConfiguration::overrideLogger("{$M}/{$H}_chat.log");
        LoggerConfiguration::logInfo("Sync chat: group_chat_id=$group_chat_id");
        $conversation = $this->_loadConversation($group_chat_id, null, null);
        if (! $conversation) {
            LoggerConfiguration::logInfo('Not found conversation');
            return false;
        }
        switch ($conversation['type']) {
            case 1:
                LoggerConfiguration::logInfo('_syncCommentChat');
                return $this->_syncCommentChat($conversation);
            case 0:
                LoggerConfiguration::logInfo('_syncConversation');
                return $this->_syncConversation($conversation);

            default:
                return false;
        }
    }

    private function _syncConversation(&$conversation)
    {
        $this->_loadConfig(array(
            'group_id' => $conversation['group_id']
        ));
        if (! $this->config) {
            LoggerConfiguration::logInfo('Not found config');
            return false;
        }
        $fp = new Fanpage($this->config);
        LoggerConfiguration::logInfo('Conversation: ' . print_r($conversation, true));
        LoggerConfiguration::logInfo('Get message for this conversation');
        $conversation_id = $conversation['conversation_id'];
        $page_id = $conversation['page_id'];
        $fanpage_token_key = $conversation['token'];
        $since_time = $conversation['last_conversation_time'];
        $until_time = time();
        $messages = $fp->get_conversation_messages($conversation_id, $page_id, $fanpage_token_key, $since_time, $until_time, $this->config['fb_graph_limit_message_conversation']);
        if ($fp->error) {
            LoggerConfiguration::logError("Error get messge for conversation_id=$conversation_id: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__);
        }
        if ($messages) {
            LoggerConfiguration::logInfo('messages: ' . print_r($messages, true));
            LoggerConfiguration::logInfo('Save messages');
            $group_id = $conversation['group_id'];
            $fb_page_id = $conversation['fb_page_id'];
            if (! $this->_getDB()->saveConversationMessage($group_id, $conversation['id'], $messages, $fb_page_id, 0)) {
                LoggerConfiguration::logInfo('Save error');
                return false;
            }
            LoggerConfiguration::logInfo('Update last conversation time');
            // cap nhat thoi gian lay conversation de khong lay conversation cu nua
            if (! $this->_getDB()->updateConversationLastConversationTime($conversation['id'], $until_time, $messages[0]['message'])) {
                LoggerConfiguration::logInfo('Update error');
            }
            // update $last_comment_time vao cache
            LoggerConfiguration::logInfo("Update conversation['last_conversation_time']=$until_time to cache");
            $conversation['last_conversation_time'] = $until_time;
            if (! $this->_updateConversationCache($conversation['id'], $conversation)) {
                LoggerConfiguration::logInfo('Update error');
            }
        }
        return true;
    }

    private function _updateConversationCache($fb_conversation_id, &$new_conversation)
    {
        $caching = new FBSCaching();
        $cache_params = array(
            'type' => 'conversation',
            'fb_conversation_id' => $fb_conversation_id
        );
        LoggerConfiguration::logInfo('Update conversation to cache');
        return $caching->store($cache_params, $new_conversation, CachingConfiguration::CONVERSATION_TTL, true);
    }

    private function _syncCommentChat(&$comment)
    {
        $this->_loadConfig(array(
            'group_id' => $comment['group_id']
        ));
        if (! $this->config) {
            LoggerConfiguration::logInfo('Not found config');
            return false;
        }
        LoggerConfiguration::logInfo('Comment: ' . print_r($comment, true));
        $fp = new Fanpage($this->config);
        $last_comment_time = time();
        $comments = $fp->get_comment_post($comment['comment_id'], $comment['page_id'], $comment['token'], $this->config['fb_graph_limit_comment_post'], $comment['last_conversation_time'], null, $this->config['max_comment_time_support']);
        if ($comments === false) {
            LoggerConfiguration::logError('Error get comment', __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        if ($comments) {
            LoggerConfiguration::logInfo('Sync DB');
            if (! $this->_getDB()->syncCommentChat($comment['group_id'], $comment['fb_page_id'], $comment['page_id'], $comment['fb_post_id'], $comment['post_id'], $comment['id'], $comment['comment_id'], $comments)) {
                LoggerConfiguration::logInfo('Sync error');
                return false;
            }
            if (! $this->_getDB()->updateConversationLastConversationTime($comment['id'], $last_comment_time, $comments[0]['message'])) {
                LoggerConfiguration::logInfo('Update updateLastCommentTime error');
            }
            // update $last_comment_time vao cache
            LoggerConfiguration::logInfo("Update comment['last_conversation_time']=$last_comment_time to cache");
            $comment['last_conversation_time'] = $last_comment_time;
            if (! $this->_updateConversationCache($comment['id'], $comment)) {
                LoggerConfiguration::logInfo('Update error');
            }
        } else
            LoggerConfiguration::logInfo('Not found comment');
        return true;
    }

    private function _chat_comment(&$comment, &$message, $attachment_url=null)
    {
        // thuc hien comment
        $this->log->debug('sending comment to facebook', array('Comment'=>$comment, 'message'=>$message, '$attachment_url'=>$attachment_url ));
        //$attachment_url = urldecode($attachment_url);
        $replied_comment_id = $this->_loadFBAPI()->reply_comment($comment['comment_id'], null, $comment['page_id'], $message, $attachment_url, $comment['token'], $comment['fb_user_id'], $comment['fb_user_name']);
        if (! $replied_comment_id)
            return false;
            // thanh cong
        $fb_customer_id = 0;
        $this->log->debug('Store reply-comment DB');

        $commentId = $this->_getDB()->createCommentPostV2($comment['group_id'], $comment['page_id'], $comment['fb_page_id'], $comment['post_id'], $comment['fb_post_id'], $comment['page_id'], $replied_comment_id, $comment['id'], $comment['comment_id'], $message,null , $fb_customer_id, time());

        if (! $commentId) {
            $this->log->debug('Storing reply-comment got error');
        }

        return array('type' => 1, 'id'=>$commentId,'message_id' => $replied_comment_id);
    }

    /**
    * send message from comment
     **/
    private function _chat_private_reply(&$conversation, &$message)
    {
        $this->isAutoReply = true;
        // thuc hien comment
        $this->log->debug('sending message from comment', array('Comment'=>$conversation, 'message'=>$message ));

        $replied_message_id = $this->_loadFBAPI()->reply_message_from_comment($conversation['id'], $conversation['comment_id'], null, $conversation['page_id'], $message, $conversation['token'], $conversation['fb_user_id'], $conversation['fb_user_name']);

        if (!$replied_message_id)
            return false;

        // thanh cong
        $this->log->debug("Sent private message to {$conversation['fb_user_name']}");

        return array('type' => 0, 'id'=> 0, 'message_id' => $replied_message_id);

    }


    private function _chat_inbox($conversation, $message)
    {
        $this->log->debug('conversation in box content', $conversation);

        try {
            $replied_id = $this->_loadFBAPI()->reply_message($conversation['page_id'], $conversation['conversation_id'], $conversation['token'], $message);
            if (!$replied_id)
                return false;

            // thanh cong
            $this->log->debug('Save reply-inbox into DB');

            $inboxId = $this->_getDB()->createConversationMessage(
                $conversation['group_id'], $conversation['id'], $message, null, $conversation['page_id'], $replied_id,
                time(), $conversation['fb_page_id'], $conversation['page_id'], $is_update_conversation = false, $reply_type = 0, 0, null
            );
            if (!$inboxId) {
                $this->log->error('Save DB error');
            }

            return array('type' => 0, 'id'=> $inboxId, 'message_id' => $replied_id);

        } catch (Exception $e) {
            $this->log->error($e->getMessage());
            return false;
        }
    }
    
    private function _likeComment($comment_id, $page_id, $page_token) {
        LoggerConfiguration::logInfo("Like to comment_id=$comment_id");
        $this->_loadFBAPI()->like($comment_id, $page_id, $page_token);
    }
}