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
	public function createOrder($group_id, $fb_page_id, $fb_post_id, $fb_chat_id, $phone, $product_id, $bundle_id, $fb_name, $order_code, $fb_customer_id, $status_id, $price, $duplicate_id) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$values = "$group_id,$fb_customer_id,$fb_page_id,$fb_post_id,$fb_chat_id,'$order_code','$fb_name','$phone',$bundle_id,$status_id,$price,$price,$duplicate_id,'$current_time','$current_time'";
			$query = "INSERT INTO `orders`(`group_id`,`fb_customer_id`,`fb_page_id`,`fb_post_id`,`fb_chat_id`,`code`,`customer_name`,`mobile`,`bundle_id`,`status_id`,`price`,`total_price`,`duplicate_id`,`created`,`modified`) VALUES ($values)";
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
			$query = "SELECT id FROM `fb_customers` WHERE fb_id='$fb_user_id' AND phone='$phone' LIMIT 1";
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
	public function createChat($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $comment_id, $parent_comment_id, $content, $fb_customer_id) {
		try {
			$content = $this->real_escape_string ( $content );
			$current_date = date ( 'Y-m-d H:i:s' );
			$values = "(0,$group_id,$fb_customer_id,$fb_page_id,'$page_id',$fb_post_id,'$post_id','$comment_id','$parent_comment_id','$content','$current_date','$current_date')";
			$query = "INSERT INTO `fb_chats`(type,group_id,fb_customer_id,fb_page_id,page_id,fb_post_id,post_id,comment_id,parent_comment_id,content,created,modified) VALUES $values";
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
}