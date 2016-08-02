<?php
require_once dirname(__FILE__) . '/src/db/FBDBProcess.php';
require_once dirname(__FILE__) . '/src/caching/FBSCaching.php';
require_once dirname(__FILE__) . '/src/core/Fanpage.core.php';

class FB
{

    private $db = null;

    private $config = null;

    private $caching = null;

    public function __construct()
    {
        $this->caching = new FBSCaching();
    }

    private function _getDB()
    {
        if ($this->db === null) {
            $this->db = new FBDBProcess();
        }
        return $this->db;
    }

    public function run(&$data)
    {
        LoggerConfiguration::logInfo('CALLBACK DATA:' . print_r($data, true));
        $data = $data['entry'][0];
        $comment_data = $data['changes'][0]['value'];
        $field = $data['changes'][0]['field'];
        LoggerConfiguration::logInfo('LOAD CONFIG');
        $this->_loadConfig(array(
            'page_id' => $data['id']
        ));
        if (! $this->config) {
            return false;
        }
        LoggerConfiguration::logInfo('CONFIG DATA: ' . print_r($this->config, true));
        if ($field === 'feed' && $comment_data['item'] === 'comment' && $comment_data['verb'] === 'add') {
            LoggerConfiguration::logInfo('PROCESS COMMENT');
            return $this->processComment($data['id'], $comment_data);
        } elseif ($field === 'conversations') {
            LoggerConfiguration::logInfo('PROCESS CONVERSATION');
            return $this->processConversation($data['id'], $data, $data['time']);
        }
        LoggerConfiguration::logInfo('DONT PROCESS THIS CALLBACK DATA');
        return false;
    }

    private function _getParentComment($parent_id, $page_id, $post_id, $comment_id)
    {
        return ($parent_id == $post_id) || (strpos($parent_id, $page_id) !== false) ? $comment_id : $parent_id;
    }

