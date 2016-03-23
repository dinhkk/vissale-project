<?php
require_once dirname ( __FILE__ ) . '/fbapi.php';
require_once dirname ( __FILE__ ) . '/../logger/LoggerConfiguration.php';
class Fanpage {
	private $facebook_api = null;
	public $error;
	public function __construct() {
		$this->facebook_api = fbapi_instance ();
	}
	/**
	 * Lay danh sach fanpage ma user lam admin
	 *
	 * @param string $user_token_key
	 *        	tokenkey cua user
	 * @return false if error; null or [{
	 *         "access_token": "CAACEdEose...D",
	 *         "category": "Product/Service",
	 *         "name": "Gain Social Followers",
	 *         "id": "734899429950601",
	 *         "perms": [
	 *         "ADMINISTER",
	 *         "EDIT_PROFILE",
	 *         "CREATE_CONTENT",
	 *         "MODERATE_CONTENT",
	 *         "CREATE_ADS",
	 *         "BASIC_ADMIN"
	 *         ]
	 *         },
	 *         ...
	 *         ]
	 */
	public function get_list($user_token_key) {
		try {
			$res = $this->facebook_api->get ( '/me/accounts', $user_token_key, null, FB_API_VER );
			LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
			$res_data = json_decode ( $res->getBody (), true );
			if (! $res_data) {
				$this->error = 'Error FBAPI reuqest format';
				return false;
			}
			return ! empty ( $res_data ['data'] ) ? $res_data ['data'] : null;
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	
	/**
	 * Lay danh sach post cua fanpage
	 *
	 * @param string $fanpage_id
	 *        	id cua fanpage
	 * @param string $fanpage_token_key
	 *        	tokenkey cua fanpage
	 * @param timestamp $until_time
	 *        	- $since_time
	 * @return false if error; null or
	 *         [
	 *         {
	 *         "message": "xxxx",
	 *         "created_time": "2015-02-13T07:49:57+0000",
	 *         "id": "734899429950601_739601006147110"
	 *         },
	 *         ...
	 *         ]
	 */
	public function get_post($fanpage_id, $fanpage_token_key, $since_time, $until_time) {
		try {
			$data = array ();
			$limit = FB_LIMIT_POST_FANPAGE;
			$end_point = "/{$fanpage_id}/posts?since={$since_time}&until={$until_time}&limit={$limit}";
			while ( true ) {
				$res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, FB_API_VER );
				LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
				$res_data = json_decode ( $res->getBody (), true );
				if (! $res_data) {
					$this->error = 'Error FBAPI reuqest format';
					break;
				}
				if (! empty ( $res_data ['data'] )) // merge data
					$data = array_merge_recursive ( $data, $res_data ['data'] );
					// check next page
				if (! empty ( $res_data ['paging'] ['next'] )) {
					// lay thong so __paging_token
					$url = parse_url ( $res_data ['paging'] ['next'] );
					parse_str ( $url ['query'], $params );
					if (in_array ( '__paging_token', $params )) {
						$end_point .= "&__paging_token={$params['__paging_token']}";
					} else
						break;
				} else // out of data
					break;
			}
			return ! empty ( $data ) ? $data : null;
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	/**
	 * Lay danh sach comment cua post
	 *
	 * @param string $post_id
	 *        	id cua post
	 * @param string $fanpage_id
	 *        	id cua Fanpage
	 * @param string $fanpage_token_key
	 *        	tokenkey cua Fanpage
	 * @param timestamp $from_time
	 *        	thoi diem bat dau lay
	 * @return false - Error
	 *         null - nodata
	 *         or
	 *         [
	 *         {
	 *         "from": {
	 *         "name": "Quyết Đại Ca",
	 *         "id": "371169396379031"
	 *         },
	 *         "message": "https://www.youtube.com/watch?v=E7vB4W6CF0k",
	 *         "created_time": "2015-02-14T03:43:30+0000",
	 *         "id": "739601006147110_740063899434154"
	 *         },
	 *         ...
	 *         ]
	 */
	public function get_comment_post($post_id, $fanpage_id, $fanpage_token_key, $limit, $from_time = null, $comment_user_filter = null, $max_comment_time_support = null, $fields = 'comment_count,message,created_time,from') {
		try {
			$data = array ();
			$current_time = time ();
			// order=chronological => order theo thoi gian
			$end_point = "/{$post_id}/comments?order=reverse_chronological&limit={$limit}&fields=$fields";
			while ( true ) {
				LoggerConfiguration::logInfo ( "Endpoint: $end_point" );
				$res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, FB_API_VER );
				$res_data = json_decode ( $res->getBody (), true );
				LoggerConfiguration::logInfo ( 'Response: ' . $res->getBody () );
				if (! $res_data) {
					$this->error = 'Error FBAPI reuqest format';
					break;
				}
				if (! empty ( $res_data ['data'] )) {
					foreach ( $res_data ['data'] as $comment ) {
						$user_comment_id = ( string ) $comment ['from'] ['id'];
						$created_time = strtotime ( $comment ['created_time'] );
						if ($max_comment_time_support && $created_time <= ($current_time - $max_comment_time_support)) {
							// comment nay qua cu roi => bo qua de tang toc he thong
							break;
						}
						if ($created_time >= $from_time && ! in_array ( $user_comment_id, $comment_user_filter )) {
							// chi lay comment tu $last_comment_time
							$comment ['parent_comment_id'] = null;
							$data [] = $comment;
						} else {
							// kiem tra co comment cua comment hay khong
						}
						// kiem tra co comment cua comment hay khong
						if ($comment ['comment_count'] == 0) {
							// khong co comment con => bo qua
							continue;
						} else {
							$parrent_comment_id = $comment ['id'];
							// co comment con
							$child_comments = $this->get_comment_post ( $parrent_comment_id, $fanpage_id, $fanpage_token_key, $limit, $from_time, $comment_user_filter, $max_comment_time_support );
							if ($child_comments) {
								// co ton tai comment con moi
								foreach ( $child_comments as $child ) {
									$child ['parent_comment_id'] = $parrent_comment_id;
									$data [] = $child;
								}
							} else {
								// khong co comment con nao
								continue;
							}
						}
					}
				}
				$end_point = $this->_after ( $res_data, $end_point );
				if (! $end_point)
					break; // out of data
			}
			return count ( $data ) ? $data : null;
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	private function _after(&$res_data, $current_end_point) {
		// check next page
		if (! empty ( $res_data ['paging'] ['cursors'] ['after'] )) {
			return "{$current_end_point}&after={$res_data ['paging'] ['cursors']['after']}";
		} else // out of data
			return false;
	}
	/**
	 * Tra loi mot comment
	 *
	 * @param string $comment_id
	 *        	neu comment_id = null thi se thuc hien comment cho $post_id
	 * @param string $post_id
	 *        	id cua post
	 * @param string $message
	 *        	noi dung cua message
	 * @return array( "id"=>"739601006147110_942205109220031")
	 */
	public function reply_comment($comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key) {
		try {
			$end_point = $comment_id ? "/{$comment_id}/comments" : "/{$post_id}/comments";
			LoggerConfiguration::logInfo ( "Reply enpoint: $end_point" );
			$message = $this->_toUtf8String ( $message );
			$res = $this->facebook_api->post ( $end_point, array (
					'message' => $message 
			), $fanpage_token_key, null, FB_API_VER );
			LoggerConfiguration::logInfo ( 'Reply response:' . $res->getBody () );
			return json_decode ( $res->getBody (), true );
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	/**
	 * An comment truong hop comment co kem sdt
	 *
	 * @param string $comment_id
	 *        	id cua comment
	 * @param string $post_id
	 *        	id cua post
	 * @return true - success
	 */
	public function hide_comment($comment_id, $post_id, $fanpage_id, $fanpage_token_key) {
		try {
			$res = $this->facebook_api->post ( "/{$comment_id}", array (
					'is_hidden' => true 
			), $fanpage_token_key, null, FB_API_VER );
			LoggerConfiguration::logInfo ( 'Hide message response:' . $res->getBody () );
			$res_data = json_decode ( $res->getBody (), true );
			if (isset ( $res_data ['success'] ) && $res_data ['success'])
				return true;
			return $res_data;
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	/**
	 * Lay danh sach cac hoi thoai messages cua fanpage
	 *
	 * @param string $fanpage_id
	 *        	id cua fanpage
	 * @param string $fanpage_token_key
	 *        	tokenkey cua fanpage
	 * @return [ {
	 *         "updated_time": "2016-03-16T16:19:35+0000",
	 *         "link": "/gainsocialfollowers/manager/messages/?mercurythreadid=user%3A100009086388170&threadid=mid.1423815438741%3A08950771566a90bc92&folder=inbox",
	 *         "id": "t_mid.1423815438741:08950771566a90bc92"
	 *         },
	 *         ...
	 *         ]
	 */
	public function get_page_conversation($fanpage_id, $fanpage_token_key, $since_time, $until_time, $limit_graph, $fields = 'message_count,updated_time,link,id,senders') {
		try {
			$data = array ();
			$end_point = "/{$fanpage_id}/conversations?limit=$limit_graph&fields=$fields";
			if ($since_time)
				$end_point .= "&since=$since_time";
			if ($until_time)
				$end_point .= "&until=$until_time";
			while ( true ) {
				$res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, FB_API_VER );
				LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
				$res_data = json_decode ( $res->getBody (), true );
				if (! $res_data) {
					$this->error = 'Error FBAPI reuqest format';
					break;
				}
				if (! empty ( $res_data ['data'] )) // merge data
					$data = array_merge_recursive ( $data, $res_data ['data'] );
					// check next page
				$end_point = $this->_next ( $res_data, $end_point );
				if (! $end_point) // out of data
					break;
			}
			return ! empty ( $data ) ? $data : null;
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	/**
	 * Lay noi dung messasge trong mot conversation
	 *
	 * @param string $conversation_id
	 *        	id cua conversation
	 * @param string $fanpage_id
	 *        	id cua fanpage
	 * @param string $fanpage_token_key
	 *        	tokenkey cua Fanpage
	 * @param int $limit        	
	 * @param timestamp $since_time
	 *        	thoi diem bat dau lay
	 * @param timestamp $until_time
	 *        	thoi diem ket thuc lay
	 * @return NULL|mixed[]|boolean [
	 *         {
	 *         "message": "xin chao ban",
	 *         "created_time": "2016-03-15T06:59:17+0000",
	 *         "id": "m_mid.1458025157758:0e7e1e4b19de446f54"
	 *         },
	 *         ...
	 *         ]
	 */
	public function get_conversation_messages($conversation_id, $fanpage_id, $fanpage_token_key, $since_time, $until_time, $fb_graph_limit_message_conversation, $fields = 'message,created_time,from') {
		try {
			$data = array ();
			$end_point = "/{$conversation_id}/messages?fields=$fields&limit={$fb_graph_limit_message_conversation}&since=$since_time&until=$until_time";
			while ( true ) {
				$res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, FB_API_VER );
				$res_data = json_decode ( $res->getBody (), true );
				LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
				if (! $res_data) {
					$this->error = 'Error FBAPI reuqest format';
					break;
				}
				if (! empty ( $res_data ['data'] )) {
					foreach ( $res_data ['data'] as $msg ) {
						$data [] = $msg;
					}
				}
				$end_point = $this->_next ( $res_data, $end_point );
				if (! $end_point) // out of data
					break;
			}
			return ! empty ( $data ) ? $data : null;
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	// tra ve enpoint o page tiep theo (paging)
	private function _next(&$res_data, $current_end_point) {
		if (! empty ( $res_data ['paging'] ['next'] )) {
			// lay thong so __paging_token
			$url = parse_url ( $res_data ['paging'] ['next'] );
			parse_str ( $url ['query'], $params );
			if (in_array ( '__paging_token', $params )) {
				return "{$current_end_point}&__paging_token={$params['__paging_token']}";
			} else
				return false;
		} else // out of data
			return false;
	}
	/**
	 * Tra loi message trong conversation
	 *
	 * @param string $conversation_id
	 *        	id cua conversation
	 * @param string $fanpage_token_key
	 *        	tokenkey cua fanpage
	 * @return success - { "id": "m_mid.1458145175883:28ec859a74a716d480",
	 *         "uuid": "mid.1458145175883:28ec859a74a716d480"
	 *         }
	 */
	public function reply_message($fanpage_id, $conversation_id, $fanpage_token_key, $message) {
		try {
			$res = $this->facebook_api->post ( "/{$conversation_id}/messages", array (
					'message' => $this->_toUtf8String ( $message ) 
			), $fanpage_token_key, null, FB_API_VER );
			LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
			return json_decode ( $res->getBody (), true );
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	private function _toUtf8String(&$string) {
		return $string;
		// return html_entity_decode ( preg_replace ( "/U\+([0-9A-F]{4})/", "&#x\\1;", $string ), ENT_NOQUOTES, 'UTF-8' );
		if (! function_exists ( 'mb_htmlentities' )) {
			function mb_htmlentities($str, $hex = true, $encoding = 'UTF-8') {
				return preg_replace_callback ( '/[\x{80}-\x{10FFFF}]/u', function ($match) use ($hex) {
					return sprintf ( $hex ? '&#x%X;' : '&#%d;', mb_ord ( $match [0] ) );
				}, $str );
			}
		}
		return mb_htmlentities ( $string );
	}
}