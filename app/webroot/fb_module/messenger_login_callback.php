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

if ( isset($accessToken) ) {
    // Logged in!
    $accessToken = (string) $accessToken;
    var_dump($accessToken);
    $conversation = Conversation::find(258833);
    var_dump($conversation);

    die;
} elseif ($helper->getError()) {
    // The user denied the request
    exit;
}