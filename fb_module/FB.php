<?php
require_once dirname ( __FILE__ ) . '/src/db/FBDBProcess.php';
require_once dirname ( __FILE__ ) . '/src/core/Fanpage.core.php';
class FB {
	private $db = null;
	public function __construct() {
		$this->db = new FBDBProcess ();
	}
	public function fetchOrder($group_id = null) {
		// B1. Lay thoi diem thuc hien lan truoc
		$fp = new Fanpage ();
		LoggerConfiguration::logInfo ( '--- START ---' );
		$config = $this->_loadConfig ( $group_id );
		if (! $config) {
			return;
		}
		LoggerConfiguration::logInfo ( 'Config Data: ' . print_r ( $config, true ) );
		$current_time = time ();
		$current_day = date ( 'Ymd', $current_time );
		while ( true ) {
			LoggerConfiguration::init ( 'STEP 1: LOAD POST' );
			$posts = $this->db->loadPost ( $group_id, $config ['load_post_limit'] );
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
				$page_id = $post ['page_id'];
				$from_time = $post ['last_time_fetch_comment'];
				$last_day = $from_time ? date ( 'Ymd', $from_time ) : null;
				// lay comment cua post (order)
				$is_nocomment = false;
				if (empty ( $post ['next_time_fetch_comment'] ))
					$post ['next_time_fetch_comment'] = $current_time;
				if (empty ( $post ['last_time_fetch_comment'] ))
					$post ['last_time_fetch_comment'] = $current_time;
				LoggerConfiguration::logInfo ( 'STEP 3: LOAD COMMENT' );
				$comments = $fp->get_comment_post ( $post_id, $page_id, $fanpage_token_key, $config ['fb_limit_comment_post'], $from_time, $config ['user_coment_filter'] );
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
						if ($this->_includedPhone ( $message )) {
							LoggerConfiguration::logInfo ( 'This comment included phone number' );
							// comment co kem theo sdt
							// 1. tao order
							LoggerConfiguration::logInfo ( 'Create order' );
							// 2. an comment (neu cau hinh cho phep)
							if ($post ['disable_comment']) {
								LoggerConfiguration::logInfo ( 'Hide comment' );
								if (! $fp->hide_comment ( $comment_id, $post_id, $page_id, $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Hide comment error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
							}
							// 2. comment phan hoi
							if (! empty ( $post ['answer_phone'] )) {
								LoggerConfiguration::logInfo ( "Reply this comment, message: {$post ['answer_phone']}" );
								if (! $fp->reply_comment ( $comment_id, $post_id, $page_id, $post ['answer_phone'], $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Reply error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
							}
						} else {
							// tra loi comment
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
					if ($post ['nodata_number_day'] >= $config ['max_nodata_comment_day']) {
						LoggerConfiguration::logInfo ( "nodata_number_day={$post ['nodata_number_day']} >= max_nodata_comment_day={$config ['max_nodata_comment_day']}" );
						if ($current_day > $last_day) {
							// thoi diem thuc hien cronjob la cua ngay hom sau (lan dau)
							LoggerConfiguration::logInfo ( "current_day=$current_day > last_day=$last_day" );
							LoggerConfiguration::logInfo ( 'Reset nodata_number_day' );
							$update_data ['nodata_number_day'] = 0;
							// reset so dem nodata_number_day & gian cach thoi gian lan xu ly sau
							$next_level_fetch_comment = intval ( $post ['level_fetch_comment'] ) + 1;
							$update_data ['level_fetch_comment'] = $next_level_fetch_comment;
							if (isset ( $config ['level_fetch_comment'] [$next_level_fetch_comment] )) {
								// dua vao level de dat thoi gian xu ly tiep theo
								$next_time_fetch_comment = intval ( $post ['next_time_fetch_comment'] ) + $config ['level_fetch_comment'] [$next_level_fetch_comment];
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
					if (isset ( $config ['level_fetch_comment'] [$post ['level_fetch_comment']] )) {
						$update_data ['next_time_fetch_comment'] = intval ( $post ['next_time_fetch_comment'] ) + $config ['level_fetch_comment'] [$post ['level_fetch_comment']];
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
					$update_data ['next_time_fetch_comment'] = intval ( $post ['next_time_fetch_comment'] ) + $config ['level_fetch_comment'] [0];
				}
				// cap nhat du lieu post
				LoggerConfiguration::logInfo ( 'Update for this post' );
				$update_data ['modified'] = date ( 'Y-m-d H:i:s' );
				LoggerConfiguration::logInfo ( print_r ( $update_data, true ) );
				$this->db->updatePost ( $post_id, $update_data );
			}
			if (count ( $posts ) < $config ['load_post_limit']) {
				LoggerConfiguration::logInfo ( 'Over post data' );
				break;
			}
			LoggerConfiguration::logInfo ( 'STEP 2.2: END PROCESS POST' );
		}
		LoggerConfiguration::logInfo ( '--- END ---' );
	}
	private function _includedPhone(&$str) {
		if (preg_match ( '/[0-9]{10,12}/', $str )) {
			return true;
		}
		return false;
	}
	private function _loadConfig($group_id = null) {
		// return array (
		// 'load_post_limit' => LOAD_POST_LIMIT,
		// 'fb_limit_comment_post' => FB_LIMIT_COMMENT_POST,
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
		$data = null;
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
					$val = json_encode ( $config ['value'], true );
					break;
				case 2 :
					// array: 1,2,3,45466,fdfs
					$val = explode ( ',', $config ['value'] );
					break;
				
				default :
					;
					break;
			}
			if ($val)
				$data [$config ['_key']] = $val;
		}
		return $data;
	}
}