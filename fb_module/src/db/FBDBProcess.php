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
	public function loadConfigByPage($fb_page_id) {
		try {
			$query = "SELECT c._key,c.value,c.type,c.group_id FROM fb_cron_config c 
			INNER JOIN fb_pages p ON p.group_id=c.group_id
			WHERE p.id=$fb_page_id";
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
	public function loadPages($group_id, $limit) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$filter = $group_id ? "AND p.group_id=$group_id" : '';
			$query = "SELECT p.id from fb_pages p 
			INNER JOIN groups g ON p.group_id=g.id
			WHERE p.status=0 AND g.status=0 $filter ORDER BY p.modified DESC LIMIT $limit FOR UPDATE";
			LoggerConfiguration::logInfo ( $query );
			$this->set_auto_commit ( false );
			if ($result = $this->query ( $query )) {
				$fb_page_ids = null;
				while ( $n = $result->fetch_assoc () ) {
					$fb_page_ids [] = $n ['id'];
				}
				$this->free_result ( $result );
				if ($fb_page_ids) {
					$fb_page_ids = implode ( ',', $fb_page_ids );
					$query = "UPDATE fb_pages SET modified='$current_time' WHERE id IN ($fb_page_ids)";
					LoggerConfiguration::logInfo ( $query );
					$this->query ( $query );
				}
			} else if ($this->get_error ()) {
				$this->set_auto_commit ( true );
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			$query = "SELECT p.id from fb_pages p 
			INNER JOIN groups g ON p.group_id=g.id
			WHERE p.status=0 AND g.status=0 $filter ORDER BY p.modified DESC LIMIT $limit";
			$result = $this->query ( $query );
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				$this->set_auto_commit ( true );
				return false;
			}
			$pages = null;
			while ( $n = $result->fetch_assoc () ) {
				$pages [] = $n ['id'];
			}
			$this->free_result ( $result );
			$this->set_auto_commit ( true );
			return $pages;
		} catch ( Exception $e ) {
			$this->set_auto_commit ( true );
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
		//$page_id = $this->real_escape_string ( $page_id );
		// kiem tra ton tai
		try {
			$query = "SELECT id FROM fb_pages WHERE page_id='$page_id' AND group_id<>$group_id LIMIT 1";
			$result = $this->query ( $query );
			if ($this->affected_rows () === 1) {
				$this->free_result ( $result );
				// da ton tai tren group khac
				LoggerConfiguration::logError ( "Page_id=$page_id is unavaiable", __CLASS__, __FUNCTION__, __LINE__ );
				return false;
			}
			$current_time = date ( 'Y-m-d H:i:s' );
			$current_timestamp = time();
			//$group_id = $this->real_escape_string ( $group_id );
			//$page_name = $this->real_escape_string ( $page_name );
			//$token = $this->real_escape_string ( $token );
			//$created_time = $this->real_escape_string ( $created_time );
			$insert = "($group_id,'$page_id','$page_name','$token',$created_time,1,'$current_time','$current_time')";
			$query = "INSERT INTO fb_pages(group_id,page_id,page_name,token,user_created,status,created,modified) VALUES $insert ON DUPLICATE KEY UPDATE modified='$current_time',token='$token'";
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
	public function loadPost($fb_page_id, $limit, $worker, $hostname, &$first = false) {
		try {
			$current_time = time ();
			// lan dau thi moi thuc hien, neu lan 2 thi => B2 de lay post ra xu ly
			if ($first) {
				$first = false;
				$modified = date ( 'Y-m-d H:i:s', $current_time );
				// LOCK B1: Worker se nhan se xu ly nhung post nao cua page
				// - Da den thoi diem phai xu ly p.next_time_fetch_comment IS NULL OR p.next_time_fetch_comment<=$current_time
				// - se duoc gan voi worker nay; de cac worker khac biet la post nay dang duoc xu ly roi => bo qua
				// UPDATE fb_posts SET worker='$worker' AND hostname='$hostname'
				// ??? Luu y: co the con co nhung post ma worker nhan xu ly o lan truoc, nhung loi khi dang thuc hine
				// va khong kip UNLOCK
				// bao gom ca nhung post da duoc gan cho 1 worker khac nhung da qua lau khong duoc xu ly
				// boi vi co the worker do bi die => dan den post do khong bao gio duoc xu ly ??? => congmt: tam thoi chua xu ly TH nay
				$query = "SELECT p.id FROM fb_posts p
				INNER JOIN fb_pages fp ON p.page_id=fp.page_id
				INNER JOIN groups gr ON gr.id=p.group_id
				INNER JOIN products pd ON p.product_id=pd.id
				WHERE gr.status=0 AND fp.status=0 AND p.status=0 AND (p.next_time_fetch_comment IS NULL OR p.next_time_fetch_comment<=$current_time) AND fp.id=$fb_page_id
				LIMIT $limit FOR UPDATE";
				LoggerConfiguration::logInfo ( $query );
				$this->set_auto_commit ( false );
				if ($result = $this->query ( $query )) {
					$fb_post_ids = null;
					while ( $n = $result->fetch_assoc () ) {
						$fb_post_ids [] = $n ['id'];
					}
					$this->free_result ( $result );
					if ($fb_post_ids) {
						$fb_post_ids = implode ( ',', $fb_post_ids );
						$query = "UPDATE fb_posts SET gearman_worker='$worker',gearman_hostname='$hostname',modified='$modified' WHERE id IN ($fb_post_ids)";
						LoggerConfiguration::logInfo ( $query );
						if (! $this->query ( $query )) {
							if ($this->get_error ()) {
								LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
								// return false;
							}
						}
					}
				}
			}
			// LOCK B2: Lay ra nhung post da duoc worker nhan xu ly o B1
			$query = "SELECT p.*,pd.price,pd.bundle_id,fp.token,fp.group_id FROM fb_posts p
			INNER JOIN products pd ON p.product_id=pd.id
			INNER JOIN fb_pages fp ON p.fb_page_id=fp.id
			WHERE gearman_worker='$worker' AND gearman_hostname='$hostname'
			LIMIT $limit";
			LoggerConfiguration::logInfo ( $query );
			$result = $this->query ( $query );
			$data = null;
			if ($result) {
				while ( $n = $result->fetch_assoc () ) {
					$data [] = $n;
				}
				$this->free_result ( $result );
			}
			if ($this->get_error ()) {
				LoggerConfiguration::logError ( $this->get_error (), __CLASS__, __FUNCTION__, __LINE__ );
				$this->set_auto_commit ( true );
				return false;
			}
			$this->set_auto_commit ( true );
			return $data;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			$this->set_auto_commit ( true );
			return false;
		}
	}
	public function updatePost($fb_post_id, $update_data) {
		try {
			$fb_post_id = $this->real_escape_string ( $fb_post_id );
			$update = null;
			foreach ( $update_data as $key => $val ) {
				$update [] = "$key='$val'";
			}
			if (! $update)
				return null;
			$update = implode ( ',', $update );
			$query = "UPDATE fb_posts SET $update WHERE id=$fb_post_id";
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
	public function createOrder($group_id, $fb_page_id, $fb_post_id, $fb_comment_id, $phone, $product_id, $bundle_id, $fb_name, $order_code, $fb_customer_id, $status_id, $price, $is_duplicate, $duplicate_note) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$values = "$group_id,$fb_customer_id,$fb_page_id,$fb_post_id,$fb_comment_id,'$order_code','$fb_name','$phone',$bundle_id,$status_id,$price,$price,$is_duplicate,'$duplicate_note','$current_time','$current_time'";
			$query = "INSERT INTO `orders`(`group_id`,`fb_customer_id`,`fb_page_id`,`fb_post_id`,`fb_comment_id`,`code`,`customer_name`,`mobile`,`bundle_id`,`status_id`,`price`,`total_price`,`duplicate_id`,`duplicate_note`,`created`,`modified`) VALUES ($values)";
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
			$query = "SELECT id FROM `statuses` WHERE group_id=$group_id AND is_default=1 AND is_system=1 LIMIT 1";
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
	public function createCommentPost($group_id, $page_id, $fb_page_id, $post_id, $fb_post_id, $fb_user_id, $comment_id, $fb_conversation_id, $parent_comment_id, $content, $fb_customer_id, $comment_time) {
		try {
			$content = $this->real_escape_string ( $content );
			$current_date = date ( 'Y-m-d H:i:s' );
			$comment_time = $comment_time?intval($comment_time):0;
			$values = "($group_id,$fb_customer_id,$fb_page_id,'$page_id',$fb_post_id,'$post_id','$fb_user_id','$comment_id',$fb_conversation_id,'$parent_comment_id','$content','$current_date','$current_date',$comment_time)";
			$query = "INSERT INTO `fb_post_comments`(group_id,fb_customer_id,fb_page_id,page_id,fb_post_id,post_id,fb_user_id,comment_id,fb_conversation_id,parent_comment_id,content,created,modified,user_created) VALUES $values ON DUPLICATE KEY UPDATE modified='$current_date'";
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
	public function updateLastCommentTime($fb_comment_id, $last_comment_time) {
		try {
			$query = "UPDATE fb_post_comments SET last_comment_time=$last_comment_time WHERE id=$fb_comment_id";
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
			$query = "SELECT o.id,o.code,o.fb_customer_id,o.mobile,o.created FROM `orders` o
			INNER JOIN `orders_products` op ON o.id=op.order_id
			WHERE op.product_id=$product_id AND (o.fb_customer_id=$fb_customer_id OR o.mobile='$phone') AND o.status NOT IN ($status_filter)";
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
			return json_encode($duplicate);
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function saveConversation(&$conversation, &$first_message='Gửi một tin nhắn',$fb_name='Chưa xác định') {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$insert = "({$conversation['group_id']},{$conversation['fb_customer_id']},{$conversation['fb_page_id']},'{$conversation['page_id']}','{$conversation['fb_user_id']}','{$conversation['id']}','{$conversation['link']}',{$conversation['last_conversation_time']},'$current_time','$current_time','$first_message','$fb_name')";
			$query = "INSERT INTO `fb_conversation`(group_id,fb_customer_id,fb_page_id,page_id,fb_user_id,conversation_id,link,last_conversation_time,created,modified,first_content,fb_user_name) VALUES $insert ON DUPLICATE KEY UPDATE last_conversation_time={$conversation['last_conversation_time']},modified='$current_time'";
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
	public function saveConversationComment($group_id,$fb_customer_id,$fb_page_id,$page_id,$fb_user_id,$comment_id,$comment_time, &$comment, $fb_name, $post_id, $fb_post_id) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$insert = "(1,$group_id,$fb_customer_id,$fb_page_id,'{$page_id}','$post_id',$fb_post_id,'{$fb_user_id}','{$comment_id}',$comment_time,'$current_time','$current_time','$comment','$fb_name')";
			$query = "INSERT INTO `fb_conversation`(type,group_id,fb_customer_id,fb_page_id,page_id,post_id,fb_post_id,fb_user_id,comment_id,last_conversation_time,created,modified,first_content,fb_user_name) VALUES $insert ON DUPLICATE KEY UPDATE last_conversation_time=$comment_time,modified='$current_time'";
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
			return true;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function createConversationMessage($group_id, $fb_conversation_id, $message, $fb_user_id, $message_id, $message_time, $fb_page_id, $fb_customer_id = 0) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$insert = "($group_id,$fb_customer_id,'$fb_user_id',$fb_page_id,$fb_conversation_id,'$message_id','{$message}',$message_time,'$current_time','$current_time')";
			$query = "INSERT INTO `fb_conversation_messages`(group_id,fb_customer_id,fb_user_id,fb_page_id,fb_conversation_id,message_id,content,user_created,created,modified) VALUES $insert";
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
	public function loadConversation($fb_conversation_id, $comment_id='') {
		try {
			$filter = $fb_conversation_id?"fc.id=$fb_conversation_id":"fc.comment_id='$comment_id'";
			$query = "SELECT fc.*,fp.token from fb_conversation fc INNER JOIN fb_pages fp ON fc.fb_page_id=fp.id WHERE fc.status=0 AND fp.status=0 AND $filter LIMIT 1";
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
	public function getPage($fb_page_id) {
		try {
			$current_time = date ( 'Y-m-d H:i:s' );
			$query = "SELECT * from fb_pages WHERE status=0 AND id=$fb_page_id LIMIT 1";
			LoggerConfiguration::logInfo ( $query );
			$page = null;
			if ($result = $this->query ( $query )) {
				if ($page = $result->fetch_assoc ()) {
				}
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
	public function __destruct() {
		$this->close ();
	}
}