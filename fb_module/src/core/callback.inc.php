<?php
// $callback_time = time ();
if (! isset ( $_SESSION ['group_id'] ) || empty ( $_SESSION ['group_id'] )) {
	var_dump($_SESSION);
	echo 'NOGROUP';
	exit ( 0 );
}
$group_id = $_SESSION ['group_id'];
unset ( $_SESSION ['group_id'] );
require_once dirname ( __FILE__ ) . '/fbapi.php';
require_once dirname ( __FILE__ ) . '/../db/FBDBProcess.php';
require_once dirname ( __FILE__ ) . '/../core/Fanpage.core.php';
// if (empty ( $_SESSION ['trans_id'] ) || empty ( $_SESSION ['group_id'] )) {
// //echo 'ERROR_SESSION';
// callback('ERROR_SESSION');
// }
// $group_id = $_SESSION ['group_id'];
// unset ( $_SESSION ['group_id'] );
// $transid = $_SESSION ['trans_id'];
// unset ( $_SESSION ['trans_id'] );
$db = new FBDBProcess ();
// lay yeu cau tu DB
// $group = $db->getGroup ( $group_id );
// if (! $group) {
// echo 'ERROR_GROUP';
// exit ( 0 );
// }
// // kiem tra transid co dung khong
// if ($group ['sync_page_transid'] !== $transid) {
// echo 'TRANS_ERROR';
// exit ( 0 );
// }
// // kiem tra transid da het han
// if ($callback_time > $group ['sync_page_expire']) {
// echo 'TRANS_EXPIRE';
// exit ( 0 );
// }
$fb = fbapi_instance ();
$helper = $fb->getRedirectLoginHelper ();
try {
	$accessToken = $helper->getAccessToken ();
} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
	// When Graph returns an error
	LoggerConfiguration::logError ( 'Graph returned an error: ' . $e->getMessage (), __FILE__, '', __LINE__ );
	// echo 'FBAPI_ERROR';
	callback ( 'FBAPI_ERROR' );
} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
	// When validation fails or other local issues
	LoggerConfiguration::logError ( 'Facebook SDK returned an error: ' . $e->getMessage (), __FILE__, '', __LINE__ );
	callback ( 'FBAPI_ERROR' );
}
if (isset ( $accessToken )) {
	$accessToken = ( string ) $accessToken;
	LoggerConfiguration::init ( "User FB AccessToken=$accessToken" );
	$_SESSION ['token'] = $accessToken;
	$fp_core = new Fanpage ();
	// luu user accesstoken
	// group_id duoc luu vao session khi user login he thong
	// $group_id = empty ( $_SESSION ['group_id'] ) ? 1 : $_SESSION ['group_id'];
	// LoggerConfiguration::logInfo ( "Group ID=$group_id" );
	// xoa du lieu cu
	// if (! $db->dropPages ( $group_id )) {
	// echo 'SERVER_ERROR';
	// exit ( 0 );
	// }
	$db->set_auto_commit ( false );
	if (! $db->storeFBUserGroup ( $group_id, '', $accessToken )) {
		$db->set_auto_commit ( true );
		callback ( 'SERVER_ERROR' );
	}
	$fanpage_list = $fp_core->get_list ( $accessToken );
	if ($fanpage_list) {
		LoggerConfiguration::logInfo ( 'Fanpage list:' . print_r ( $fanpage_list, true ) );
		$created_time = time ();
		$added_pages = null;
		foreach ( $fanpage_list as $page ) {
			$page_id = $page ['id'];
			$page_name = $page ['name'];
			$token = $page ['access_token'];
			$page_id = $page ['id'];
			if ($db->storePages ( $group_id, $page_id, $page_name, $token, $created_time ) === false) {
				continue;
			} else
				$added_pages [] = $page_id;
		}
		if ($added_pages) {
			$db->commit ();
			$db->set_auto_commit ( true );
			callback ( 'SUCCESS' );
		} else {
			$db->rollback ();
			$db->set_auto_commit ( true );
			callback ( 'PROCESS_FAIL' );
		}
	} else {
		LoggerConfiguration::logError ( 'Not found fanpage for user', __FILE__, '', __LINE__ );
		$db->rollback ();
		$db->set_auto_commit ( true );
		callback ( 'NOTFOUND' );
	}
} else {
	LoggerConfiguration::logError ( 'Not found user accesstoken', __FILE__, '', __LINE__ );
	callback ( 'ACCESSTOKEN_ERROR' );
}
function callback($response_code) {
	header ( 'Location: ' . CALLBACK_AFTER_SYNCPAGE . '/?rs=FBAPI_ERROR' );
	exit ( 0 );
}