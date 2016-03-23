<?php
require_once dirname ( __FILE__ ) . '/DBProcess.php';
class FBDBProcess extends DBProcess {
	public function loadConfig($group_id = null) {
		try {
			$query = 'SELECT _key,value,type FROM fb_cron_config';
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
	public function loadPages($group_id) {
		try {
			$filter = $group_id ? "AND group_id=$group_id" : '';
			$query = "SELECT * from fb_pages WHERE status=0 $filter";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			$pages = null;
			while ( $n = $result->fetch_assoc () ) {
				$pages [] = $n;
			}
			$this->free_result ( $result );
			return $pages;
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
		$current_time = date ( 'Y-m-d H:i:s' );
		$group_id = $this->real_escape_string ( $group_id );
		$page_id = $this->real_escape_string ( $page_id );
		$page_name = $this->real_escape_string ( $page_name );
		$token = $this->real_escape_string ( $token );
		$created_time = $this->real_escape_string ( $created_time );
		$insert = "($group_id,'$page_id','$page_name','$token',$created_time,0,'$current_time','$current_time')";
		try {
			$query = "INSERT INTO fb_pages(group_id,page_id,page_name,token,user_created,status,created,modified) VALUES $insert";
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
	/**
	 * Logic:
	 * Khi thuc hien lay order ve se cap nhat thoi gian lay (last_time_fetch_order).
	 * Lan sau cronjob chay chi can su ly nhung comment duoc thuc hien sau thoi diem lan truoc
	 * Neu khong lay duoc comment nao, tang so dem so lan khong lay duoc (nodata_number). Neu qua so lan nay thi co the post da qua cu, khong co ai mua
	 * nua => giam so thoi gian (gian cach thoi gian) thuc hien lay => tang toc he thong (next_time_fetch_order)
	 *
	 * @param unknown $group_id        	
	 * @param unknown $limit        	
	 */
	public function loadPost($group_id, $limit) {
		try {
			$current_time = time ();
			$filter = "(p.next_time_fetch_comment IS NULL OR p.next_time_fetch_comment<=$current_time)";
			if ($group_id) {
				$filter .= " AND fp.group_id=$group_id";
			}
			$query = "SELECT p.*,fp.token,pd.price FROM fb_posts p INNER JOIN fb_pages fp ON p.page_id=fp.page_id
			INNER JOIN products pd ON p.product_id=pd.id
			WHERE $filter AND fp.status=0 AND p.status=0 LIMIT $limit";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			$data = null;
			if ($result) {
				if ($n = $result->fetch_assoc ()) {
					$data [] = $n;
				}
				$this->free_result ( $result );
			}
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			return $data;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function updatePost($post_id, $update_data) {
		try {
			$post_id = $this->real_escape_string ( $post_id );
			$update = null;
			foreach ( $update_data as $key => $val ) {
				$update [] = "$key='$val'";
			}
			if (! $update)
				return null;
			$update = implode ( ',', $update );
			$query = "UPDATE fb_posts SET $update";
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
	 * INSERT INTO `orders`(`group_id`,`fb_customer_id`,`fb_page_id`,`fb_post_id`,`fb_chat_id`,`code`,`customer_name`, `mobile`,
	 * `bundle_id`,`status_id`,`price`,`total_price`, `duplicate_id`,`user_created`,`user_modified`,`created`, `modified`)
	 *
	 * @param unknown $order_data        	
	 */
	public function createOrder($group_id, $fb_page_id, $fb_post_id, $fb_comment_id, $phone, $product_id, $bundle_id, $fb_name, $order_code, $fb_customer_id, $status_id, $price, $duplicate_id) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$values = "$group_id,$fb_customer_id,$fb_page_id,$fb_post_id,$fb_comment_id,'$order_code','$fb_name','$phone',$bundle_id,$status_id,$price,$price,$duplicate_id,'$current_time','$current_time'";
			$query = "INSERT INTO `orders`(`group_id`,`fb_customer_id`,`fb_page_id`,`fb_post_id`,`fb_comment_id`,`code`,`customer_name`,`mobile`,`bundle_id`,`status_id`,`price`,`total_price`,`duplicate_id`,`created`,`modified`) VALUES ($values)";
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
	public function createOrderProduct($order_id, $product_id, $price, $qty) {
		try {
			$current_date = date ( 'Y-m-d H:i:s' );
			$values = "($order_id,$product_id,$price,$qty,'$current_date','$current_date')";
			$query = "INSERT INTO `orders_products`(order_id,product_id,product_price,qty,created,modified) VALUES $values ON DUPLICATE KEY UPDATE modified=VALUES(modified)";
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
	public function getDefaultStatusID($group_id) {
		try {
			$query = "SELECT id FROM `statuses` WHERE group_id=$group_id AND is_default=1 LIMIT 1";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			$status_id = null;
			if ($n = $result->fetch_assoc ()) {
				$status_id = $n ['id'];
			}
			$this->free_result ( $result );
			return $status_id;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function createCustomer($group_id, $fb_user_id, $fb_name, $phone) {
		try {
			$current_date = date ( 'Y-m-d H:i:s' );
			$values = "($group_id,'$fb_user_id','$fb_name','$phone','$current_date','$current_date')";
			$query = "INSERT INTO `fb_customers`(group_id,fb_id,fb_name,phone,created,modified) VALUES $values ON DUPLICATE KEY UPDATE fb_name=VALUES(fb_name),modified=VALUES(modified)";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			if ($customer_id = $this->insert_id ()) {
				return $customer_id;
			}
			return $this->getCustomer ( $fb_user_id, $phone );
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function getCustomer($fb_user_id, $phone) {
		try {
			$filter = "fb_id='$fb_user_id'" . ($phone ? " OR phone='$phone'" : '');
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
	public function createCommentPost($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $comment_id, $parent_comment_id, $content, $fb_customer_id) {
		try {
			$content = $this->real_escape_string ( $content );
			$current_date = date ( 'Y-m-d H:i:s' );
			$values = "($group_id,$fb_customer_id,$fb_page_id,'$page_id',$fb_post_id,'$post_id','$comment_id','$parent_comment_id','$content','$current_date','$current_date')";
			$query = "INSERT INTO `fb_post_comments`(group_id,fb_customer_id,fb_page_id,page_id,fb_post_id,post_id,comment_id,parent_comment_id,content,created,modified) VALUES $values";
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
	// Don hang duplicate la:
	// 1. cung user (fbid hoac phone)
	// 2. cung group
	// 3. dat mua cung san pham
	// 4. don hang chua hoan thanh???
	public function getOrderDuplicate($fb_customer_id, $product_id) {
		try {
			$query = "SELECT o.id FROM `orders` o
			INNER JOIN `orders_products` op ON o.id=op.order_id
			WHERE o.fb_customer_id=$fb_customer_id AND op.product_id=$product_id ORDER BY o.id DESC LIMIT 1";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			$duplicate_id = null;
			if ($n = $result->fetch_assoc ()) {
				$duplicate_id = $n ['id'];
			}
			$this->free_result ( $result );
			return $duplicate_id;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function saveConversation(&$conversation) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$insert = "({$conversation['group_id']},{$conversation['fb_customer_id']},{$conversation['fb_page_id']},'{$conversation['page_id']}','{$conversation['fb_user_id']}','{$conversation['id']}','{$conversation['link']}',{$conversation['last_conversation_time']},'$current_time','$current_time')";
			$query = "INSERT INTO `fb_conversation`(group_id,fb_customer_id,fb_page_id,page_id,fb_user_id,conversation_id,link,last_conversation_time,created,modified) VALUES $insert ON DUPLICATE KEY UPDATE last_conversation_time={$conversation['last_conversation_time']},modified='$current_time'";
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
	public function saveConversationMessage($group_id, $fb_conversation_id, &$messages, $fb_page_id, $fb_customer_id = 0) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$insert = null;
			foreach ( $messages as $msg ) {
				$content = $this->real_escape_string ( $msg ['message'] );
				$user_created_time = is_int ( $msg ['created_time'] ) ? $msg ['created_time'] : strtotime ( $msg ['created_time'] );
				$fb_user_id = $msg['from']['id'];
				$insert [] = "($group_id,$fb_customer_id,'$fb_user_id',$fb_page_id,$fb_conversation_id,'{$msg['id']}','{$content}',$user_created_time,'$current_time','$current_time')";
			}
			if (! $insert)
				return null;
			$insert = implode ( ',', $insert );
			$query = "INSERT INTO `fb_conversation_messages`(group_id,fb_customer_id,fb_user_id,fb_page_id,fb_conversation_id,message_id,content,user_created,created,modified) VALUES $insert ON DUPLICATE KEY UPDATE modified=VALUES(modified)";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
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
	public function updatePageLastConversationTime($fb_page_id, $last_conversation_time) {
		try {
			$query = "UPDATE fb_pages SET last_conversation_time=$last_conversation_time WHERE id=$fb_page_id";
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
	public function updateConversationLastConversationTime($fb_conversation_id, $last_conversation_time) {
		try {
			$query = "UPDATE fb_conversation SET last_conversation_time=$last_conversation_time WHERE id=$fb_conversation_id";
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
	public function loadConversation($group_id, $fb_page_id, $fb_conversation_id) {
		try {
			$filter = '';
			$limit = '';
			if ($group_id)
				$filter .= " AND fc.group_id=$group_id";
			if ($fb_page_id)
				$filter .= " AND fc.fb_page_id=$fb_page_id";
			if ($fb_conversation_id) {
				$limit = 'LIMIT 1';
				$filter .= " AND fc.id=$fb_conversation_id";
			}
			$query = "SELECT fc.*,fp.token from fb_conversation fc INNER JOIN fb_pages fp ON fc.fb_page_id=fp.id WHERE fc.status=0 AND fp.status=0 $filter ORDER BY fc.last_conversation_time DESC $limit";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			$conversations = null;
			while ( $n = $result->fetch_assoc () ) {
				$conversations [] = $n;
			}
			$this->free_result ( $result );
			return $conversations;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
}