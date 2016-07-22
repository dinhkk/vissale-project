<?php
// $callback_time = time ();
require_once dirname(__FILE__) . '/fbapi.php';
require_once dirname(__FILE__) . '/../db/FBDBProcess.php';
require_once dirname(__FILE__) . '/../core/Fanpage.core.php';
if (! isset($_SESSION['group_id']) || empty($_SESSION['group_id'])) {
    echo 'NOGROUP';
    exit(0);
}
$group_id = $_SESSION['group_id'];
unset($_SESSION['group_id']);
$db = new FBDBProcess();
$config = $db->loadConfigByGroup($group_id, '"fb_app_id","fb_app_secret_key","fb_app_version"');
if (! $config) {
    die('CONFIG_NOTFOUND');
}
$app_config = null;
foreach ($config as $conf){
    if ($conf['_key']=='fb_app_id'){
        $app_config['fb_app_id'] = $conf['value'];
    }elseif ($conf['_key']=='fb_app_secret_key'){
        $app_config['fb_app_secret_key'] = $conf['value'];
    }else if ($conf['_key']=='fb_app_version'){
        $app_config['fb_app_version'] = $conf['value'];
    }
}
$fb = fbapi_instance($app_config);
$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    LoggerConfiguration::logError('Graph returned an error: ' . $e->getMessage(), __FILE__, '', __LINE__);
    // echo 'FBAPI_ERROR';
    callback($e->getMessage());
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    LoggerConfiguration::logError('Facebook SDK returned an error: ' . $e->getMessage(), __FILE__, '', __LINE__);
    callback($e->getMessage());
}
if (isset($accessToken)) {
    $accessToken = (string) $accessToken;
    LoggerConfiguration::init("User FB AccessToken=$accessToken");
    $_SESSION['token'] = $accessToken;
    $fp_core = new Fanpage($app_config);
    // luu user accesstoken
    if (! $db->storeFBUserGroup($group_id, '', $accessToken)) {
        //$db->set_auto_commit(true);
        callback('SERVER_ERROR');
        exit(0);
    }
    $fanpage_list = $fp_core->get_list($accessToken);
    if ($fanpage_list) {
        LoggerConfiguration::logInfo('Fanpage list:' . print_r($fanpage_list, true));
        $created_time = time();
        $added_pages = null;
			
        foreach ($fanpage_list as $page) {
						$page_id = $page['id'];
            $page_name = $page['name'];
            $token = $page['access_token'];
            //$page_id = $page['id'];
            LoggerConfiguration::logInfo("db->storePages(group_id=$group_id, page_id=$page_id, page_name=$page_name, token=$token, created_time=$created_time)");
            if ($db->storePages($group_id, $page_id, $page_name, $token, $created_time)) {
                $added_pages[] = $page_id;
            }
						//echo $group_id.'-'.$page_id.'-'.$page_name.'-'.$page['statsu'].'<br>';
        }
				//die;
        if ($added_pages) {
            //$db->commit();
            //$db->set_auto_commit(true);
            callback('SUCCESS');
        } else {
            //$db->rollback();
            //$db->set_auto_commit(true);
            callback('PROCESS_FAIL');
        }
    } else {
        LoggerConfiguration::logError('Not found fanpage for user', __FILE__, '', __LINE__);
        //$db->rollback();
        //$db->set_auto_commit(true);
        callback('NOTFOUND');
    }
} else {
    LoggerConfiguration::logError('Not found user accesstoken', __FILE__, '', __LINE__);
    callback('NOTFOUND_ACCESSTOKEN');
}

function callback($response_code)
{
    $response_code = urlencode($response_code);
    header('Location: ' . CALLBACK_AFTER_SYNCPAGE . "/?rs={$response_code}");
    exit(0);
}