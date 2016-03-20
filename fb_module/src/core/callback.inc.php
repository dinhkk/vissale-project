<?php
require_once dirname ( __FILE__ ) . '/fbapi.php';
$fb = fbapi_instance ();
$helper = $fb->getRedirectLoginHelper ();
try {
	$accessToken = $helper->getAccessToken ();
} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
	// When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage ();
	exit ();
} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage ();
	exit ();
}
if (isset ( $accessToken )) {
	$accessToken = ( string ) $accessToken;
	$_SESSION ['token'] = $accessToken;
} else {
	echo 'Can not get access token';
	exit ( 0 );
}