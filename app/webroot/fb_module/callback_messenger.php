<?php
/*require_once("src/facebook_api/src/Facebook/autoload.php");
$config = require_once("src/core/config.php");

$fb = new Facebook\Facebook([
    'app_id' => '268218990208633',
    'app_secret' => 'e313330c4cd846c5d2b51b8879c7e0c1',
    'default_graph_version' => 'v2.7',
]);

$fb->setDefaultAccessToken('EAAYUhceeTjwBAKqfkyZAe5d5pnJblcE4vr3bnVzws8pbHvwATVkZBMlHJZBjaZAi8j1ZBeS5MSNZCFptpdQ2G7cQZCz6ZC9KqPJAqah1ERRB9ebWU2SOopBDs7uOIootAeaP635P5suPdjB29BoAZCz6FcNnkkWEGic9SdPPFJoxucgZDZD');*/


/**
 * Webhook for Time Bot- Facebook Messenger Bot
 * User: adnan
 * Date: 24/04/16
 * Time: 3:26 PM
 */

require_once("vendor/autoload.php");

use Services\DebugService;

$debug = DebugService::getInstance();

$access_token = "EAASuYEiZAaEMBAA5oJmvZCX1rrw1N99xQHiXd4Kp9aFZCB4zeZA4pmM0FJQIrvPJgPLnVQHxzgMbM2eTsLWxApZCj9UiKKnt9UbRHXFHYJeXEtZCGimcU08l5V3fR0GNkuIK6tNZCgZBIDuzvj0EdTagtE6mrDc7SFL0awZC743Q2EQZDZD";
$verify_token = "fb_time_bot";
$hub_verify_token = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['hub_mode'] == 'subscribe' && $_GET['hub_verify_token'] == $verify_token) {
    echo $_GET['hub_challenge'];
    die;
}


//get post content
$input = json_decode(file_get_contents('php://input'), true);
file_put_contents("/var/www/superapi.tk/logs/content.txt", $input);
$debug->debug('call back message', $input);
//


$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];

$message_to_reply = '';

/**
 * Some Basic rules to validate incoming messages
 */
if (preg_match('[time|current time|now]', strtolower($message))) {

    // Make request to Time API
    ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 6.0)');
    $result = file_get_contents("http://www.timeapi.org/utc/now?format=%25a%20%25b%20%25d%20%25I:%25M:%25S%20%25Y");
    if ($result != '') {
        $message_to_reply = $result;
    }
} else {
    $message_to_reply = 'Huh! what do you mean? test';
}

//API Url
$url = 'https://graph.facebook.com/v2.8/me/messages?access_token=' . $access_token;


//Initiate cURL.
$ch = curl_init($url);

//The JSON data.
$jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
    },
    "message":{
      "text":"'.$message_to_reply.'",
      "attachment":{
      "type":"template",
      "payload":{
        "template_type":"generic",
        "elements":[
          {
            "title":"Classic White T-Shirt",
            "item_url":"https://petersfancyapparel.com/classic_white_tshirt",
            "image_url":"https://petersfancyapparel.com/classic_white_tshirt.png",
            "subtitle":"Soft white cotton t-shirt is back in style",
            "buttons":[
              {
                "type":"web_url",
                "url":"https://petersfancyapparel.com/classic_white_tshirt",
                "title":"View Item",
                "webview_height_ratio":"tall"
              }
            ]
          }
        ]
      }
    }
    }
}';

//Encode the array into JSON.
$jsonDataEncoded = $jsonData;

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

//Execute the request
if (!empty($input['entry'][0]['messaging'][0]['message'])) {
    $result = curl_exec($ch);
}
