<?php
require_once dirname ( __FILE__ ) . '/../facebook_api/src/Facebook/autoload.php';
require_once dirname ( __FILE__ ) . '/config.php';
require_once dirname ( __FILE__ ) . '/../db/FBDBProcess.php';
function fbapi_instance() {
    // load config
    $db = new FBDBProcess();
    $config = $db->loadConfigByGroup(intval($_GET ['group_id']), array('fb_app_id,fb_app_secret_key,fb_app_version'));
    if (!$config){
        die('CONFIG_NOTFOUND');
    }
    // lay thong tin fb app
    $fb_app_id = null;
    $fb_app_secret_key = null;
    $fb_app_version = null;
    foreach ($config as $data) {
        if ($data['_key']==='fb_app_id'){
            $fb_app_id = $data['value'];
        }elseif ($data['_key']==='fb_app_secret_key'){
            $fb_app_secret_key = $data['value'];
        }
        elseif ($data['_key']==='fb_app_version'){
            $fb_app_version = 'fb_app_version';
        }
    }
    if (!$fb_app_id || !$fb_app_secret_key || !$fb_app_version){
        die('FB_APP_NOTFOUND');
    }
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