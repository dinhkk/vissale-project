<?php
require_once dirname ( __FILE__ ) . '/fbapi.php';
require_once dirname ( __FILE__ ) . '/../logger/LoggerConfiguration.php';
class Fanpage {
	private $facebook_api = null;
	private $fb_api_ver = FB_API_VER;
	public $error;
	public function __construct(&$config) {
		$this->facebook_api = fbapi_instance ($config);
		if ($config['fb_app_version']){
		    $this->fb_api_ver = $config['fb_app_version'];
		}
	}
	
	/**
	 * Lay thong tin post (su dung kiem tra post co thuoc mot page nao khong)
	 * @param unknown $post_id
	 * @param unknown $fanpage_token_key
	 */
	public function getPostDetail($post_id, $fanpage_token_key){
	    try {
	        $res = $this->facebook_api->get ( "/$post_id/", $fanpage_token_key, null, $this->fb_api_ver );
	        LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
	        $res_data = json_decode ( $res->getBody (), true );
	        if (! $res_data) {
	            LoggerConfiguration::logError('Error FBAPI reuqest format', __CLASS__, __FUNCTION__, __LINE__);
	            return false;
	        }
	        return $res_data;
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
	        return false;
	    }
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
			$res = $this->facebook_api->get ( '/me/accounts', $user_token_key, null, $this->fb_api_ver );
			LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
			$res_data = json_decode ( $res->getBody (), true );
			if (! $res_data) {
				LoggerConfiguration::logError('Error FBAPI reuqest format', __CLASS__, __FUNCTION__, __LINE__);
				return false;
			}
			return ! empty ( $res_data ['data'] ) ? $res_data ['data'] : null;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
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
	public function get_post($fanpage_id, $fanpage_token_key, $since_time, $until_time, $limit=10) {
		try {
			$data = array ();
			$end_point = "/{$fanpage_id}/posts?since={$since_time}&until={$until_time}&limit={$limit}";
			while ( true ) {
				$res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, $this->fb_api_ver );
				LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
				$res_data = json_decode ( $res->getBody (), true );
				if (! $res_data) {
					LoggerConfiguration::logError('Error FBAPI reuqest format', __CLASS__, __FUNCTION__, __LINE__);
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
			LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
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
	public function get_comment_post($post_id, $fanpage_id, $fanpage_token_key, $limit, $from_time = null, $comment_user_filter = null, $max_comment_time_support = null, $fields = 'comment_count,message,created_time,from,can_like', $is_comment = false) {
		try {
			$data = null;
			$current_time = time ();
			// order=chronological => order theo thoi gian
			$end_point = "/{$post_id}/comments?order=reverse_chronological&limit={$limit}&fields=$fields";
			//while ( true ) {
			// Tam thoi de toi da 3 request
			$max = $is_comment?1:3;
			for ($i=0; $i<$max; $i++){
				LoggerConfiguration::logInfo ( "Endpoint: $end_point" );
				$res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, $this->fb_api_ver );
				$res_data = json_decode ( $res->getBody (), true );
				LoggerConfiguration::logInfo ( 'Response: ' . $res->getBody () );
				if (! $res_data) {
					LoggerConfiguration::logError('Error FBAPI reuqest format', __CLASS__, __FUNCTION__, __LINE__);
					break;
				}
				if (is_array($res_data) && isset($res_data ['data'])) {
				    $count_comment = count($res_data['data']);
				    if (!$count_comment){
				        break;
				    }
				    // ton tai comment
				    $is_too_old = false;
					foreach ( $res_data ['data'] as $comment ) {
						$user_comment_id = ( string ) $comment ['from'] ['id'];
						$created_time = strtotime ( $comment ['created_time'] );
						if ($max_comment_time_support && $created_time <= ($current_time - $max_comment_time_support)) {
							// comment nay qua cu roi => bo qua de tang toc he thong
							LoggerConfiguration::logInfo ( "Comment_id={$comment['id']} is too old" );
							$is_too_old = true;
							break;
						}
						if ($created_time > $from_time) {
							// chi lay comment tu $last_comment_time
							//$comment ['parent_comment_id'] = $is_comment ? $post_id : null; // la lay comment cua comment => post_id=parent_comment_id
							if(! in_array ( $user_comment_id, $comment_user_filter )) {
						      $data [] = $comment;
						      // tiep theo la di kiem tra cac comment con
							}
							else 
							    continue; // comment boi fb_id bi loc => bo qua
						} else {
						    // truong hop comment cu (da xu ly roi)
							// kiem tra co comment cua comment hay khong
						    if ($is_comment){
						        // truong hop la lay comment con cua comment
						        // khi gap comment cu => break luon
						        $is_too_old = true; // coi la cu roi => de bo qua luon
						        break;
						    }
						    // con khong thi kiem tra cac comment con
						}
						// kiem tra co comment cua comment hay khong
						if ($is_comment){
						    //truong hop la lay comment con cua comment
						    // se khong co comment con nua
						    continue;
						}
						if (intval ( $comment ['comment_count'] ) === 0) {
							LoggerConfiguration::logInfo ( 'No child' );
							// khong co comment con => bo qua
							continue;
						} else {
							$parrent_comment_id = $comment ['id'];
							// co comment con
							$child_comments = $this->get_comment_post ( $parrent_comment_id, $fanpage_id, $fanpage_token_key, $comment ['comment_count'], $from_time, $comment_user_filter, $max_comment_time_support, $fields, true );
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
					if ($is_too_old){
					    break;
					}
				}
				else {
				    LoggerConfiguration::logInfo('No comment');
					break;
				}
				if (!$data){
				    // Khong lay duoc comment nao => bo qua ????? dang bi loi request qua nhieu fb
				    break;
				}
				if ($count_comment < $limit){
				    // so comment lay ve khong it hon so limit => coi nhu het comment roi
				    break;
				}
				// thuc hien next page tiep theo
				$end_point = $this->_after ( $res_data, $end_point );
				if (! $end_point)
					break; // out of data
			}
			return $data ? $data : null;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
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
	public function reply_comment($comment_id, $post_id, $fanpage_id, $message, $fanpage_token_key, $fb_user_id = null, $fb_user_name = null) {

	    try {

			$end_point = $comment_id ? "/{$comment_id}/comments" : "/{$post_id}/comments";

            LoggerConfiguration::logInfo ( "Reply endpoint: $end_point" );
			//$message = $this->_toUtf8String ( $message );

			$res = $this->facebook_api->post ( $end_point, array (
					'message' =>  "$message @$fb_user_name",
			), $fanpage_token_key, null, $this->fb_api_ver );
			LoggerConfiguration::logInfo ( "Reply for: $fb_user_id" );
			LoggerConfiguration::logInfo ( 'Reply response:' . $res->getBody () );
			if( $data = json_decode ( $res->getBody (), true )){
			    return $data['id']?$data['id']:false;
			}

		} catch ( Exception $e ) {
			LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
			return false;
		}

		return false;
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
			), $fanpage_token_key, null, $this->fb_api_ver );

			LoggerConfiguration::logInfo ( 'Hide message response:' . $res->getBody () );
			$res_data = json_decode ( $res->getBody (), true );
			if (isset ( $res_data ['success'] ) && $res_data ['success'])
				return true;
			return $res_data;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
			return false;
		}
	}

    public function getCommentMessage($comment_id, $fanpage_token_key)
    {
        try {
            $res = $this->facebook_api->get("/$comment_id/", $fanpage_token_key, null, $this->fb_api_ver);
            $result = $res->getDecodedBody();
            return $result['message'];
        } catch (Exception $e) {
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
			    LoggerConfiguration::logInfo ( "Enpoint: $end_point" );
				$res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, $this->fb_api_ver );
				LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
				$res_data = json_decode ( $res->getBody (), true );
				if (! $res_data) {
					LoggerConfiguration::logError('Error FBAPI reuqest format', __CLASS__, __FUNCTION__, __LINE__);
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
			LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
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
			    LoggerConfiguration::logInfo ( "Enpoint: $end_point" );
				$res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, $this->fb_api_ver );
				$res_data = json_decode ( $res->getBody (), true );
				LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
				if (! $res_data) {
					LoggerConfiguration::logError('Error FBAPI reuqest format', __CLASS__, __FUNCTION__, __LINE__);
					break;
				}
				if (! empty ( $res_data ['data'] )) {
					foreach ( $res_data ['data'] as $msg ) {
						$data [] = $msg;
					}
					if (count($data)>=$fb_graph_limit_message_conversation){
					    break;
					}
				}
				$end_point = $this->_next ( $res_data, $end_point );
				if (! $end_point) // out of data
					break;
			}
			return ! empty ( $data ) ? $data : null;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError($e->getMessage() . "\n" . "FB-PageID:{$fanpage_id}", __CLASS__, __FUNCTION__, __LINE__);
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
			), $fanpage_token_key, null, $this->fb_api_ver );
			LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
			if($data = json_decode ( $res->getBody (), true )){
			    return $data['id']?$data['id']:false;
			}
			return false;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
			return false;
		}
	}

