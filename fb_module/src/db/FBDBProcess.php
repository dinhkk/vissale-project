<?php
require_once dirname ( __FILE__ ) . '/DBProcess.php';
class FBDBProcess extends DBProcess {
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
	public function loadPost($limit) {
		try {
			$current_time = time ();
			$filter = "p.next_time_fetch_comment IS NULL OR p.next_time_fetch_comment<=$current_time";
			$query = "SELECT p.*,fp.token FROM fb_posts p INNER JOIN fb_pages fp ON p.page_id=fp.page_id  WHERE $filter AND fp.status=0 AND p.status=0 LIMIT $limit";
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
}