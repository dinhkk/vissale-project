<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 1/1/17
 * Time: 3:54 PM
 */

# messenger_login_callback.php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/src/core/fbapi.php';

$action = !empty($_SESSION['action']) ? $_SESSION['action'] : null;
$group_id = !empty($_SESSION['group_id']) ?$_SESSION['group_id'] : null;

if ($action == "update" &&  $action) {
    echo 'NOGROUP';
    exit(0);
}


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


$res = $fb->get ( '/me', $accessToken);

$res_data = json_decode ( $res->getBody () );

var_dump($res_data);

die;

if ( isset($accessToken) ) {
    // Logged in!
    $accessToken = (string) $accessToken;

    $groupPages = ( getPages($group_id) );
    $facebookPages = ( getFacebookPages($fb, $accessToken) );

    $sync = appendMessengerToken($fb, $groupPages, $facebookPages);


    if ($sync) {
        callback("SUCCESS");
    }
    callback('FAILED');
    die;
} elseif ($helper->getError()) {
    // The user denied the request
    callback('FAILED');

    exit;
}


function getPages($group_id)
{
    $options = array(
        'conditions' => array(
            'group_id = ?',
            $group_id
        )
    );
    $pages = Page::find('all', $options);
    return $pages;
}

function getFacebookPages($facebookSDKInstance, $token)
{
    $res = $facebookSDKInstance->get ( '/me/accounts', $token);

    $res_data = json_decode ( $res->getBody () );
    return !empty($res_data->data) ? $res_data->data : null;
}


function appendMessengerToken($facebookSDKInstance, $groupPages, $facebookPages)
{
    if (count($groupPages) == 0 || count($facebookPages) == 0) {
        return false;
    }

    foreach ($groupPages as $groupPage) {
        foreach ($facebookPages as $facebookPage) {

            if ($groupPage->page_id == $facebookPage->id) {
                if ($groupPage->status == 0) {
                    subscribeMessengerToPage($facebookSDKInstance, $facebookPage->access_token);
                }
                $groupPage->messenger_token = $facebookPage->access_token;
                $groupPage->save();
            }
        }
    }

    return true;
}


function callback($response_code)
{
    $response_code = urlencode($response_code);
    header('Location: ' . CALLBACK_AFTER_SYNCPAGE . "/?rs={$response_code}");
    exit(0);
}

function subscribeMessengerToPage($facebookSDKInstance, $pageToken)
{
    $facebookSDKInstance->post( 'me/subscribed_apps', [], $pageToken);
}