<?php
require_once dirname ( __FILE__ ) . '/src/db/FBDBProcess.php';
require_once dirname ( __FILE__ ) . '/src/core/Fanpage.core.php';
class FB {
	public function fetchOrder() {
		// B1. Lay thoi diem thuc hien lan truoc
		$db = new FBDBProcess ();
		$fp = new Fanpage ();
		LoggerConfiguration::logInfo ( '--- START ---' );
		$config = $this->_loadConfig ();
		$current_time = time ();
		$current_day = date ( 'Ymd', $current_time );
		while ( true ) {
			LoggerConfiguration::init ( 'STEP 1: LOAD POST' );
			$posts = $db->loadPost ( $config ['load_post_limit'] );
			if (! $posts) {
				LoggerConfiguration::logInfo ( 'Not found post' );
				break;
			}
			LoggerConfiguration::logInfo ( 'STEP 2: PROCESS POST' );
			foreach ( $posts as $post ) {
				// xy lu tung post
				LoggerConfiguration::logInfo ( "PostID: {$post['post_id']}, PageID: {$post['page_id']}, GroupID: {$post['group_id']}" );
				$fanpage_token_key = $post ['token'];
				$post_id = $post ['post_id'];
				$page_id = $post ['page_id'];
				$from_time = $post ['last_time_fetch_comment'];
				$last_day = $from_time ? date ( 'Ymd', $from_time ) : null;
				// lay comment cua post (order)
				$is_nocomment = false;
				while ( true ) {
					LoggerConfiguration::logInfo ( 'STEP 3: LOAD COMMENT' );
					$comments = $fp->get_comment_post ( $post_id, $page_id, $fanpage_token_key, $config ['fb_limit_comment_post'], $from_time );
					if (! $comments) {
						$is_nocomment = true; // khong co comment nao
						if ($fp->error) {
							LoggerConfiguration::logError ( $fp->error, __CLASS__, __FUNCTION__, __LINE__ );
						}
						LoggerConfiguration::logInfo ( 'No comment' );
						break;
					}
					foreach ( $comments as $comment ) {
						LoggerConfiguration::logInfo ( 'STEP 4: PROCESS COMMENT' );
						LoggerConfiguration::logInfo ( 'Comment data: ' . print_r ( $comment, true ) );
						$message = $comment ['message'];
						$comment_id = $comment ['id'];
						if ($this->_includedPhone ( $message )) {
							LoggerConfiguration::logInfo ( 'This comment included phone number' );
							// comment co kem theo sdt
							// 1. tao order
							LoggerConfiguration::logInfo ( 'Create order' );
							// 2. an comment (neu cau hinh cho phep)
							if ($config ['disable_comment']) {
								LoggerConfiguration::logInfo ( 'Hide comment' );
								if (! $fp->hide_comment ( $comment_id, $post_id, $page_id, $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Hide comment error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
							}
						} else {
							// tra loi comment
							if (! empty ( $config ['answer_nophone'] )) {
								LoggerConfiguration::logInfo ( "Reply this comment, message: {$config ['answer_nophone']}" );
								if (! $fp->reply_comment ( $comment_id, $post_id, $page_id, $config ['answer_nophone'], $fanpage_token_key )) {
									LoggerConfiguration::logError ( "Reply error: {$fp->error}", __CLASS__, __FUNCTION__, __LINE__ );
								}
							}
						}
					}
					if (count ( $comments ) < $config ['fb_limit_comment_post']) {
						LoggerConfiguration::logInfo ( 'Over comment data' );
						break;
					}
				}
				if ($is_nocomment) {
					// khong co comment nao
					LoggerConfiguration::logInfo ( 'No comment for this post' );
					// 1. neu chua qua so ngay nodata (nodata_number_day) tang so luot dem
					// 2. da qua so luot nodata_number: reset so luot va gian thoi gian thuc hien lay comment
					if ($post ['nodata_number_day'] >= $config ['max_nodata_comment_day']) {
						LoggerConfiguration::logInfo ( "nodata_number_day={$post ['nodata_number_day']} >= max_nodata_comment_day={$config ['max_nodata_comment_day']}" );
						if ($current_day > $last_day) {
							LoggerConfiguration::logInfo ( "current_day=$current_day > last_day=$last_day" );
							LoggerConfiguration::logInfo ( 'Reset nodata_number_day' );
							// reset so dem nodata_number_day & gian cach thoi gian lan xu ly sau
						}
					}
					break;
				} else {
					if ($post ['nodata_number_day'] > 0) {
						LoggerConfiguration::logInfo ( 'Reset nodata_number_day' );
						// reset so dem nodata_number_day
					}
				}
				// cap nhat du lieu post
				LoggerConfiguration::logInfo ( 'Update for this post' );
			}
			if (count ( $posts ) < $config ['load_post_limit']) {
				LoggerConfiguration::logInfo ( 'Over post data' );
				break;
			}
		}
		LoggerConfiguration::logInfo ( '--- END ---' );
	}
	private function _includedPhone(&$str) {
		if (preg_match ( '/[0-9]{10,12}/', $str )) {
			return true;
		}
		return false;
	}
	private function _loadConfig() {
		return array (
				'load_post_limit' => LOAD_POST_LIMIT,
				'fb_limit_comment_post' => FB_LIMIT_COMMENT_POST,
				'max_nodata_comment_day' => 5 
		);
	}
}