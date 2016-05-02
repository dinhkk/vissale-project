<?php
require_once dirname ( __FILE__ ) . '/../facebook_api/src/Facebook/autoload.php';
require_once dirname ( __FILE__ ) . '/config.php';
function fbapi_instance(&$app_config) {
    // load config
    $fb_app_id = $app_config['fb_app_id'];
    $fb_app_secret_key = $app_config['fb_app_secret_key'];
    $fb_app_version = $app_config['fb_app_version'];
// 	return new Facebook\Facebook ( [ 
// 			'app_id' => FB_APP_ID,
// 			'app_secret' => FB_APP_SECRET,
// 			'default_graph_version' => FB_API_VER 
// 	] );
    return new Facebook\Facebook ( [
        'app_id' => $fb_app_id,
        'app_secret' => $fb_app_secret_key,
        'default_graph_version' => $fb_app_version
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