	/**
	 *
	 * **/
    public function getMessageAttachments($message_id, $fanpage_id, $fanpage_token_key)
    {
        try {
            $end_point = "/{$message_id}/attachments";
            $res = $this->facebook_api->get ( $end_point, $fanpage_token_key, null, $this->fb_api_ver );
            $res_data = json_decode ( $res->getBody (), true );

            return $res_data;

        } catch (Exception $e) {
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
	public function like($comment_id, $fanpage_id, $fanpage_token_key) {
		try {
			$res = $this->facebook_api->post ( "/{$comment_id}/likes", array (
					'message' => $this->_toUtf8String ( $message ) 
			), $fanpage_token_key, null, $this->fb_api_ver );
			LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
			return json_decode ( $res->getBody (), true );
		} catch ( Exception $e ) {
			LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
			return false;
		}
	}
	public static function getPageIdOfPost($post_id) {
		$url = "http://facebook.com/$post_id";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HEADER, true );
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true ); // Must be set to true so that PHP follows any "Location:" header
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		
		$a = curl_exec ( $ch ); // $a will contain all headers
		if (! $a) {
			return false;
		}
		$url = curl_getinfo ( $ch, CURLINFO_EFFECTIVE_URL ); // This is what you need, it will return you the last effective URL
		curl_close($ch);
		if (! $url) {
			return false;
		}
		$parts = parse_url ( $url );
		parse_str ( $parts ['query'], $query );
		if (is_array($query) && array_key_exists ( 'id', $query )) {
			return $query ['id']; // page_id
		}
		return false;
	}
	
