<?php
require_once dirname ( __FILE__ ) . '/src/db/FBDBProcess.php';
require_once dirname ( __FILE__ ) . '/src/caching/FBSCaching.php';
require_once dirname ( __FILE__ ) . '/src/core/Fanpage.core.php';
define ( 'DEFAULT_GROUP_ID', 1 );
class FB {
	private $db = null;
	private $config = null;
	public function __construct() {
		$this->db = new FBDBProcess ();
	}
	private function _getDB() {
		if (! $this->db->checkConnection ())
			$this->db = new FBDBProcess ();
		return $this->db;
	}
	public function loadFanpge($group_id) {
		// gearman_worker_fetch_order_number
		$this->_loadConfig ( array (
				'group_id' => $group_id ? $group_id : DEFAULT_GROUP_ID 
		) );
		if (! $this->config) {
			LoggerConfiguration::logInfo ( 'Not found config' );
			return;
		}
		$gearman_worker_fetch_order_number = $this->config ['gearman_worker_fetch_order_number'];
		return $this->_getDB ()->loadPages ( $group_id, $gearman_worker_fetch_order_number );
	}
	/**
	 * Lay nhung conversation moi
	 *
	 * @param unknown $group_id        	
	 */
	public function fetchConversation($fb_page_id, $worker, $hostname) {
		$H = date ( 'YmdH' );
		$M = date ( 'Ym' );
		LoggerConfiguration::overrideLogger ( "{$M}/{$H}_fetchConversation_{$hostname}_{$worker}.log" );
		LoggerConfiguration::logInfo ( '--- START ---' );
		LoggerConfiguration::logInfo ( 'Load config' );
		LoggerConfiguration::logInfo ( "fb_page_id=$fb_page_id, worker=$worker, hostname=$hostname" );
		$this->_loadConfig ( array (
				'fb_page_id' => $fb_page_id 
		) );
		if (! $this->config) {
			//
			return;
		}
		$current_time = time ();
		$fp = new Fanpage ();
		$page = $this->_getDB ()->getPage ( $fb_page_id );
		if (! $page) {
			LoggerConfiguration::logInfo ( 'Not found page' );
			return;
		}
		LoggerConfiguration::logInfo ( 'Process for page: ' . print_r ( $page, true ) );
		$page_id = $page ['page_id'];
		$token = $page ['token'];
		$fb_page_id = $page ['id'];
		$since_time = $page ['last_conversation_time'] ? $page ['last_conversation_time'] : 0;
		LoggerConfiguration::logInfo ( 'Get conversation for page' );
		$conversations = $fp->get_page_conversation ( $page_id, $token, $since_time, null, $this->config ['fb_graph_limit_conversation_page'] );
		if (! $conversations) {
			LoggerConfiguration::logInfo ( 'Not found conversation' );
			LoggerConfiguration::logInfo ( 'Update page last conversation time' );
			$this->_getDB ()->updatePageLastConversationTime ( $fb_page_id, $current_time );
			return;
		}
		foreach ( $conversations as &$conversation ) {
			if (intval ( $conversation ['message_count'] ) > 1 && count ( $conversation ['senders'] ['data'] ) > 1) {
				// truong hop cung 1 nguoi gui nhieu message => conversation moi
				continue;
			}
			$conversation_id = $conversation ['id'];
			// chi lan lay 1 message
			$messages = $fp->get_conversation_messages ( $conversation_id, $page_id, $token, null, null, 1 );
			if (! $messages) {
				LoggerConfiguration::logInfo ( 'Not found message' );
				// truong hop user xoa inbox => bo qua
				$conversation = null;
				continue;
			}
			// lay cac thong tin khac
			$conversation ['group_id'] = $page ['group_id'];
			$conversation ['page_id'] = $page_id;
			$conversation ['fb_page_id'] = $fb_page_id;
			// customer_id chinh la nguoi bat dau inbox
			$fb_user_id = $messages [0] ['from'] ['id'];
			$reply_msg = null;
			$phone = null;
			if ($phone = $this->_includedPhone ( $messages [0] ['message'] )) {
				if ($this->config ['reply_conversation_has_phone']) {
					$reply_msg = $this->config ['reply_conversation_has_phone'];
				}
				LoggerConfiguration::logInfo ( 'Create customer' );
				$fb_name = $messages [0] ['from'] ['name'];
				$fb_customer_id = $this->_getDB ()->createCustomer ( $page ['group_id'], $fb_user_id, $fb_name, $phone );
			} else {
				if ($this->config ['reply_conversation_nophone']) {
					$reply_msg = $this->config ['reply_conversation_nophone'];
				}
			}
			if ($reply_msg) {
				LoggerConfiguration::logInfo ( "Reply to conversation with msg=$reply_msg" );
				$reply_time = time ();
				if ($reply = $fp->reply_message ( $page_id, $conversation_id, $token, $reply_msg )) {
					$reply_msg_id = $reply ['id'];
					// add reply vao DB
					$messages [] = array (
							'message' => $reply_msg,
							'id' => $reply_msg_id,
							'from' => array (
									'id' => $page_id 
							),
							'created_time' => $reply_time 
					);
				}
			}
			// lay customer tuong ung voi fb_user_id
			if (! $phone)
				$fb_customer_id = $this->_getDB ()->getCustomer ( $fb_user_id, $phone );
			$conversation ['fb_customer_id'] = $fb_customer_id ? $fb_customer_id : 0;
			$conversation ['fb_user_id'] = $fb_user_id;
			$conversation ['last_conversation_time'] = strtotime ( $conversation ['updated_time'] );
			LoggerConfiguration::logInfo ( 'Save conversation to DB' );
			if ($fb_conversation_id = $this->_getDB ()->saveConversation ( $conversation )) {
				LoggerConfiguration::logInfo ( 'Save conversation messages to DB' );
				if (! $this->_getDB ()->saveConversationMessage ( $page ['group_id'], $fb_conversation_id, $messages, $fb_page_id )) {
					LoggerConfiguration::logInfo ( 'Save conversation messages error' );
				}
			}
		}
		LoggerConfiguration::logInfo ( 'Update page last conversation time' );
		$this->_getDB ()->updatePageLastConversationTime ( $fb_page_id, $current_time );
		LoggerConfiguration::logInfo ( '--- END ---' );
	}
	public function fetchOrder($fb_page_id, $worker, $hostname) {
		$H = date ( 'YmdH' );
		$M = date ( 'Ym' );
		LoggerConfiguration::overrideLogger ( "{$M}/{$H}_fetchOrder_{$hostname}_{$worker}.log" );
		// B1. Lay thoi diem thuc hien lan truoc
		$fp = new Fanpage ();
		LoggerConfiguration::logInfo ( '--- START ---' );
		LoggerConfiguration::logInfo ( "FANPAGE=$fb_page_id, WORKER=$worker, HOSTNAME=$hostname" );
		$this->_loadConfig ( array (
				'fb_page_id' => $fb_page_id 
		) );
		if (! $this->config) {
			return;
		}
		LoggerConfiguration::logInfo ( 'Config Data: ' . print_r ( $this->config, true ) );
		$current_time = time ();
		$current_day = date ( 'Ymd', $current_time );
		$first = true;
		while ( true ) {
			LoggerConfiguration::init ( 'STEP 1: LOAD POST' );
			$posts = $this->_getDB ()->loadPost ( $fb_page_id, $this->config ['fb_graph_post_limit'], $worker, $hostname, $first );
			if (! $posts) {
				LoggerConfiguration::logInfo ( 'Not found post' );
				break;
			}
			LoggerConfiguration::logInfo ( 'STEP 2.1: PROCESS POST' );
			foreach ( $posts as $post ) {
				LoggerConfiguration::logInfo ( 'Post: ' . print_r ( $post, true ) );
				$update_data = array (
						'gearman_hostname' => '', // reset lai server&// reset lai worker
						'gearman_worker' => '' 
				);
				// xy lu tung post
				LoggerConfiguration::logInfo ( "PostID: {$post['post_id']}, PageID: {$post['page_id']}, GroupID: {$post['group_id']}" );
				$fanpage_token_key = $post ['token'];
				$post_id = $post ['post_id'];
				$fb_post_id = $post ['id'];
				$page_id = $post ['page_id'];
				$product_id = $post ['product_id'];
				$bundle_id = $post ['bundle_id'];
				$price = $post ['price'];
				$from_time = $post ['last_time_fetch_comment'];
				$current_group_id = $post ['group_id'];
				$last_day = $from_time ? date ( 'Ymd', $from_time ) : null;
				// lay comment cua post (order)
				$is_nocomment = false;
				if (empty ( $post ['next_time_fetch_comment'] ))
					$post ['next_time_fetch_comment'] = $current_time;
				if (empty ( $post ['last_time_fetch_comment'] ))
					$post ['last_time_fetch_comment'] = $current_time;
				LoggerConfiguration::logInfo ( 'STEP 3: LOAD COMMENT' );
				$comments = $fp->get_comment_post ( $post_id, $page_id, $fanpage_token_key, $this->config ['fb_graph_limit_comment_post'], $from_time, $this->config ['user_coment_filter'], $this->config ['max_comment_time_support'] );
				if (! $comments) {
					$is_nocomment = true; // khong co comment nao
					if ($fp->error) {
						LoggerConfiguration::logError ( $fp->error, __CLASS__, __FUNCTION__, __LINE__ );
					}
					LoggerConfiguration::logInfo ( 'No comment' );
				} else {
					LoggerConfiguration::logInfo ( 'STEP 4: PROCESS COMMENT' );
					foreach ( $comments as $comment ) {
						LoggerConfiguration::logInfo ( 'Comment data: ' . print_r ( $comment, true ) );
						$message = $comment ['message'];
						$comment_id = $comment ['id'];
						$fb_user_id = $comment ['from'] ['id'];
						$fb_name = $comment ['from'] ['name'];
						$comment_time = strtotime ( $comment ['created_time'] );
						$parent_comment_id = $comment ['parent_comment_id'] ? $comment ['parent_comment_id'] : 0;
						LoggerConfiguration::logInfo ( "Parent comment ID=$parent_comment_id" );
						$reply_comment_id = $parent_comment_id ? $parent_comment_id : $comment_id;
						if ($phone = $this->_includedPhone ( $message )) {
							LoggerConfiguration::logInfo ( 'This comment included phone number' );
							// Chan so dien thoai
							if ($this->_isPhoneBlocked ( $phone )) {
								LoggerConfiguration::logInfo ( "Phone=$phone be blocked" );
								continue;
							}
							// comment co kem theo sdt
							// 1. tao order
							LoggerConfiguration::logInfo ( 'Create order' );
							$this->_createOrder ( $fb_user_id, $current_group_id, $fb_page_id, $page_id, $fb_post_id, $post_id, $phone, $product_id, $bundle_id, $fb_name, $comment_id, $parent_comment_id, $message, $price, $comment_time );
							// 2. comment phan hoi
							$comment_reply = $this->_isEmptyData ( $post ['answer_phone'] ) ? $this->config ['reply_comment_nophone'] : $post ['answer_phone'];
							if (! empty ( $comment_reply )) {
								LoggerConfiguration::logInfo ( "Reply this comment, message: {$post ['answer_phone']}" );
								if (! $fp->reply_comment ( $reply_comment_id, $post_id, $page_id, $post ['answer_phone'], $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Reply error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
							}
							// 3. an comment (neu cau hinh cho phep)
							$hide_comment = $this->_isEmptyData ( $post ['hide_phone_comment'] ) ? $this->config ['hide_phone_comment'] : $post ['hide_phone_comment'];
							if ($hide_comment) {
								LoggerConfiguration::logInfo ( 'Hide comment' );
								if (! $fp->hide_comment ( $comment_id, $post_id, $page_id, $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Hide comment error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
							}
						} else {
							// tra loi comment
							if (! $parent_comment_id) {
								$comment_reply = $this->_isEmptyData ( $post ['answer_nophone'] ) ? $this->config ['reply_comment_nophone'] : $post ['answer_nophone'];
								if (! empty ( $post ['answer_nophone'] )) {
									LoggerConfiguration::logInfo ( "Reply this comment, message: {$post ['answer_nophone']}" );
									if (! $fp->reply_comment ( $reply_comment_id, $post_id, $page_id, $post ['answer_nophone'], $fanpage_token_key )) {
										LoggerConfiguration::logError ( "Reply error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
									}
								}
							}
							// la comment con cua comment thi thoi bo qua
						}
						// like comment
						if ($this->config ['like_comment'] && $comment ['can_like']) {
							// thuc hien like comment
							LoggerConfiguration::logInfo ( 'Like comment' );
							if (! $fp->like ( $comment_id, $page_id, $fanpage_token_key )) {
								LoggerConfiguration::logError ( "Like error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
							}
						}
					}
					LoggerConfiguration::logInfo ( 'STEP 4.2 END PROCESS COMMENT' );
				}
				if ($is_nocomment) {
					// khong co comment nao
					LoggerConfiguration::logInfo ( 'No comment for this post' );
					// 1. neu chua qua so ngay nodata (nodata_number_day) tang so luot dem
					// 2. da qua so luot nodata_number: reset so luot va gian thoi gian thuc hien lay comment
					if ($post ['nodata_number_day'] >= $this->config ['max_nodata_comment_day']) {
						LoggerConfiguration::logInfo ( "nodata_number_day={$post ['nodata_number_day']} >= max_nodata_comment_day={$this->config ['max_nodata_comment_day']}" );
						if ($current_day > $last_day) {
							// thoi diem thuc hien cronjob la cua ngay hom sau (lan dau)
							LoggerConfiguration::logInfo ( "current_day=$current_day > last_day=$last_day" );
							LoggerConfiguration::logInfo ( 'Reset nodata_number_day' );
							$update_data ['nodata_number_day'] = 0;
							// reset so dem nodata_number_day & gian cach thoi gian lan xu ly sau
							$next_level_fetch_comment = intval ( $post ['level_fetch_comment'] ) + 1;
							$update_data ['level_fetch_comment'] = $next_level_fetch_comment;
							if (isset ( $this->config ['level_fetch_comment'] [$next_level_fetch_comment] )) {
								// dua vao level de dat thoi gian xu ly tiep theo
								$next_time_fetch_comment = intval ( $post ['next_time_fetch_comment'] ) + $this->config ['level_fetch_comment'] [$next_level_fetch_comment];
								$update_data ['next_time_fetch_comment'] = $next_time_fetch_comment;
							} else {
								// vuot qua so level cau hinh => bo qua post nay
								$update_data ['status'] = 1;
							}
						} else {
							// van thuc hien trong ngay hom do => update lai thoi diem lay comment (theo level hien tai)
						}
					} else {
						// update lai thoi diem lay comment (theo level hien tai)
					}
					// update lai thoi diem lay comment (theo level hien tai)
					if (isset ( $this->config ['level_fetch_comment'] [$post ['level_fetch_comment']] )) {
						$update_data ['next_time_fetch_comment'] = intval ( $post ['next_time_fetch_comment'] ) + intval ( $this->config ['level_fetch_comment'] [$post ['level_fetch_comment']] );
					} else {
						$update_data ['status'] = 1;
					}
				} else {
					LoggerConfiguration::logInfo ( 'Found any comments for this post' );
					// luu lai thoi diem thuc hien => lan sau chi lay comment tu thoi diem nay tro di thoi => tang toc he thong
					$update_data ['last_time_fetch_comment'] = $current_time;
					// reset so dem nodata_number_day
					$update_data ['nodata_number_day'] = 0;
					// dua level ve 0 de cho phep lay comment nhanh hon
					$update_data ['level_fetch_comment'] = 0;
					$update_data ['next_time_fetch_comment'] = intval ( $post ['next_time_fetch_comment'] ) + intval ( $this->config ['level_fetch_comment'] [0] );
				}
				// cap nhat du lieu post
				LoggerConfiguration::logInfo ( 'Update for this post' );
				$update_data ['modified'] = date ( 'Y-m-d H:i:s' );
				LoggerConfiguration::logInfo ( print_r ( $update_data, true ) );
				$this->_getDB ()->updatePost ( $fb_post_id, $update_data );
			}
			if (count ( $posts ) < $this->config ['fb_graph_post_limit']) {
				LoggerConfiguration::logInfo ( 'Over post data' );
				break;
			}
			LoggerConfiguration::logInfo ( 'STEP 2.2: END PROCESS POST' );
		}
		$this->_getDB ()->close ();
		LoggerConfiguration::logInfo ( '--- END ---' );
	}
	private function _includedPhone(&$str) {
		if (empty ( $this->config ['preg_pattern_phone'] ))
			return false;
		if (preg_match ( "/{$this->config['preg_pattern_phone']}/", $str, $matches )) {
			return $matches [0];
		}
		return false;
	}
	/**
	 *
	 * @param unknown $by
	 *        	$by = array(
	 *        	'group_id'=>1,
	 *        	'fb_page_id'=>1,
	 *        	'fb_post_id'=>1,
	 *        	'fb_conversation_id'=>1,
	 *        	'fb_comment_id'=>1
	 *        	)
	 */
	private function _loadConfig($by) {
		// return array (
		// 'fb_graph_post_limit' => LOAD_POST_LIMIT,
		// 'fb_graph_limit_comment_post' => FB_LIMIT_COMMENT_POST,
		// 'max_nodata_comment_day' => 5,
		// 'level_fetch_comment' => array (
		// "0" => 120, // cu 2 phut duoc phep lay 1 lan,
		// "1" => 180
		// ),
		// 'user_coment_filter' => array ( // danh sach user comment bo qua; vi day la cac comment cua cskh
		// '734899429950601'
		// )
		// );
		LoggerConfiguration::logInfo ( 'Load config by: ' . print_r ( $by, true ) );
		$caching = new FBSCaching ();
		LoggerConfiguration::logInfo ( 'Get config from cache' );
		$c_config_data = null;
		$config_data = null;
		if (array_key_exists ( 'group_id', $by )) {
			$cache_params = array (
					'type' => 'config',
					'group_id' => $by ['group_id'] 
			);
			$c_config_data = $caching->get ( $cache_params );
			if (! $c_config_data) {
				$config_data = $this->_getDB ()->loadConfigByGroup ( $by ['group_id'] );
			}
		} elseif (array_key_exists ( 'fb_page_id', $by )) {
			$cache_params = array (
					'type' => 'config',
					'fb_page_id' => $by ['fb_page_id'] 
			);
			$c_config_data = $caching->get ( $cache_params );
			if (! $c_config_data) {
				$config_data = $this->_getDB ()->loadConfigByPage ( $by ['fb_page_id'] );
			}
		} elseif (array_key_exists ( 'fb_post_id', $by )) {
			$cache_params = array (
					'type' => 'config',
					'fb_post_id' => $by ['fb_post_id'] 
			);
			$c_config_data = $caching->get ( $cache_params );
			if (! $c_config_data) {
				$config_data = $this->_getDB ()->loadConfigByPost ( $by ['fb_post_id'] );
			}
		} else
			return null;
		if ($c_config_data) {
			LoggerConfiguration::logInfo ( 'Found cache' );
			$this->config = $c_config_data;
			return $this->config;
		}
		LoggerConfiguration::logInfo ( 'Not found cache' );
		if (! $config_data) {
			LoggerConfiguration::logInfo ( 'Not found config from DB' );
			return false;
		}
		LoggerConfiguration::logInfo ( 'FOUND config from DB' );
		foreach ( $config_data as $config ) {
			$type = intval ( $config ['type'] );
			$val = null;
			switch ($type) {
				case 0 :
					// text
					$val = $config ['value'];
					break;
				case 1 :
					// json
					$val = json_decode ( $config ['value'], true );
					break;
				case 2 :
					// array: 1,2,3,45466,fdfs
					$val = explode ( ',', $config ['value'] );
					break;
				case 3 :
					// array: 1,2,3,45466,fdfs
					$val = intval ( $config ['value'] );
					break;
				
				default :
					;
					break;
			}
			if ($val)
				$this->config [$config ['_key']] = $val;
		}
		if ($this->config) {
			LoggerConfiguration::logInfo ( 'Config: ' . print_r ( $this->config, true ) );
			// store cache
			LoggerConfiguration::logInfo ( 'Store config to cache' );
			$caching->store ( $cache_params, $this->config, CachingConfiguration::CONFIG_TTL );
		}
		return $this->config;
	}
	private $default_status_id = null;
	private function _getDefaultStatusId($group_id) {
		if (! $this->default_status_id)
			$this->default_status_id = $this->_getDB ()->getDefaultStatusID ( $group_id );
		return $this->default_status_id;
	}
	private function _createOrder($fb_user_id, $group_id, $fb_page_id, $page_id, $fb_post_id, $post_id, $phone, $product_id, $bundle_id, $fb_name, $comment_id, $parent_comment_id, $comment, $price, $comment_time) {
		LoggerConfiguration::logInfo ( 'Create customer' );
		$fb_customer_id = $this->_getDB ()->createCustomer ( $group_id, $fb_user_id, $fb_name, $phone );
		if (! $fb_customer_id)
			return false;
		LoggerConfiguration::logInfo ( 'Create post comment' );
		// get comment cha
		if ($parent_comment_id) {
			$parent_comment = $this->_getDB ()->getComment ( null, $parent_comment_id );
			if ($parent_comment) {
				$fb_parent_comment_id = $parent_comment ['id'];
			} else
				$fb_parent_comment_id = 0; // truong hop comment parrent khong duoc luu vi la comment khong chua sdt => khong tao order
		} else
			$fb_parent_comment_id = 0;
		$fb_comment_id = $this->_getDB ()->createCommentPost ( $group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $comment_id, $fb_parent_comment_id, $parent_comment_id, $comment, $fb_customer_id, $comment_time );
		if (! $fb_comment_id)
			$fb_comment_id = 0; // khong xac dinh; nen cho tiep tuc de de co the lay duoc order???
		$status_id = $this->_getDefaultStatusId ( $group_id );
		if (! $status_id)
			$status_id = - 1; // khong xac dinh; nen cho tiep tuc de de co the lay duoc order???
		$duplicate_id = $this->_getDB ()->getOrderDuplicate ( $fb_customer_id, $product_id );
		if (! $duplicate_id)
			$duplicate_id = 0;
		LoggerConfiguration::logInfo ( 'Create order' );
		$this->_getDB ()->set_auto_commit ( false );
		$order_code = $this->generateRandomString ( 10 );
		if ($order_id = $this->_getDB ()->createOrder ( $group_id, $fb_page_id, $fb_post_id, $fb_comment_id, $phone, $product_id, $bundle_id, $fb_name, $order_code, $fb_customer_id, $status_id, $price, $duplicate_id )) {
			LoggerConfiguration::logInfo ( 'Create order product relation' );
			if ($this->_getDB ()->createOrderProduct ( $order_id, $product_id, $price, 1 )) {
				$this->_getDB ()->commit ();
				$this->_getDB ()->set_auto_commit ( true );
				return true;
			}
			$this->_getDB ()->rollback ();
			$this->_getDB ()->set_auto_commit ( true );
			return false;
		}
		$this->_getDB ()->set_auto_commit ( true );
		return false;
	}
	public function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen ( $characters );
		$randomString = '';
		for($i = 0; $i < $length; $i ++) {
			$randomString .= $characters [rand ( 0, $charactersLength - 1 )];
		}
		return $randomString;
	}
	public function syncChat($group_chat_id, $type = 'comment') {
		$H = date ( 'YmdH' );
		$M = date ( 'Ym' );
		LoggerConfiguration::overrideLogger ( "{$M}/{$H}_chat.log" );
		LoggerConfiguration::logInfo ( "Sync chat: group_chat_id=$group_chat_id; type=$type" );
		switch ($type) {
			case 'comment' :
				return $this->_syncCommentChat ( $group_chat_id );
			case 'inbox' :
				return $this->_syncConversation ( $group_chat_id );
			
			default :
				return false;
		}
	}
	private function _syncConversation($fb_conversation_id) {
		LoggerConfiguration::logInfo ( 'Load conversation' );
		$conversation = $this->_getDB ()->loadConversation ( $fb_conversation_id );
		if (! $conversation) {
			LoggerConfiguration::logInfo ( 'Not found conversation' );
			return false;
		}
		$this->_loadConfig ( array (
				'group_id' => $conversation ['group_id'] 
		) );
		if (! $this->config) {
			LoggerConfiguration::logInfo ( 'Not found config' );
			return false;
		}
		$fp = new Fanpage ();
		LoggerConfiguration::logInfo ( 'Conversation: ' . print_r ( $conversation, true ) );
		LoggerConfiguration::logInfo ( 'Get message for this conversation' );
		$conversation_id = $conversation ['conversation_id'];
		$page_id = $conversation ['page_id'];
		$fanpage_token_key = $conversation ['token'];
		$since_time = $conversation ['last_conversation_time'];
		$until_time = time ();
		$messages = $fp->get_conversation_messages ( $conversation_id, $page_id, $fanpage_token_key, $since_time, $until_time, $this->config ['fb_graph_limit_message_conversation'] );
		if ($messages) {
			LoggerConfiguration::logInfo ( 'messages: ' . print_r ( $messages, true ) );
			LoggerConfiguration::logInfo ( 'Save messages' );
			$group_id = $conversation ['group_id'];
			$fb_page_id = $conversation ['fb_page_id'];
			if (! $this->_getDB ()->saveConversationMessage ( $group_id, $conversation ['id'], $messages, $fb_page_id, 0 )) {
				LoggerConfiguration::logInfo ( 'Save error' );
				return false;
			}
		}
		LoggerConfiguration::logInfo ( 'Update last conversation time' );
		// cap nhat thoi gian lay conversation de khong lay conversation cu nua
		if (! $this->_getDB ()->updateConversationLastConversationTime ( $conversation ['id'], $until_time )) {
			LoggerConfiguration::logInfo ( 'Update error' );
		}
		return true;
	}
	private function _syncCommentChat($fb_parent_comment_id) {
		$comment = $this->_getDB ()->getComment ( $fb_parent_comment_id );
		if (! $comment) {
			LoggerConfiguration::logError ( "Not found comment with comment_id=$fb_parent_comment_id", __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
		$this->_loadConfig ( array (
				'group_id' => $comment ['group_id'] 
		) );
		if (! $this->config) {
			LoggerConfiguration::logInfo ( 'Not found config' );
			return false;
		}
		LoggerConfiguration::logInfo ( 'Comment: ' . print_r ( $comment, true ) );
		$fp = new Fanpage ();
		$last_comment_time = time ();
		$comments = $fp->get_comment_post ( $comment ['comment_id'], $comment ['page_id'], $comment ['token'], $this->config ['fb_graph_limit_comment_post'], $comment ['last_comment_time'], null, $this->config ['max_comment_time_support'] );
		if ($comments === false) {
			LoggerConfiguration::logError ( 'Error get comment', __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
		if ($comments) {
			$fb_customer_id = $this->_getDB ()->getCustomer ( $comment ['from'] ['id'], null );
			if (! $fb_customer_id)
				$fb_customer_id = 0;
			LoggerConfiguration::logInfo ( 'Sync DB' );
			if (! $this->_getDB ()->syncCommentChat ( $comment ['group_id'], $fb_customer_id, $comment ['fb_page_id'], $comment ['page_id'], $comment ['fb_post_id'], $comment ['post_id'], $comment ['id'], $comment ['comment_id'], $comments )) {
				LoggerConfiguration::logInfo ( 'Sync error' );
				return false;
			}
		} else
			LoggerConfiguration::logInfo ( 'Not found comment' );
		if (! $this->_getDB ()->updateLastCommentTime ( $fb_parent_comment_id, $last_comment_time )) {
			LoggerConfiguration::logInfo ( 'Update updateLastCommentTime error' );
		}
		return true;
	}
	private function _isEmptyData(&$data) {
		return is_null ( $data ) || empty ( $data );
	}
	public function chat($group_chat_id, $message, $type = 'comment') {
		$H = date ( 'YmdH' );
		$M = date ( 'Ym' );
		LoggerConfiguration::overrideLogger ( "{$M}/{$H}_chat.log" );
		LoggerConfiguration::logInfo ( "Chat: group_chat_id=$group_chat_id; type=$type; msg=$message" );
		switch ($type) {
			case 'comment' :
				return $this->_chat_comment ( $group_chat_id, $message );
			case 'inbox' :
				return $this->_chat_inbox ( $group_chat_id, $message );
			
			default :
				return false;
		}
	}
	private function _chat_comment($fb_comment_id, $message) {
		// thuc hien comment
		$comment = $this->_getDB ()->getComment ( $fb_comment_id );
		if (! $comment) {
			LoggerConfiguration::logError ( "Not found comment with comment_id=$fb_comment_id", __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
		LoggerConfiguration::logInfo ( 'Comment: ' . print_r ( $comment, true ) );
		$fp = new Fanpage ();
		$rep_data = $fp->reply_comment ( $comment ['comment_id'], null, $comment ['page_id'], $message, $comment ['token'] );
		if (! $rep_data)
			return false;
		if (key_exists ( 'id', $rep_data ) && ! empty ( $rep_data ['id'] )) {
			// thanh cong
			$fb_customer_id = 0;
			LoggerConfiguration::logInfo ( 'Store DB' );
			if (! $this->_getDB ()->createCommentPost ( $comment ['group_id'], $comment ['page_id'], $comment ['fb_page_id'], $comment ['post_id'], $comment ['fb_post_id'], $rep_data ['id'], $comment ['id'], $message, $fb_customer_id, $comment_time )) {
				LoggerConfiguration::logInfo ( 'Store error' );
			}
			// luu vao DB luon
			return true;
		}
		return false;
	}
	private function _chat_inbox($fb_conversation_id, $message) {
		// old: getPageByConversation
		$conversation = $this->_getDB ()->loadConversation ( $fb_conversation_id );
		if (! $conversation) {
			LoggerConfiguration::logError ( "Not found conversation with conversation_id=$fb_conversation_id", __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
		$fp = new Fanpage ();
		$rep_data = $fp->reply_message ( $conversation ['page_id'], $conversation ['conversation_id'], $conversation ['token'], $message );
		if (! $rep_data)
			return false;
		if (key_exists ( 'id', $rep_data ) && ! empty ( $rep_data ['id'] )) {
			// thanh cong
			LoggerConfiguration::logInfo ( 'Save DB' );
			if (! $this->_getDB ()->createConversationMessage ( $conversation ['group_id'], $fb_conversation_id, $message, '', $rep_data ['id'], time (), $conversation ['page_id'], 0 )) {
				LoggerConfiguration::logInfo ( 'Save DB error' );
			}
			return true;
		}
		return false;
	}
	private function _isPhoneBlocked($phone) {
		if ($phone_filter = $this->config ['phone_filter']) {
			$blocked_phone_pattern = explode ( ',', $phone_filter );
			if ($blocked_phone_pattern) {
				foreach ( $blocked_phone_pattern as $pattern ) {
					if (preg_match ( $pattern, $phone )) {
						return true;
					}
				}
			}
		}
		return false;
	}
	public function __destruct() {
	}
}