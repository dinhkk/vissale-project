<?php
require_once dirname ( __FILE__ ) . '/fbapi.php';
require_once dirname ( __FILE__ ) . '/../db/FBDBProcess.php';
$fb = fbapi_instance ();
$helper = $fb->getRedirectLoginHelper ();
try {
	$accessToken = $helper->getAccessToken ();
} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
	// When Graph returns an error
	LoggerConfiguration::logError ( 'Graph returned an error: ' . $e->getMessage (), __FILE__, '', __LINE__ );
	echo 'FBAPI_ERROR';
	exit ( 0 );
} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
	// When validation fails or other local issues
	LoggerConfiguration::logError ( 'Facebook SDK returned an error: ' . $e->getMessage (), __FILE__, '', __LINE__ );
	echo 'FBAPI_ERROR';
	exit ( 0 );
}
if (isset ( $accessToken )) {
	$accessToken = ( string ) $accessToken;
	$_SESSION ['token'] = $accessToken;
	$fp_core = new Fanpage ();
	$fanpage_list = $fp_core->get_list ( $accessToken );
	if ($fanpage_list) {
		$db = new FBDBProcess ();
		// group_id duoc luu vao session khi user login he thong
		$group_id = $_SESSION ['group_id'];
		$created_time = time ();
		$added_pages = null;
		foreach ( $fanpage_list as $page ) {
			$page_id = $page ['id'];
			$page_name = $page ['name'];
			$token = $page ['accesstoken'];
			$page_id = $page ['id'];
			if ($db->storePages ( $group_id, $page_id, $page_name, $token, $created_time ) !== false) {
				$added_pages [] = $page_id;
			} else
				break;
		}
		if ($added_pages)
			echo 'SUCCESS';
		else
			echo 'PROCESS_FAIL';
	} else {
		LoggerConfiguration::logError ( 'Not found fanpage for user', __FILE__, '', __LINE__ );
		echo 'NOTFOUND';
	}
} else {
	LoggerConfiguration::logError ( 'Not found user accesstoken', __FILE__, '', __LINE__ );
	echo 'ACCESSTOKEN_ERROR';
	exit ( 0 );
}