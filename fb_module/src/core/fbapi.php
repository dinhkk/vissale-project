<?php
require_once dirname ( __FILE__ ) . '/../facebook_api/src/Facebook/autoload.php';
require_once dirname ( __FILE__ ) . '/config.php';
require_once dirname ( __FILE__ ) . '/../db/FBDBProcess.php';
function fbapi_instance() {
    // load config
    $db = new FBDBProcess();
    $config = $db->getGroup(intval($_GET ['group_id']));
    if (!$config){
        return null;
    }
// 	return new Facebook\Facebook ( [ 
// 			'app_id' => FB_APP_ID,
// 			'app_secret' => FB_APP_SECRET,
// 			'default_graph_version' => FB_API_VER 
// 	] );
    return new Facebook\Facebook ( [
        'app_id' => $config['fb_app_id'],
        'app_secret' => $config['fb_app_secret_key'],
        'default_graph_version' => $config['fb_app_version']
    ] );
}
function is_session_started() {
	if (php_sapi_name () !== 'cli') {
		if (version_compare ( phpversion (), '5.4.0', '>=' )) {
			return session_status () === PHP_SESSION_ACTIVE ? true : false;
		} else {
			return session_id () === '' ? false : true;
		}
	}
	return false;
}

// start session
if (is_session_started () === false)
	session_start ();