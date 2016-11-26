<?php
require_once dirname ( __FILE__ ) . '/DBProcess.php';
require_once dirname ( __FILE__ ) . '/../core/config.php';
class FBDBProcess extends DBProcess {
	public function getGroup($group_id = null) {
		try {
			$group_id = $this->real_escape_string ( $group_id );
			$group_id = intval ( $group_id );
			$this->set_auto_commit ( false );
			$query = "SELECT * FROM groups WHERE id=$group_id AND sync_page_expire>0 AND sync_page_transid<>'' AND sync_page_transid IS NOT NULL LIMIT 1 FOR UPDATE";
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				$this->set_auto_commit ( true );
				return false;
			}
			$group = null;
			if ($group = $result->fetch_assoc ()) {
				$this->free_result ( $result );
			}
			if (! $group) {
				$this->set_auto_commit ( true );
				return null;
			}
			// reset thong so sync page
			$current_time = time ();
			$query = "UPDATE groups SET last_time_sync_pages=$current_time,sync_page_transid='',sync_page_expire=0 WHERE id=$group_id";
			if (! $this->query ( $query )) {
				$this->set_auto_commit ( true );
				return false;
			}
			if ($this->affected_rows () !== 1) {
				$this->set_auto_commit ( true );
				// khong the update
				return false;
			}
			$this->set_auto_commit ( true );
			return $group;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function checkConnection() {
		return $this->getConnection () ? true : false;
	}
	public function loadConfigByGroup($group_id, $fields='') {
		try {
		    $fields_filter = $fields ? " AND _key IN ($fields)":'';
			$query = "SELECT _key,value,type FROM fb_cron_config WHERE group_id=$group_id $fields_filter";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			$config = null;
			if ($result) {
				while ( $n = $result->fetch_assoc () ) {
					$config [] = $n;
				}
				$this->free_result ( $result );
			}
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $config;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function loadConfigByConversation($fb_conversation_id) {
		try {
			$query = "SELECT c._key,c.value,c.type,c.group_id FROM fb_cron_config c 
			INNER JOIN fb_conversation cv ON cv.group_id=c.group_id
			WHERE cv.id=$fb_conversation_id";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			$config = null;
			if ($result) {
				while ( $n = $result->fetch_assoc () ) {
					$config [] = $n;
				}
				$this->free_result ( $result );
			}
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $config;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function loadConfigByPage($fb_page_id, $page_id=null) {
		try {
			if ($fb_page_id){
			    $query = "SELECT c._key,c.value,c.type,c.group_id FROM fb_cron_config c
			    INNER JOIN fb_pages p ON p.group_id=c.group_id
			    WHERE p.id=$fb_page_id";
			}
			else {
			    $query = "SELECT c._key,c.value,c.type,c.group_id FROM fb_cron_config c
			    INNER JOIN fb_pages p ON p.group_id=c.group_id
			    WHERE p.page_id='$page_id'";
			}
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			$config = null;
			if ($result) {
				while ( $n = $result->fetch_assoc () ) {
					$config [] = $n;
				}
				$this->free_result ( $result );
			}
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $config;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function loadConfigByPost($fb_post_id) {
		try {
			$query = "SELECT c._key,c.value,c.type,c.group_id FROM fb_cron_config c
			INNER JOIN fb_posts p ON p.group_id=c.group_id
			WHERE p.id=$fb_post_id";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			$config = null;
			if ($result) {
				while ( $n = $result->fetch_assoc () ) {
					$config [] = $n;
				}
				$this->free_result ( $result );
			}
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			// lay cau hinh cua post => se override cau hinh cua group
			$query = "SELECT answer_phone,answer_nophone,hide_phone_comment FROM fb_posts WHERE p.id=$fb_post_id LIMIT 1";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			$post_config = null;
			if ($result) {
				if ($n = $result->fetch_assoc ()) {
					// override
					if (! is_null ( $n ['hide_phone_comment'] ))
						$config ['hide_phone_comment'] = $n ['hide_phone_comment'];
					if (! is_null ( $n ['answer_phone'] ))
						$config ['reply_comment_has_phone'] = $n ['answer_phone'];
					
					if (! is_null ( $n ['answer_nophone'] ))
						$config ['reply_comment_nophone'] = $n ['answer_nophone'];
				}
				$this->free_result ( $result );
			}
			return $config;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function dropPages($group_id) {
		try {
			$group_id = $this->real_escape_string ( $group_id );
			$query = "DELETE FROM fb_pages WHERE group_id=$group_id";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return true;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	/**
	 *
	 * @param unknown $group_id        	
	 * @param unknown $page_id        	
	 * @param unknown $page_name        	
	 * @param unknown $token        	
	 * @param unknown $created_time
	 *        	$status = 0 -> kha dung; 1 - token bi expire, 2 - khong kha dung
	 */
	public function storePages($group_id, $page_id, $page_name, $token, $created_time) {
		$page_name = $this->real_escape_string ( $page_name );
		// kiem tra ton tai
		try {
			//$query = "SELECT id FROM fb_pages WHERE page_id='$page_id' AND group_id<>$group_id LIMIT 1";
		    $query = "SELECT id FROM fb_pages WHERE page_id='$page_id' LIMIT 1";
			$result = $this->query ( $query );
			if ($this->num_rows($result) === 1) {
				$this->free_result ( $result );
				// da ton tai tren group khac
				LoggerConfiguration::logError ( "Page_id=$page_id is unavaiable", __CLASS__, __FUNCTION__, __LINE__ );
				//return false;
				// update token
				$query = "UPDATE fb_pages SET token='$token' WHERE page_id='$page_id'";
			}
			else {
			    $current_time = date ( 'Y-m-d H:i:s' );
			    $current_timestamp = time();
			    //$group_id = $this->real_escape_string ( $group_id );
			    //$page_name = $this->real_escape_string ( $page_name );
			    //$token = $this->real_escape_string ( $token );
			    //$created_time = $this->real_escape_string ( $created_time );
			    $insert = "($group_id,'$page_id','$page_name','$token',$created_time,1,'$current_time','$current_time',$current_timestamp)";
			    //$query = "INSERT INTO fb_pages(group_id,page_id,page_name,token,user_created,status,created,modified,last_conversation_time) VALUES $insert ON DUPLICATE KEY UPDATE modified='$current_time',token='$token'";
			    $query = "INSERT INTO fb_pages(group_id,page_id,page_name,token,user_created,status,created,modified,last_conversation_time) VALUES $insert";
			    
			}
			LoggerConfiguration::logInfo($query);
			$this->query ( $query );
			
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $this->insert_id ();
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function storeFBUserGroup($group_id, $fb_user_id, $token) {
		$current_time = date ( 'Y-m-d H:i:s' );
		try {
			$group_id = $this->real_escape_string ( $group_id );
			$fb_user_id = $this->real_escape_string ( $fb_user_id );
			$token = $this->real_escape_string ( $token );
			$query = "UPDATE groups SET fb_user_id='$fb_user_id',fb_user_token='$token',modified='$current_time' WHERE id=$group_id";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return true;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}

	public function createOrder($group_id, $fb_page_id, $fb_post_id, $fb_comment_id, $phone, $product_id, $bundle_id,
                                $fb_name, $order_code, $fb_customer_id, $status_id, $price, $is_duplicate, $duplicate_note, $telco) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$bundle_id = $bundle_id?$bundle_id:0;
			$product_id = $product_id?$product_id:0;
			$fb_name = $this->real_escape_string($fb_name);
			$values = "$group_id,$fb_customer_id,$fb_page_id,$fb_post_id,$fb_comment_id,'$order_code',
			'$fb_name','$phone','$telco',$bundle_id,$status_id,$price,$price,$is_duplicate,'$duplicate_note','$current_time','$current_time'";
			$query = "INSERT INTO `orders`(`group_id`,`fb_customer_id`,`fb_page_id`,`fb_post_id`,`fb_comment_id`,`code`,
                      `customer_name`,`mobile`,`telco_code`,`bundle_id`,`status_id`,`price`,`total_price`,
                      `duplicate_id`,`duplicate_note`,`created`,`modified`) VALUES ($values)";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $this->insert_id ();
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}

	//create order v2
    public function createOrderV2($group_id, $fb_page_id, $fb_post_id, $fb_comment_id, $phone, $product_id, $bundle_id,
                                  $fb_name, $order_code, $fb_customer_id, $status_id, $price, $is_duplicate, $duplicate_note, $telco)
    {
        $current_time = date ( 'Y-m-d H:i:s' );

        $order = new Order();
        $order->group_id = $group_id;
        $order->fb_customer_id = $fb_customer_id;
        $order->fb_page_id = $fb_page_id;
        $order->fb_post_id = $fb_post_id;
        $order->fb_comment_id = $fb_comment_id;
        $order->code = $order_code;
        $order->customer_name = $fb_name;
        $order->mobile = $phone;
        $order->telco_code = $telco;
        $order->bundle_id = $bundle_id;
        $order->status_id = $status_id;
        $order->price = $price;
        $order->total_price = $price;
        $order->duplicate_id = $is_duplicate;
        $order->duplicate_note = $duplicate_note;
        $order->created = $current_time;
        $order->modified = $current_time;

        $order->save();

        //return $order->id;

        try {
            $order->save();
            return $order->id;
        } catch (Exception $e) {
            return false;
        }

    }


	public function createOrderProduct($order_id, $product_id, $price, $qty) {
		try {
			$current_date = date ( 'Y-m-d H:i:s' );
			$values = "($order_id,'$product_id',$price,$qty,'$current_date','$current_date')";
			$query = "INSERT INTO `orders_products`(order_id,product_id,product_price,qty,created,modified) VALUES $values ON DUPLICATE KEY UPDATE modified=VALUES(modified)";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $this->insert_id();
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function createCustomer($group_id, $fb_user_id, $fb_name, $phone) {
		try {
			$fb_name = $this->real_escape_string($fb_name);
			$current_date = date ( 'Y-m-d H:i:s' );
			$values = "($group_id,'$fb_user_id','$fb_name','$phone','$current_date','$current_date')";
			$query = "INSERT INTO `fb_customers`(group_id,fb_id,fb_name,phone,created,modified) VALUES $values ON DUPLICATE KEY UPDATE fb_name=VALUES(fb_name),modified=VALUES(modified)";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $this->insert_id ();
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function getCustomer($by) {
		try {
		    if (isset($by['fb_customer_id'])){
		        // lay theo id
		        $filter = "id={$by['fb_customer_id']}";
		    }
		    else {
		        if (isset($by['fb_user_id'])){
		            // lay theo fb
		            $filter = "fb_id={$by['fb_user_id']}";
		        }
		        elseif (isset($by['phone'])){
		            // lay theo sdt
		            $filter = "phone={$by['phone']}";
		        }
		        else {
		            return null;
		        }
		        $filter .= " AND group_id={$by['group_id']}";
		    }
			$query = "SELECT id FROM `fb_customers` WHERE $filter LIMIT 1";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			$customer_id = null;
			if ($n = $result->fetch_assoc ()) {
				$customer_id = $n ['id'];
			}
			$this->free_result ( $result );
			return $customer_id;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function createCommentPost($group_id, $page_id,
                                      $fb_page_id, $post_id,
                                      $fb_post_id, $fb_user_id, $comment_id,
                                      $fb_conversation_id, $parent_comment_id, $content,
                                      $fb_customer_id, $comment_time, $reply_type = 0) {
		try {
			$content = $this->real_escape_string ( $content );
			$current_date = date ( 'Y-m-d H:i:s' );
			$comment_time = $comment_time?intval($comment_time):0;
			$values = "($group_id,$fb_customer_id,$fb_page_id,'$page_id',$fb_post_id,'$post_id',
			'$fb_user_id','$comment_id',$fb_conversation_id,'$parent_comment_id','$content',
			'$current_date','$current_date',$comment_time, $reply_type)";
			//$query = "INSERT INTO `fb_post_comments`(group_id,fb_customer_id,fb_page_id,page_id,fb_post_id,post_id,fb_user_id,
            //comment_id,fb_conversation_id,parent_comment_id,content,created,modified,user_created)
            // VALUES $values ON DUPLICATE KEY UPDATE modified='$current_date'";
			$query = "INSERT INTO `fb_post_comments`(
                                              group_id,
                                              fb_customer_id,
                                              fb_page_id,page_id,fb_post_id,post_id,fb_user_id,comment_id,
                                              fb_conversation_id,parent_comment_id,content,created,modified,
                                              user_created,
                                              reply_type
                                              ) VALUES $values";
			LoggerConfiguration::logInfo ( $query );

			$this->query ( $query );

			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;

			}
			return $this->insert_id ();

		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}

    public function createCommentPostV2($group_id, $page_id,
                                        $fb_page_id, $post_id,
                                        $fb_post_id, $fb_user_id, $comment_id,
                                        $fb_conversation_id, $parent_comment_id, $content,
                                        $fb_customer_id, $comment_time, $reply_type = 0)
    {
        $current_date = date ( 'Y-m-d H:i:s' );
        $comment_time = $comment_time?intval($comment_time):0;
        $comment = new PostComment();
        $comment->group_id = $group_id;
        $comment->fb_customer_id = $fb_customer_id;
        $comment->fb_page_id = $fb_page_id;
        $comment->page_id = $page_id;
        $comment->fb_post_id = $fb_post_id;
        $comment->post_id = $post_id;
        $comment->fb_user_id = $fb_user_id;
        $comment->comment_id = $comment_id;
        $comment->fb_conversation_id = $fb_conversation_id;
        $comment->parent_comment_id = $parent_comment_id;
        $comment->content = $content;
        $comment->created = $current_date;
        $comment->modified = $current_date;
        $comment->user_created = $comment_time;
        $comment->reply_type = $reply_type;

        //throw new Exception($reply_type);

        try {
            $comment->save();
            return $comment->id;
        } catch (Exception $e) {
            return false;
        }

    }



	// Don hang duplicate la:
	// 1. cung user (fbid hoac phone)
	// 2. cung group
	// 3. dat mua cung san pham
	// 4. don hang chua hoan thanh???
	public function getOrderDuplicate($fb_user_id, $product_id, $phone, $group_id) {
		try {
		    // B1: lay customer theo fb
		    $fb_customer_id = $this->getCustomer(array('fb_user_id'=>$fb_user_id,'group_id'=>$group_id));
		    $status_filter = ORDER_STATUS_SUCCESS . ',' . ORDER_STATUS_CANCELED;
			$query = "SELECT o.id,o.code,o.fb_customer_id,o.mobile,o.created 
                      FROM `orders` o
			          INNER JOIN `orders_products` op ON o.id=op.order_id
			          WHERE op.product_id='$product_id' AND (o.fb_customer_id=$fb_customer_id OR o.mobile='$phone') AND o.status_id NOT IN ($status_filter)";

			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			$duplicate = '';
			while ($n = $result->fetch_assoc ()) {
			    if ($fb_customer_id==$n['fb_customer_id']) {
			        // trung tkfb
			        $duplicate['fb'][] = "{$n['code']}({$n['created']})";
			    }
			    else {
			        // trung sdt
			        $duplicate['phone'][] = "{$n['code']}({$n['created']})";
			    }
			}
			$this->free_result ( $result );
			return $duplicate?json_encode($duplicate):'';
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function saveConversationInbox($group_id, $page_id, $fb_page_id, $fb_user_id, $fb_user_name, $thread_id, $time, $fb_customer_id, $msg_content) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$msg_content = $this->real_escape_string($msg_content);
			$fb_user_name = $this->real_escape_string($fb_user_name);
			$insert = "($group_id,$fb_customer_id,$fb_page_id,'$page_id','$fb_user_id','$thread_id','', $time ,'$current_time','$current_time','$msg_content','$fb_user_name',0)";
			$query = "INSERT INTO `fb_conversation`(group_id,fb_customer_id,fb_page_id,page_id,fb_user_id,conversation_id,link,last_conversation_time,created,modified,first_content,fb_user_name,is_read) VALUES $insert";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );

			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $this->insert_id ();
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function saveConversationComment($group_id,$fb_customer_id,$fb_page_id,$page_id,$fb_user_id,$comment_id,
                                            $comment_time, &$comment, $fb_name, $post_id, $fb_post_id) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$comment = $this->real_escape_string($comment);
			$fb_name = $this->real_escape_string($fb_name);
			$insert = "(1,$group_id,$fb_customer_id,$fb_page_id,'{$page_id}','$post_id',$fb_post_id,'{$fb_user_id}',
			'{$comment_id}',$comment_time,'$current_time','$current_time','$comment','$fb_name',0)";
			$query = "INSERT INTO `fb_conversation`(type , group_id,
                            fb_customer_id,fb_page_id,page_id,post_id,fb_post_id,fb_user_id,
                            comment_id,last_conversation_time,created,modified,first_content,
                            fb_user_name,is_read) VALUES $insert ON DUPLICATE KEY UPDATE 
                            last_conversation_time=$comment_time,modified='$current_time'";
			LoggerConfiguration::logInfo ( $query );

			$result = $this->query ( $query );

			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $this->insert_id ();
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}

    public function saveConversationCommentV2($group_id,$fb_customer_id,$fb_page_id,$page_id,$fb_user_id,$comment_id,
                                            $comment_time, $comment, $fb_name, $post_id, $fb_post_id) {

        $current_time = date ( 'Y-m-d H:i:s' );
        $comment = $this->real_escape_string($comment);
        $fb_name = $this->real_escape_string($fb_name);

        try {
            $conversation = new Conversation();

            $conversation->type = 1;
            $conversation->group_id = $group_id;
            $conversation->fb_customer_id = $fb_customer_id;
            $conversation->fb_page_id = $fb_page_id;
            $conversation->page_id = $page_id;
            $conversation->post_id = $post_id;
            $conversation->fb_post_id = $fb_post_id;
            $conversation->fb_user_id = $fb_user_id;
            $conversation->comment_id = $comment_id;
            $conversation->last_conversation_time = $comment_time;
            $conversation->created = $current_time;
            $conversation->modified = $current_time;
            $conversation->first_content = $comment;
            $conversation->fb_user_name = $fb_name;
            $conversation->is_read = 0;
            $conversation->save();

            return $conversation->id;

        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateConversationComment($fb_conversation_id, $last_content, $comment_time, $fb_customer_id)
    {
	    try {
	        $current_time = date ( 'Y-m-d H:i:s' );
	        $last_content = $this->real_escape_string($last_content);
            $current_unix_time = time();

            $has_order = 0;
            if (is_numeric($fb_customer_id) && $fb_customer_id > 0) {
                $has_order = 1;
            }

            $conversation = Conversation::find($fb_conversation_id);
            $conversation->last_conversation_time = $current_unix_time;
            $conversation->modified = $current_time;
            $conversation->first_content = $last_content;
            $conversation->is_read = 0;
            $conversation->has_order = $has_order;
            $conversation->fb_customer_id = $fb_customer_id;

            $conversation->save();

	        return true;
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
	        return false;
	    }
	}
	public function saveConversationMessage($group_id, $fb_conversation_id, &$messages, $fb_page_id, $fb_customer_id = 0) {
		try {

			$current_time = date ( 'Y-m-d H:i:s' );
			$insert = null;
			foreach ( $messages as $msg ) {
				$content = $this->real_escape_string ( $msg ['message'] );
				$user_created_time = is_int ( $msg ['created_time'] ) ? $msg ['created_time'] : strtotime ( $msg ['created_time'] );
				$fb_user_id = $msg ['from'] ['id'];
				$insert [] = "($group_id,$fb_customer_id,'$fb_user_id',$fb_page_id,$fb_conversation_id,'{$msg['id']}','{$content}',$user_created_time,'$current_time','$current_time')";
			}
			if (! $insert)
				return null;
			$insert = implode ( ',', $insert );
			$query = "INSERT INTO `fb_conversation_messages`(group_id,fb_customer_id,fb_user_id,fb_page_id,fb_conversation_id,message_id,content,user_created,created,modified) VALUES $insert ON DUPLICATE KEY UPDATE fb_user_id=VALUES(fb_user_id),user_created=VALUES(user_created),modified='$current_time'";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}

            //createLog(__CLASS__ . "-".__FUNCTION__."-".__LINE__);
            //createLog($insert);
            //createLog($query);

			return true;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}

	public function createConversationMessageOld($group_id, $fb_conversation_id, $message, $fb_user_id, $message_id, $message_time, $fb_page_id,
                                              $fb_customer_id = 0, $is_update_conversation=false, $reply_type = 0) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$message = $this->real_escape_string($message);
			$insert = "($group_id,$fb_customer_id,'{$fb_user_id}',$fb_page_id,$fb_conversation_id,'$message_id','{$message}',$message_time,'$current_time','$current_time')";
			$query = "INSERT INTO `fb_conversation_messages`(group_id,fb_customer_id,fb_user_id,fb_page_id,fb_conversation_id,message_id,content,user_created,created,modified) VALUES $insert
			ON DUPLICATE KEY UPDATE modified='$current_time'";

			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}

			//create Conversation
			$conversation = new InboxMessage();
            $conversation->group_id = $group_id;
            $conversation->fb_customer_id = $fb_customer_id;
            $conversation->fb_user_id = $fb_user_id;
            $conversation->fb_page_id = $fb_page_id;
            $conversation->fb_conversation_id = $fb_conversation_id;
            $conversation->message_id = $message_id;
            $conversation->content = $message;
            $conversation->user_created = $fb_customer_id;
            $conversation->created = $message_time;
            $conversation->modified = $current_time;
            $conversation->reply_type = $reply_type;

            $conversation->save();

			//$fb_conversation_messages_id = $this->insert_id();
			$fb_conversation_messages_id = $this->insert_id();
			if($is_update_conversation){
			    $this->updateConversationComment($fb_conversation_id, $message, $message_time);
			}


			return $fb_conversation_messages_id;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}

    public function createConversationMessage($group_id, $fb_conversation_id, $message, $fb_user_id, $message_id,
                                              $message_time, $fb_page_id,
                                                 $fb_customer_id = 0, $is_update_conversation=false, $reply_type = 0) {
        try {
            $current_time = date ( 'Y-m-d H:i:s' );
            $message = $this->real_escape_string($message);

            //create Conversation
            $conversation = new InboxMessage();
            $conversation->group_id = $group_id;
            $conversation->fb_customer_id = $fb_customer_id;
            $conversation->fb_user_id = $fb_user_id;
            $conversation->fb_page_id = $fb_page_id;
            $conversation->fb_conversation_id = $fb_conversation_id;
            $conversation->message_id = $message_id;
            $conversation->content = $message;
            $conversation->user_created = $message_time;
            $conversation->created = $current_time;
            $conversation->modified = $current_time;
            $conversation->reply_type = $reply_type;

            $conversation->save();

            $fb_conversation_messages_id = $conversation->id;
            if($is_update_conversation){
                $this->updateConversationComment($fb_conversation_id, $message, $message_time);
            }

            return $fb_conversation_messages_id;
        } catch ( Exception $e ) {
            LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
            return false;
        }
    }


	public function loadConversation($fb_conversation_id, $conversation_id = '', $comment_id='') {
		try {
		    $filter = '';
		    if ($fb_conversation_id){
		        $filter = "fc.id=$fb_conversation_id";
		    }
		    elseif ($conversation_id){
		        $filter = "fc.conversation_id='$conversation_id'";
		    }elseif ($comment_id){
		        $filter = "fc.comment_id='$comment_id'";
		    }
		    if (!$filter){
		        return null;
		    }
			$query = "SELECT fc.*,fp.token from fb_conversation fc INNER JOIN fb_pages fp ON fc.page_id=fp.page_id WHERE fp.status=0 AND $filter LIMIT 1";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			if ($conversation = $result->fetch_assoc ()) {
				$this->free_result ( $result );
				return $conversation;
			}
			$this->free_result ( $result );
			return null;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function getComment($fb_comment_id, $comment_id = null) {
		try {
			$filter = $fb_comment_id ? "pc.id=$fb_comment_id" : "pc.comment_id='$comment_id'";
			$query = "SELECT pc.id,pc.fb_post_id,pc.post_id,pc.fb_customer_id,pc.comment_id,pc.parent_comment_id,p.page_id,p.token,pc.last_comment_time,p.group_id,p.id AS fb_page_id FROM fb_post_comments pc INNER JOIN fb_pages p ON pc.fb_page_id=p.id WHERE p.status=0 AND pc.status=0 AND $filter LIMIT 1";
			$result = $this->query ( $query );
			if ($result) {
				$page = $result->fetch_assoc ();
				$this->free_result ( $result );
				return $page;
			}
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return null;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function getPageInfo($page_id, $fb_page_id=null) {
		try {
			if ($fb_page_id) {
			    $query = "SELECT * from fb_pages WHERE id=$fb_page_id LIMIT 1";
			}
			else {
			    $query = "SELECT * from fb_pages WHERE page_id='$page_id' LIMIT 1";
			}
			LoggerConfiguration::logInfo ( $query );
			$page = null;
			if ($result = $this->query ( $query )) {
				$page = $result->fetch_assoc ();
				$this->free_result ( $result );
				return $page;
			}
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return null;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	
	public function getPostInfo($post_id) {
	    try {
	        $query = "SELECT p.*,pd.price,pd.bundle_id,fp.token,fp.group_id,pd.code FROM fb_posts p
			INNER JOIN products pd ON p.product_id=pd.id
			INNER JOIN fb_pages fp ON p.fb_page_id=fp.id
			WHERE p.post_id='$post_id'
			AND fp.status=0
			LIMIT 1";
	        LoggerConfiguration::logInfo ( $query );
	        $post = null;
	        if ($result = $this->query ( $query )) {
	            $post = $result->fetch_assoc ();
	            $this->free_result ( $result );
	            return $post;
	        }
	        if ($this->get_error ()) {
	            LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
	            return false;
	        }
	        return null;
	    } catch ( Exception $e ) {
	        LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
	        return false;
	    }
	}

    public function updateConversationLastConversationTime($fb_conversation_id, $last_conversation_time, $last_message) {
        try {
            $last_message = $this->real_escape_string($last_message);
            $query = "UPDATE fb_conversation SET last_conversation_time=$last_conversation_time,first_content='$last_message' WHERE id=$fb_conversation_id";
            LoggerConfiguration::logInfo ( $query );
            $this->query ( $query );
            if ($this->get_error ()) {
                LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
                return false;
            }
            return true;
        } catch ( Exception $e ) {
            LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
            return false;
        }
    }

    public function syncCommentChat($group_id, $fb_page_id, $page_id, $fb_post_id, $post_id, $fb_conversation_id, $parent_comment_id, &$comments) {
        $values = null;
        foreach ( $comments as $comment ) {
            $content = $this->real_escape_string ( $comment ['message'] );
            $current_date = date ( 'Y-m-d H:i:s' );
            $comment_time = strtotime ( $comment ['created_time'] );
            $values [] = "($group_id,0,$fb_page_id,'$page_id',$fb_post_id,'$post_id','{$comment['id']}',$fb_conversation_id,'$parent_comment_id','{$comment['from']['id']}','$content','$current_date','$current_date',$comment_time)";
        }
        if (! $values)
            return null;
        $values = implode ( ',', $values );
        $query = "INSERT INTO `fb_post_comments`(group_id,fb_customer_id,fb_page_id,page_id,fb_post_id,post_id,comment_id,fb_conversation_id,parent_comment_id,fb_user_id,content,created,modified,user_created) VALUES $values ON DUPLICATE KEY UPDATE fb_user_id=VALUES(fb_user_id),user_created=VALUES(user_created),modified='$current_date'";
        LoggerConfiguration::logInfo ( $query );
        $this->query ( $query );
        if ($this->get_error ()) {
            LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
            return false;
        }
        return true;
    }


    public function countRepliedComment($fb_conversation_id, $page_id, $reply_type)
    {
        //$reply_type = 1: da tra loi co sdt, =
        //$reply_type = 0: da tra loi KO co sdt, =

        $conditions = array('conditions' => array(
            'fb_user_id' => $page_id,
            'fb_conversation_id' => $fb_conversation_id,
            'reply_type' => $reply_type
        ));
        $count = PostComment::count($conditions);

        return $count;
    }

    public function countRepliedInbox($fb_conversation_id, $page_id, $reply_type)
    {
        //$reply_type = 1: da tra loi co sdt, =
        //$reply_type = 0: da tra loi KO co sdt, =

        $conditions = array('conditions' => array(
            'fb_user_id' => $page_id,
            'fb_conversation_id' => $fb_conversation_id,
            'reply_type' => $reply_type
        ));
        $count = InboxMessage::count($conditions);

        return $count;
    }

    public function countParentPostComment($fb_user_id, $page_id, $post_id, $reply_type)
    {
        $option = array(
            'conditions' => array(
                'id IN (SELECT fb_conversation_id FROM fb_post_comments WHERE  fb_user_id = ? AND page_id = ? AND post_id = ? AND reply_type = ?)',
                $fb_user_id,
                $page_id,
                $post_id,
                $reply_type,

            )
        );
        $count = Conversation::count($option);

        return $count;
    }

}