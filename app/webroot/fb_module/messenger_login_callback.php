<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 12/20/16
 * Time: 5:43 PM
 */
# messenger_login_callback.php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/src/core/fbapi.php';

$fb = fbapi_messenger_instance();
$helper = $fb->getRedirectLoginHelper();

$accessToken = null;


try {
    $accessToken = $helper->getAccessToken();

} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$data = array(
    'success' => 0,
    'message' => "Failed",
    ''
);
if (!$accessToken) {
    $data['message'] = "Lỗi truy cập đến facebook";
}

$res = $fb->get ( 'me?fields=id,name,email,accounts', $accessToken);
$response = $res->getDecodedBody();

$accounts = $response['accounts'];
$count = count($accounts);
if ($count == 0) {
    return false;
}

foreach ($accounts as $index => $account) {
    if (! is_numeric($index) ) {
        continue;
    }
    $page_id = $account['id'];
    $options = array(
        'conditions' => array(
            'page_id ?', $page_id
        )
    );
    $pageModel = Page::find('first', $options);
    if ( $pageModel ) {
        $pageModel->messenger_token = $account['access_token'];
        $pageModel->save();
        continue;
    }
    var_dump($account);
    //$pageModel->messenger_token = $account['access_token'];
    //$pageModel->page_name = $account['page_name'];

}

function postDataRegister($data)
{
    $url = BASE_URL . "/register";
}

function synchronizePage()
{

}