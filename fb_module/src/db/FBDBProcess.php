<?php
require_once dirname ( __FILE__ ) . '/DBProcess.php';
class FBDBProcess extends DBProcess {
	public function dropPages($group_id) {
		try {
			$group_id = $this->real_escape_string ( $group_id );
			$query = "DELETE fb_pages WHERE group_id=$group_id";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->error) {
				LoggerConfiguration::logError ( $this->error, __CLASS__, __FUNCTION_, __LINE__ );
				return false;
			}
			return true;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION_, __LINE__ );
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
	 */
	public function storePages($group_id, $page_id, $page_name, $token, $created_time) {
		$current_time = date ( 'd-m-Y H:i:s' );
		$group_id = $this->real_escape_string ( $group_id );
		$page_id = $this->real_escape_string ( $page_id );
		$page_name = $this->real_escape_string ( $page_name );
		$token = $this->real_escape_string ( $token );
		$created_time = $this->real_escape_string ( $created_time );
		$insert = "($group_id,'$page_id','$page_name','$token',$created_time,0,'$current_time','$current_time')";
		try {
			$query = "INSERT INTO fb_pages(group_id,page_id,page_name,token,user_created,created,modified) VALUES $insert";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->error) {
				LoggerConfiguration::logError ( $this->error, __CLASS__, __FUNCTION_, __LINE__ );
				return false;
			}
			return $this->insert_id ();
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION_, __LINE__ );
			return false;
		}
	}
	public function storeFBUserGroup($group_id, $fb_user_id, $token) {
		$current_time = date ( 'd-m-Y H:i:s' );
		try {
			$group_id = $this->real_escape_string ( $group_id );
			$fb_user_id = $this->real_escape_string ( $fb_user_id );
			$token = $this->real_escape_string ( $token );
			$query = "UPDATE groups SET fb_user_id='$fb_user_id',fb_user_token='$token',modified='$current_time' WHERE id=$group_id";
			LoggerConfiguration::logInfo ( $query );
			$this->query ( $query );
			if ($this->error) {
				LoggerConfiguration::logError ( $this->error, __CLASS__, __FUNCTION_, __LINE__ );
				return false;
			}
			return true;
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION_, __LINE__ );
			return false;
		}
	}
}