    protected function processComment($page_id, &$comment_data)
    {
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
        $post = $this->_getPostInfo($post_id);
        if (! $post) {
            return false;
        }
        $comment_id = $comment_data['comment_id'];
        $fb_post_id = $post['id'];
        $parent_comment_id = $this->_getParentComment($comment_data['parent_id'], $page_id, $post_id, $comment_id);
        $product_id = $post['product_id'];
        $bundle_id = $post['bundle_id'];
        $price = $post['price'];
        $fb_user_name = $comment_data['sender_name'];
        $comment_time = $comment_data['created_time'];
        $message = $comment_data['message'];
        LoggerConfiguration::logInfo('CHECK WORD IN BLACKLIST');
        if ($word = $this->_isWordsBlackList($message)) {
            $this->_hideComment($comment_id, $post_id, $page_id, $fanpage_token_key);
            return false;
        }
        $fb_customer_id = 0;
        LoggerConfiguration::logInfo('PROCESS COMMENT CHAT');
        $added_comment = $this->_processCommentChat($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $fb_user_id, $fb_user_name, $comment_id, $parent_comment_id, $message, $fb_customer_id, $comment_time);
        $fb_comment_id = $added_comment['fb_comment_id'];
        if (! $fb_comment_id) {
            // truong hop loi FB: goi nhieu lan => comment bi trung nhau
            // bo qua (Chua biet co dung khong)
            LoggerConfiguration::logError('THIS COMMENT HAD PROCESSED BEFORE', __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        $fb_conversation_id = $added_comment['fb_conversation_id'];
        if ($phone = $this->_includedPhone($message)) {
            LoggerConfiguration::logInfo('CHECK PHONE IN BLACKLIST');
            if ($this->_isPhoneBlocked($phone)) {
                $this->_hideComment($comment_id, $post_id, $page_id, $fanpage_token_key);
                return false;
            }
            LoggerConfiguration::logInfo('CREATE ORDER');
            $telco = $this->_getTelcoByPhone($phone);
            $order = $this->_processOrder($phone, $fb_user_id, $fb_user_name, $post_id, $fb_post_id, $page_id, $fb_page_id, $group_id, $product_id, $fb_comment_id, $bundle_id, $price, $telco);
            // Code of Mr Nghia
            // tao don hang 8386
            $time = microtime();
            $params = array(
                'fb_user_id' => $fb_user_id, // $current_group_id $page_id, $post_id,
                'fb_page_id' => $fb_page_id,
                'fb_post_id' => $fb_post_id,
                'phone' => $phone,
                'product_code' => $post['code'],
                'product_id' => $product_id,
                'bundle_id' => $bundle_id,
                'full_name' => $fb_user_name,
                'fb_comment_id' => $comment_id,
                'fb_parent_comment_id' => $parent_comment_id,
                'time' => $time,
                'key' => md5('ssc_key_' . $time . '_8386')
            );
            $this->_postUrl('http://8386.vn/api/facebook/addOrderFacebook', $params);
            // end
            $fb_customer_id = $order ? $order['fb_customer_id'] : 0;
            LoggerConfiguration::logInfo('PROCESS COMMENT HASPHONE');
            $this->_processCommentHasPhone($group_id, $fb_page_id, $fb_post_id, $fb_conversation_id, $fb_customer_id, $parent_comment_id, $comment_id, $post_id, $page_id, $fanpage_token_key, $post['answer_phone']);
        } else {
            LoggerConfiguration::logInfo('PROCESS COMMENT NOPHONE');
            $reply_by_scripting = isset($post['reply_by_scripting']) ? $post['reply_by_scripting'] : null;
            $this->_processCommentNoPhone($group_id, $fb_page_id, $fb_post_id, $fb_conversation_id, $fb_customer_id, $parent_comment_id, $message, $comment_id, $comment_time, $post_id, $page_id, $fanpage_token_key, $reply_by_scripting, $post['answer_nophone']);
        }
    }

    private $fb_api = null;

    private function _loadFBAPI()
    {
        if ($this->fb_api === null) {
            $this->fb_api = new Fanpage($this->config);
        }
        return $this->fb_api;
    }

    private function _replyComment($comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key)
    {
        if (empty($message)) {
            return false;
        }
        LoggerConfiguration::logInfo("Reply message: $message");
        return $this->_loadFBAPI()->reply_comment($comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key);
    }

    private function _processCommentHasPhone($group_id, $fb_page_id, $fb_post_id, $fb_conversation_id, $fb_customer_id, $reply_comment_id, $comment_id, $post_id, $fanpage_id, $fanpage_token_key, $post_reply_phone)
    {
        $message = empty($post_reply_phone) ? $this->config['reply_comment_has_phone'] : $post_reply_phone;
        if ($message) {
            LoggerConfiguration::logInfo('Reply for hasphone');
            if ($replied_comment_id = $this->_replyComment($reply_comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key)) {
                if ($fb_conversation_id) {
                    $comment_time = time();
                    $this->_getDB()->createCommentPost($group_id, $fanpage_id, $fb_page_id, $post_id, $fb_post_id, $fanpage_id, $replied_comment_id, $fb_conversation_id, $comment_id, $message, $fb_customer_id, $comment_time);
                }
            }
        }
        if ($this->config['like_comment']){
            $this->_likeComment($comment_id, $fanpage_id, $fanpage_token_key);
        }
        if ($this->config['hide_phone_comment']) {
            $this->_hideComment($comment_id, $post_id, $fanpage_id, $fanpage_token_key);
        }
    }

    private function _processCommentNoPhone($group_id, $fb_page_id, $fb_post_id, $fb_conversation_id, $fb_customer_id, $reply_comment_id, $comment, $comment_id, $comment_time, $post_id, $fanpage_id, $fanpage_token_key, $post_reply_by_scripting, $post_reply_nophone)
    {
        $message = $this->_getReplyByScripting($comment, $comment_time, $post_reply_by_scripting, $post_reply_nophone);
        if ($message) {
            if ($replied_comment_id = $this->_replyComment($reply_comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key)) {
                if ($fb_conversation_id) {
                    $comment_time = time();
                    $this->_getDB()->createCommentPost($group_id, $fanpage_id, $fb_page_id, $post_id, $fb_post_id, $fanpage_id, $replied_comment_id, $fb_conversation_id, $comment_id, $message, $fb_customer_id, $comment_time);
                }
            }
        }
        if ($this->config['like_comment']){
            $this->_likeComment($comment_id, $fanpage_id, $fanpage_token_key);
        }
        if (isset($this->config['hide_nophone_comment']) && intval($this->config['hide_nophone_comment']) === 1) {
            $this->_hideComment($comment_id, $post_id, $fanpage_id, $fanpage_token_key);
        }
    }

    private function _processInboxHasPhone($group_id, $fb_conversation_id, $fb_page_id, $thread_id, $fanpage_id, $fanpage_token_key)
    {
        $message = intval($this->config['reply_conversation']) === 1 ? $this->config['reply_conversation_has_phone'] : null;
        if ($message) {
            LoggerConfiguration::logInfo('Reply for hasphone');
            $message_time = time();
            if ($message_id = $this->_loadFBAPI()->reply_message($fanpage_id, $thread_id, $fanpage_token_key, $message)) {
                $this->_getDB()->createConversationMessage($group_id, $fb_conversation_id, $message, $fanpage_id, $message_id, $message_time, $fb_page_id);
            }
        }
    }

    private function _processInboxNoPhone($group_id, $fb_conversation_id, $fb_page_id, $thread_id, $fanpage_id, $fanpage_token_key)
    {
        $message = intval($this->config['reply_conversation']) === 1 ? $this->config['reply_conversation_nophone'] : null;
        if ($message) {
            LoggerConfiguration::logInfo('Reply for nophone');
            $message_time = time();
            if ($message_id = $this->_loadFBAPI()->reply_message($fanpage_id, $thread_id, $fanpage_token_key, $message)) {
                $this->_getDB()->createConversationMessage($group_id, $fb_conversation_id, $message, $fanpage_id, $message_id, $message_time, $fb_page_id);
            }
        }
    }

    private function _getReplyByScripting(&$comment, &$comment_time, &$post_reply_by_scripting, &$post_comment_nophone)
    {
        // KB 1: ngoai gio lam viec
        if (isset($this->config['reply_by_scripting']) && is_array($this->config['reply_by_scripting']))
            LoggerConfiguration::logInfo('Check for out_of_work_time case');
        if ($out_of_work_time = $this->config['reply_by_scripting']['out_of_work_time']) {
            $comment_hours = date('H:i', strtotime($comment_time));
            if (($out_of_work_time['start'] && $out_of_work_time['start'] < $comment_hours) || ($out_of_work_time['end'] && $comment_hours > $out_of_work_time['end'])) {
                LoggerConfiguration::logInfo('out_of_work_time');
                return $out_of_work_time['reply'];
            }
        }
        // tra loi theo cau hinh post
        if ($post_reply_by_scripting)
            LoggerConfiguration::logInfo('Check for post_reply_by_scripting case');
        foreach ($post_reply_by_scripting as $type => &$scripting) {
            $pattern = explode(',', $scripting['pattern']);
            foreach ($pattern as $p) {
                if (mb_strpos($comment, $p) !== false) {
                    LoggerConfiguration::logInfo($p);
                    return $scripting['reply'];
                }
            }
        }
        // tra loi theo cau hinh he thong
        LoggerConfiguration::logInfo('Check for reply_by_scripting case');
        if (isset($this->config['reply_by_scripting']) && $this->config['reply_by_scripting'])
            foreach ($this->config['reply_by_scripting'] as $type => &$scripting) {
                if ($type == 'out_of_work_time') {
                    continue;
                }
                $pattern = explode(',', $scripting['pattern']);
                foreach ($pattern as $p) {
                    if (mb_strpos($comment, $p) !== false) {
                        LoggerConfiguration::logInfo($p);
                        return $scripting['reply'];
                    }
                }
            }
            // tra loi khi khong co sdt
        LoggerConfiguration::logInfo('Check for reply_comment_nophone case');
        $message = empty($post_comment_nophone) ? $this->config['reply_comment_nophone'] : $post_comment_nophone;
        if ($message) {
            LoggerConfiguration::logInfo('Reply for nophone');
            return $post_comment_nophone;
        }
        return null;
    }

    private function _hideComment($comment_id, $post_id, $page_id, $fanpage_token_key)
    {
        LoggerConfiguration::logInfo('Hide comment');
        return $this->_loadFBAPI()->hide_comment($comment_id, $post_id, $page_id, $fanpage_token_key);
    }

    private function _getPostInfo($post_id)
    {
        $cache_params = array(
            'type' => 'post',
            'page_id' => $post_id
        );
        if ($post = $this->caching->get($cache_params)) {
            return $post;
        }
        if ($post = $this->_getDB()->getPostInfo($post_id)) {
            if (isset($post['reply_by_scripting']) && $post['reply_by_scripting']) {
                $post['reply_by_scripting'] = unserialize($post['reply_by_scripting']);
            }
            $this->caching->store($cache_params, $post, CachingConfiguration::POST_TTL);
            return $post;
        }
        return null;
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

    protected function processConversation($page_id, &$data, $time)
    {
        LoggerConfiguration::logInfo("GET PAGE ID=$page_id");
        $page = $this->_getPageInfo($page_id);
        if (! $page || $page['status'] != 0) {
            return false;
        }
        $fanpage_token_key = $page['token'];
        $fb_page_id = $page['id'];
        $group_id = $page['group_id'];
        $thread_id = $data['changes'][0]['value']['thread_id'];
        // Load message trong conversation
        LoggerConfiguration::logInfo('GET MESSAGE FROM CONVERSATION');
        $messages = $this->_loadFBAPI()->get_conversation_messages($thread_id, $page_id, $fanpage_token_key, null, $time, 1);
        if (! $messages) {
            LoggerConfiguration::logInfo('Not found message');
            // truong hop user xoa inbox => bo qua
            return null;
        }
        // customer_id chinh la nguoi bat dau inbox
        $fb_user_id = $messages[0]['from']['id'];
        if ($this->_isSkipFBUserID($fb_user_id, $page_id)) {
            return null;
        }
        $msg_content = $messages[0]['message'];
        if ($word = $this->_isWordsBlackList($msg_content)) {
            return false;
        }
        $fb_user_name = $messages[0]['from']['name'];
        $message_id = $messages[0]['id'];
        $message_time = strtotime($messages[0]['created_time']);
        // Kiem tra xem ton tai conversation chua
        $conversation = $this->_loadConversation(null, $thread_id, null);
        $fb_customer_id = $this->_getDB()->createCustomer($group_id, $fb_user_id, $fb_user_name, null);
        $is_update_conversation = false;
        if (! $conversation) {
            // chua ton tai conversation => tao moi
            LoggerConfiguration::logInfo('CREATE CONVERSATION');
            if ($fb_conversation_id = $this->_getDB()->saveConversationInbox($group_id, $page_id, $fb_page_id, $fb_user_id, $fb_user_name, $thread_id, $time, $fb_customer_id, $msg_content)) {
                $is_update_conversation = true;
                if ($phone = $this->_includedPhone($msg_content)) {
                    LoggerConfiguration::logInfo('CHECK PHONE IN BLACKLIST');
                    if ($this->_isPhoneBlocked($phone)) {
                        return false;
                    }
                    LoggerConfiguration::logInfo('REPLY INBOX IN CASE INCLUDED PHONE');
                    $this->_processInboxHasPhone($group_id, $fb_conversation_id, $fb_page_id, $thread_id, $page_id, $fanpage_token_key);
                } else {
                    LoggerConfiguration::logInfo('REPLY INBOX IN CASE DONT INCLUDED PHONE');
                    $this->_processInboxNoPhone($group_id, $fb_conversation_id, $fb_page_id, $thread_id, $page_id, $fanpage_token_key);
                }
            }
        } else
            $fb_conversation_id = $conversation['id'];
        if (! $fb_conversation_id) {
            return false;
        }
        LoggerConfiguration::logInfo('SAVE MESSAGE TO CONVERSATION');
        $this->_getDB()->createConversationMessage($group_id, $fb_conversation_id, $msg_content, $fb_user_id, $message_id, $message_time, $fb_page_id, $fb_customer_id, $is_update_conversation);
    }

    private function _processCommentChat($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $fb_user_id, $fb_user_name, $comment_id, $parent_comment_id, $comment, $fb_customer_id, $comment_time)
    {
        LoggerConfiguration::logInfo('Create post comment');
        // get comment cha
        $fb_conversation_id = 0;
        if ($conversation = $this->_loadConversation(null, null, $parent_comment_id))
            $fb_conversation_id = $conversation['id'];
        if (! $fb_conversation_id) {
            // la comment cap 1 va chua tao conversation => tao conversation
            // tao conversation
            LoggerConfiguration::logInfo('Create conversation comment');
            $fb_conversation_id = $this->_getDB()->saveConversationComment($group_id, $fb_customer_id, $fb_page_id, $page_id, $fb_user_id, $comment_id, $comment_time, $comment, $fb_user_name, $post_id, $fb_post_id);
            $fb_conversation_id = $fb_conversation_id ? $fb_conversation_id : 0;
        } else {
            // update comment
            $this->_getDB()->updateConversationComment($fb_conversation_id, $comment, $comment_time);
        }
        $fb_comment_id = $this->_getDB()->createCommentPost($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $fb_user_id, $comment_id, $fb_conversation_id, $parent_comment_id, $comment, $fb_customer_id, $comment_time);
        return array(
            'fb_conversation_id' => $fb_conversation_id,
            'fb_comment_id' => $fb_comment_id ? $fb_comment_id : 0
        );
    }

    private function _processOrder($phone, $fb_user_id, $fb_user_name, $post_id, $fb_post_id, $page_id, $fb_page_id, $group_id, $product_id, $fb_comment_id, $bundle_id, $price, $telco)
    {
        LoggerConfiguration::logInfo('Create customer');
        $fb_customer_id = $this->_getDB()->createCustomer($group_id, $fb_user_id, $fb_user_name, $phone);
        if (! $fb_customer_id)
            $fb_customer_id = 0;
        $duplicate_info = $this->_getDB()->getOrderDuplicate($fb_user_id, $product_id, $phone, $group_id);
        $is_duplicate = $duplicate_info ? 1 : 0;
        LoggerConfiguration::logInfo('Create order');
        $order_code = $this->_generateOrderCode();
        if ($order_id = $this->_getDB()->createOrder($group_id, $fb_page_id, $fb_post_id, $fb_comment_id, $phone, $product_id, $bundle_id, $fb_user_name, $order_code, $fb_customer_id, ORDER_STATUS_DEFAULT, $price, $is_duplicate, $duplicate_info, $telco)) {
            LoggerConfiguration::logInfo('Create order product relation');
            if ($this->_getDB()->createOrderProduct($order_id, $product_id, $price, 1)) {
                return array(
                    'order_id' => $order_id,
                    'fb_customer_id' => $fb_customer_id
                );
            }
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
            if ($val)
                $this->config[$config['_key']] = $val;
        }
        if (! $this->config) {
            LoggerConfiguration::logError('Not found config', __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        LoggerConfiguration::logInfo('Config: ' . print_r($this->config, true));
        // store cache
        LoggerConfiguration::logInfo('Store config to cache');
        if (! $caching->store($cache_params, $this->config, CachingConfiguration::CONFIG_TTL)) {
            LoggerConfiguration::logInfo('Error store cache');
        }
        return $this->config;
    }

    private function _includedPhone(&$str)
    {
        $cont = str_replace(array(
            '.',
            '-',
            ','
        ), '', $str);
        $cont = preg_replace('/\s+/', '', $cont);
        if (preg_match('/[0-9]{9,13}/', $cont, $matches)) {
            return $this->_standardInternationlPhoneNumber($matches[0]);
            
        }
        return false;
    }

    private function _standardInternationlPhoneNumber($phoneNumber)
    {
        // Cho viettel????
        if (substr($phoneNumber, 0, 1) === '0')
            $phoneNumber = '84' . substr($phoneNumber, 1);
        else 
            if (substr($phoneNumber, 0, 2) !== '84')
                $phoneNumber = '84' . $phoneNumber;
            
            /*
         * if (strlen($phoneNumber)<10)
         * return $phoneNumber;
         * if (substr($phoneNumber, 0, 1)==="+")
         * $phoneNumber=substr($phoneNumber, 1);
         * //chuyen ve dang 84
         * if (substr($phoneNumber, 0, 2)!=="84")
         * $phoneNumber="84" . substr($phoneNumber, 1);
         */
        return $phoneNumber;
    }

    private function _isPhoneBlocked($phone)
    {
        if ($phone_filter = $this->config['phone_filter']) {
            foreach ($phone_filter as $pattern) {
                $pattern = trim($pattern);
                if (! $pattern) {
                    continue;
                }
                if (strpos($phone, $pattern) !== false) {
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
            return true;
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
        return $this->_loadFBAPI()->deleteWebHook();
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

    public function chat($group_chat_id, &$message)
    {
        $H = date('YmdH');
        $M = date('Ym');
        LoggerConfiguration::overrideLogger("{$M}/{$H}_chat.log");
        LoggerConfiguration::logInfo("Chat: group_chat_id=$group_chat_id; msg=$message");
        $conversation = $this->_loadConversation($group_chat_id, null, null);
        if (! $conversation) {
            LoggerConfiguration::logError("Not found conversation with conversation_id=$group_chat_id", __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        $this->_loadConfig(array(
            'group_id' => $conversation['group_id']
        ));
        if (! $this->config) {
            LoggerConfiguration::logError("Not found config for group_id={$conversation['group_id']}", __CLASS__, __FUNCTION__, __LINE__);
            return false;
        }
        $type = intval($conversation['type']);
        switch ($type) {
            case 1:
                return $this->_chat_comment($conversation, $message);
            case 0:
                return $this->_chat_inbox($conversation, $message);
            
            default:
                return false;
        }
    }

    private function _loadConversation($fb_conversation_id, $conversation_id, $comment_id)
    {
        LoggerConfiguration::logInfo('Load conversation from cache');
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
            LoggerConfiguration::logInfo('Not Found conversation from cache => get DB');
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

    private function _chat_comment(&$comment, &$message)
    {
        // thuc hien comment
        LoggerConfiguration::logInfo('Comment: ' . print_r($comment, true));
        $replied_comment_id = $this->_loadFBAPI()->reply_comment($comment['comment_id'], null, $comment['page_id'], $message, $comment['token']);
        if (! $replied_comment_id)
            return false;
            // thanh cong
        $fb_customer_id = 0;
        LoggerConfiguration::logInfo('Store DB');
        // $this->_getDB()->createCommentPost($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $fb_user_id, $comment_id, $fb_conversation_id, $parent_comment_id, $content, $fb_customer_id, $comment_time);
        if (! $this->_getDB()->createCommentPost($comment['group_id'], $comment['page_id'], $comment['fb_page_id'], $comment['post_id'], $comment['fb_post_id'], $comment['page_id'], $replied_comment_id, $comment['id'], $comment['comment_id'], $message, $fb_customer_id, time())) {
            LoggerConfiguration::logInfo('Store error');
        }
        return true;
    }

    private function _chat_inbox(&$conversation, $message)
    {
        $replied_id = $this->_loadFBAPI()->reply_message($conversation['page_id'], $conversation['conversation_id'], $conversation['token'], $message);
        if (! $replied_id)
            return false;
            // thanh cong
        LoggerConfiguration::logInfo('Save DB');
        if (! $this->_getDB()->createConversationMessage($conversation['group_id'], $conversation['id'], $message, '', $replied_id, time(), $conversation['fb_page_id'], 0)) {
            LoggerConfiguration::logInfo('Save DB error');
        }
        return true;
    }
    
    // Code of Mr Nghia
    private function _postUrl($url, $params = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // var_dump($url);
        // var_dump($params);
        
        $array = array();
        foreach ($params as $key => $value) {
            $array[] = urlencode($key) . '=' . urlencode($value);
        }
        $postData = implode('&', $array);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.12) Gecko/2009070611 Firefox/3.0.12");
        // $start = microtime(TRUE);
        $p = curl_exec($ch);
        // $finish = microtime(TRUE);
        // $info = curl_getinfo($ch);
        // $error = curl_error($ch);
        curl_close($ch);
        // return array('info' => $info, 'content' => $p, 'error'=>$error);
    }

    private function _getTelcoByPhone($phone)
    {
        $list_telco = array(
            'viettel'=>array('8496','8497','8498','84162','84163','84164','84165','84166','84167','84168','84169'),
            'vina'=>array('8488','8491','8494','84123','84124','84125','84127','84129'),
            'mobi'=>array('8490','8493','84120','84121','84122','84126','84128','8489'),
            'vietnamobile' => array('8492','84188','88186'),
            'sphone'=>array('8495'),
            'gmobile'=>array('8499','84199'),
        );
        $dauso = strlen($phone)===11?substr($phone, 0, 4):substr($phone, 5);
        if (in_array($dauso, $list_telco['viettel'])){
            return 'viettel';
        }elseif (in_array($dauso, $list_telco['vina'])){
            return 'vina';
        }
        elseif (in_array($dauso, $list_telco['mobi'])){
            return 'mobi';
        }
        elseif (in_array($dauso, $list_telco['vietnamobile'])){
            return 'vietnamobile';
        }
        elseif (in_array($dauso, $list_telco['sphone'])){
            return 'sphone';
        }
        elseif (in_array($dauso, $list_telco['gmobile'])){
            return 'gmobile';
        }
        return '';
    }
    
    private function _likeComment($comment_id, $page_id, $page_token) {
        LoggerConfiguration::logInfo("Like to comment_id=$comment_id");
        $this->_loadFBAPI()->like($comment_id, $page_id, $page_token);
    }
}