	public function getPageSubscribedApps($page_id, $fanpage_token_key) {
	    try {
	        $res = $this->facebook_api->get ( "/{$page_id}/subscribed_apps", $fanpage_token_key, null, $this->fb_api_ver );
	        LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
	        return json_decode ( $res->getBody (), true );
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
	        return false;
	    }
	}
	
	public function createPageSubscribedApps($page_id, $fanpage_token_key) {
        LoggerConfiguration::logInfo ( "createPageSubscribedApps for $page_id with $fanpage_token_key"  );
	    try {
	        $res = $this->facebook_api->post ( "/{$page_id}/subscribed_apps", array(), $fanpage_token_key, null, $this->fb_api_ver );
	        LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
	        return json_decode ( $res->getBody (), true );
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
	        return false;
	    }
	}
	
	public function deletePageSubscribedApps($page_id, $fanpage_token_key) {
	    try {
	        $res = $this->facebook_api->delete( "/{$page_id}/subscribed_apps", array(), $fanpage_token_key, null, $this->fb_api_ver );
	        LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
	        return json_decode ( $res->getBody (), true );
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
	        return false;
	    }
	}
	
	public function getWebhookSubscriptions ($app_id ) {
	    try {
	        $res = $this->facebook_api->get( "/{$app_id}/subscriptions", $this->facebook_api->getApp()->getAccessToken(), null, $this->fb_api_ver );
	        LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
	        return json_decode ( $res->getBody (), true );
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
	        return false;
	    }
	}
	
	public function createWebhook($object='page', $fields='feed,conversations' ) {
	    try {
	        $params = array(
	            'object'=>$object,
	            'callback_url'=>FB_APP_CALLBACK_URL,
	            'fields'=>$fields,
	            'verify_token'=>FB_APP_VERIFY_TOKEN
	        );
	        LoggerConfiguration::logInfo ( 'Params:' . print_r($params, true) );
	        $app_id = $this->facebook_api->getApp()->getId();
	        $res = $this->facebook_api->post( "/{$app_id}/subscriptions", $params, $this->facebook_api->getApp()->getAccessToken(), null, $this->fb_api_ver );
	        LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
	        if($rs = json_decode ( $res->getBody (), true )){
	            if ($rs['success']){
	                return true;
	            }
	        }
	        return false;
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
	        return false;
	    }
	}
	
	public function deleteWebhook($app_id, $object='page' ) {
	    try {
	        $res = $this->facebook_api->delete( "/{$app_id}/subscriptions", array('object'=>$object), $this->facebook_api->getApp()->getAccessToken(), null, $this->fb_api_ver );
	        LoggerConfiguration::logInfo ( 'Response:' . $res->getBody () );
	        return json_decode ( $res->getBody (), true );
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError($e->getMessage(), __CLASS__, __FUNCTION__, __LINE__);
	        return false;
	    }
	}
}