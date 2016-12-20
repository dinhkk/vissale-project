<?php
require_once dirname ( MODULE_PATH ) . '/vendor/autoload.php';
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
        'default_graph_version' => $fb_app_version,
    ] );
}


//messenger instance
function fbapi_messenger_instance(){
    return new Facebook\Facebook([
        'app_id' => '1317628464949315',
        'app_secret' => '28ca48bc299c5824a6d5b1d85699b647',
        'default_access_token' => '1317628464949315|TWppNpYRWdVvDK_ziqFC6fU4Rtw',
        'default_graph_version' => 'v2.8',
    ]);
}


//debug
//return array
//if error, return string error message
function fbapi_messenger_debug($token) {
    try {
        $end_point = "debug_token?input_token={$token}";
        $response = fbapi_messenger_instance()->get($end_point);

        return json_decode($response->getBody(), true);

    } catch (Exception $ex) {
        return $ex->getMessage();
    }

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