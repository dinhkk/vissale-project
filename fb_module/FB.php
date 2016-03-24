<?php
require_once dirname ( __FILE__ ) . '/src/db/FBDBProcess.php';
require_once dirname ( __FILE__ ) . '/src/core/Fanpage.core.php';
class FB {
	private $db = null;
	private $config = null;
	public function __construct() {
		$this->db = new FBDBProcess ();
	}
	/**
	 * Lay nhung conversation moi
	 *
	 * @param unknown $group_id        	
	 */
	public function fetchConversation($group_id = null) {
		LoggerConfiguration::logInfo ( '--- START ---' );
		LoggerConfiguration::logInfo ( 'Load config' );
		$this->_loadConfig ( $group_id );
		if (! $this->config) {
			LoggerConfiguration::logInfo ( 'Not found config' );
			return;
		}
		$current_time = time ();
		$fp = new Fanpage ();
		LoggerConfiguration::logInfo ( 'Load fanpages' );
		$pages = $this->db->loadPages ( $group_id );
		if (! $pages)
			return;
		foreach ( $pages as $page ) {
			LoggerConfiguration::logInfo ( 'Process for page: ' . print_r ( $page, true ) );
			$page_id = $page ['page_id'];
			$token = $page ['token'];
			$fb_page_id = $page ['id'];
			$since_time = $page ['last_conversation_time'] ? $page ['last_conversation_time'] : 0;
			LoggerConfiguration::logInfo ( 'Get conversation for page' );
			$conversations = $fp->get_page_conversation ( $page_id, $token, $since_time, null, $this->config ['fb_graph_limit_conversation_page'] );
			if (! $conversations) {
				LoggerConfiguration::logInfo ( 'Not found conversation' );
				continue;
			}
			$message_list = null;
			$last_conversation_time = 0;
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
				// kiem tra message
				$reply_msg = null;
				$phone = null;
				if ($phone = $this->_includedPhone ( $messages [0] ['message'] )) {
					if ($this->config ['reply_conversation_has_phone']) {
						$reply_msg = $this->config ['reply_conversation_has_phone'];
					}
					LoggerConfiguration::logInfo ( 'Create customer' );
					$fb_name = $messages [0] ['from'] ['name'];
					$fb_customer_id = $this->db->createCustomer ( $page ['group_id'], $fb_user_id, $fb_name, $phone );
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
					$fb_customer_id = $this->db->getCustomer ( $fb_user_id, $phone );
				$conversation ['fb_customer_id'] = $fb_customer_id ? $fb_customer_id : 0;
				$conversation ['fb_user_id'] = $fb_user_id;
				$conversation ['last_conversation_time'] = strtotime ( $conversation ['updated_time'] );
				LoggerConfiguration::logInfo ( 'Save conversation to DB' );
				if ($fb_conversation_id = $this->db->saveConversation ( $conversation )) {
					LoggerConfiguration::logInfo ( 'Save conversation messages to DB' );
					if (! $this->db->saveConversationMessage ( $page ['group_id'], $fb_conversation_id, $messages, $fb_page_id )) {
						LoggerConfiguration::logInfo ( 'Save conversation messages error' );
					}
				}
				LoggerConfiguration::logInfo ( 'Update page last conversation time' );
				if ($conversation ['last_conversation_time'] > $last_conversation_time) {
					$last_conversation_time = $conversation ['last_conversation_time'];
					// cap nhat thoi gian lay conversation de khong lay conversation cu nua
					$this->db->updatePageLastConversationTime ( $fb_page_id, $last_conversation_time );
				}
			}
		}
	}
	public function fetchOrder($group_id = null) {
		// B1. Lay thoi diem thuc hien lan truoc
		$fp = new Fanpage ();
		LoggerConfiguration::logInfo ( '--- START ---' );
		$this->_loadConfig ( $group_id );
		if (! $this->config) {
			return;
		}
		LoggerConfiguration::logInfo ( 'Config Data: ' . print_r ( $this->config, true ) );
		$current_time = time ();
		$current_day = date ( 'Ymd', $current_time );
		while ( true ) {
			LoggerConfiguration::init ( 'STEP 1: LOAD POST' );
			$posts = $this->db->loadPost ( $group_id, $this->config ['fb_graph_post_limit'] );
			if (! $posts) {
				LoggerConfiguration::logInfo ( 'Not found post' );
				break;
			}
			LoggerConfiguration::logInfo ( 'STEP 2.1: PROCESS POST' );
			foreach ( $posts as $post ) {
				$update_data = array ();
				// xy lu tung post
				LoggerConfiguration::logInfo ( "PostID: {$post['post_id']}, PageID: {$post['page_id']}, GroupID: {$post['group_id']}" );
				$fanpage_token_key = $post ['token'];
				$post_id = $post ['post_id'];
				$fb_post_id = $post ['fb_post_id'];
				$page_id = $post ['page_id'];
				$fb_page_id = $post ['fb_page_id'];
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
						$parent_comment_id = $comment ['parent_comment_id'] ? $comment ['parent_comment_id'] : 0;
						if ($phone = $this->_includedPhone ( $message )) {
							LoggerConfiguration::logInfo ( 'This comment included phone number' );
							// comment co kem theo sdt
							// 1. tao order
							LoggerConfiguration::logInfo ( 'Create order' );
							$this->_createOrder ( $fb_user_id, $current_group_id, $fb_page_id, $page_id, $fb_post_id, $post_id, $phone, $product_id, $bundle_id, $fb_name, $comment_id, $parent_comment_id, $message, $price );
							// 2. comment phan hoi
							$comment_reply = $this->_isEmptyData($post ['answer_phone'])?$this->config['reply_comment_nophone']:$post ['answer_phone'];
							if (! empty ( $comment_reply )) {
								LoggerConfiguration::logInfo ( "Reply this comment, message: {$post ['answer_phone']}" );
								if (! $fp->reply_comment ( $comment_id, $post_id, $page_id, $post ['answer_phone'], $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Reply error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
							}
							// 3. an comment (neu cau hinh cho phep)
							$hide_comment = $this->_isEmptyData($post['hide_phone_comment'])?$this->config['hide_phone_comment']:$post['hide_phone_comment'];
							if ($hide_comment) {
								LoggerConfiguration::logInfo ( 'Hide comment' );
								if (! $fp->hide_comment ( $comment_id, $post_id, $page_id, $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Hide comment error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
							}
						} else {
							// tra loi comment
							$comment_reply = $this->_isEmptyData($post ['answer_nophone'])?$this->config['reply_comment_nophone']:$post ['answer_nophone'];
							if (! empty ( $post ['answer_nophone'] )) {
								LoggerConfiguration::logInfo ( "Reply this comment, message: {$post ['answer_nophone']}" );
								if (! $fp->reply_comment ( $comment_id, $post_id, $page_id, $post ['answer_nophone'], $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Reply error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
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
				$this->db->updatePost ( $post_id, $update_data );
			}
			if (count ( $posts ) < $this->config ['fb_graph_post_limit']) {
				LoggerConfiguration::logInfo ( 'Over post data' );
				break;
			}
			LoggerConfiguration::logInfo ( 'STEP 2.2: END PROCESS POST' );
		}
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
	private function _loadConfig($group_id = null) {
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
		$config_data = $this->db->loadConfig ( $group_id );
		if (! $config_data) {
			return false;
		}
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
		return $this->config;
	}
	private $default_status_id = null;
	private function _getDefaultStatusId($group_id) {
		if (! $this->default_status_id)
			$this->default_status_id = $this->db->getDefaultStatusID ( $group_id );
		return $this->default_status_id;
	}
	private function _createOrder($fb_user_id, $group_id, $fb_page_id, $page_id, $fb_post_id, $post_id, $phone, $product_id, $bundle_id, $fb_name, $comment_id, $parent_comment_id, $comment, $price) {
		LoggerConfiguration::logInfo ( 'Create customer' );
		$fb_customer_id = $this->db->createCustomer ( $group_id, $fb_user_id, $fb_name, $phone );
		if (! $fb_customer_id)
			return false;
		LoggerConfiguration::logInfo ( 'Create post comment' );
		$fb_comment_id = $this->db->createCommentPost ( $group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $comment_id, $parent_comment_id, $comment, $fb_customer_id );
		if (! $fb_comment_id)
			$fb_comment_id = 0; // khong xac dinh; nen cho tiep tuc de de co the lay duoc order???
		$status_id = $this->_getDefaultStatusId ( $group_id );
		if (! $status_id)
			$status_id = - 1; // khong xac dinh; nen cho tiep tuc de de co the lay duoc order???
		$duplicate_id = $this->db->getOrderDuplicate ( $fb_customer_id, $product_id );
		if (! $duplicate_id)
			$duplicate_id = 0;
		LoggerConfiguration::logInfo ( 'Create order' );
		$this->db->set_auto_commit ( false );
		$order_code = $this->generateRandomString ( 10 );
		if ($order_id = $this->db->createOrder ( $group_id, $fb_page_id, $fb_post_id, $fb_comment_id, $phone, $product_id, $bundle_id, $fb_name, $order_code, $fb_customer_id, $status_id, $price, $duplicate_id )) {
			LoggerConfiguration::logInfo ( 'Create order product relation' );
			if ($this->db->createOrderProduct ( $order_id, $product_id, $price, 1 )) {
				$this->db->commit ();
				$this->db->set_auto_commit ( true );
				return true;
			}
			$this->db->rollback ();
			$this->db->set_auto_commit ( true );
			return false;
		}
		$this->db->set_auto_commit ( true );
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
	public function syncConversation($group_id = null, $fb_page_id = null, $fb_conversation_id = null) {
		LoggerConfiguration::logInfo ( 'Load config' );
		$this->_loadConfig ( $group_id );
		if (! $this->config) {
			LoggerConfiguration::logInfo ( 'Not found config' );
			return false;
		}
		LoggerConfiguration::logInfo ( 'Load conversation' );
		$conversations = $this->db->loadConversation ( $group_id, $fb_page_id, $fb_conversation_id );
		if (! $conversations) {
			LoggerConfiguration::logInfo ( 'Not found any conversation' );
			return false;
		}
		$fp = new Fanpage ();
		foreach ( $conversations as $conversation ) {
			LoggerConfiguration::logInfo ( 'Conversation: ' . print_r ( $conversation, true ) );
			LoggerConfiguration::logInfo ( 'Get message for this conversation' );
			$conversation_id = $conversation ['conversation_id'];
			$page_id = $conversation ['page_id'];
			$fanpage_token_key = $conversation ['token'];
			$since_time = $conversation ['last_conversation_time'];
			$until_time = time ();
			$messages = $fp->get_conversation_messages ( $conversation_id, $page_id, $fanpage_token_key, $since_time, $until_time, $this->config ['fb_graph_limit_message_conversation'] );
			if (! $messages) {
				LoggerConfiguration::logInfo ( 'Not found any messages' );
				continue;
			}
			LoggerConfiguration::logInfo ( 'Save messages' );
			$group_id = $conversation ['group_id'];
			$fb_page_id = $conversation ['fb_page_id'];
			if (! $this->db->saveConversationMessage ( $group_id, $conversation ['id'], $messages, $fb_page_id, 0 )) {
				LoggerConfiguration::logInfo ( 'Save error' );
				if ($fb_conversation_id) {
					// dong bo cho 1 conversation (dung api)
					return false;
				}
			}
			LoggerConfiguration::logInfo ( 'Update last conversation time' );
			// cap nhat thoi gian lay conversation de khong lay conversation cu nua
			if (! $this->db->updateConversationLastConversationTime ( $conversation ['id'], $until_time )) {
				LoggerConfiguration::logInfo ( 'Update error' );
			}
		}
		return true;
	}
	
	private function _isEmptyData(&$data){
		return is_null($data) || empty($data);
	}
}