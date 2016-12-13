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

global $url, $debug;

$access_token = "EAASuYEiZAaEMBAA5oJmvZCX1rrw1N99xQHiXd4Kp9aFZCB4zeZA4pmM0FJQIrvPJgPLnVQHxzgMbM2eTsLWxApZCj9UiKKnt9UbRHXFHYJeXEtZCGimcU08l5V3fR0GNkuIK6tNZCgZBIDuzvj0EdTagtE6mrDc7SFL0awZC743Q2EQZDZD";
$verify_token = "fb_time_bot";
$hub_verify_token = null;

$url = 'https://graph.facebook.com/v2.8/me/messages?access_token=' . $access_token;
$debug = DebugService::getInstance();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['hub_mode'] == 'subscribe' && $_GET['hub_verify_token'] == $verify_token) {
    echo $_GET['hub_challenge'];
    die;
}


//get post content
$input = json_decode(file_get_contents('php://input'), true);
$debug->debug('call back message', $input);

//validations
if ( empty($input['entry'][0]['messaging']) ) {
    return false;
}


$page_id = $input['entry'][0]['id'];
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];

if ($page_id == $sender || empty($input['entry'][0]['messaging'][0]['message']) ) {
    return false;
}


/**
 * Some Basic rules to validate incoming messages
 */
$test = parseMessage($message);
$debug->debug('parse message =>', array('message' => $test ));

if ($test == "vissale") {
    $msgJson1 = tplVisitVissale($sender);
    sendMessage($msgJson1);

    $msgJson2 = vissaleAnswer($sender);
    sendMessage($msgJson2);

}

if ($test == "how_much") {
    $msgJson = howMuchAnswer($sender);
    sendMessage($msgJson);
}

if ($test == "how_long") {
    $msgJson = howLongAnswer($sender);
    sendMessage($msgJson);
}

if ($test == "refund") {
    $msgJson = refundAnswer($sender);
    sendMessage($msgJson);
}

//API Url


function sendMessage($jsonData){
    global $url, $debug;
    //Initiate cURL.
    $ch = curl_init($url);

//Encode the array into JSON.
    $jsonDataEncoded = $jsonData;

//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Execute the request
    $curl_result = curl_exec($ch);
    curl_close($ch);
    $debug->debug('curl post message to fb result =>', array('curl_result' => json_decode($curl_result, true) ));
}


function tplVisitVissale($sender){
    //The JSON data.
    $jsonData = '{
  "recipient":{
    "id":"'.$sender.'"
  },
  "message":{
    "attachment":{
      "type":"template",
      "payload":{
        "template_type":"generic",
        "elements":[
          {
            "title":"Welcome to vissale",
            "item_url":"http://vissale.vn/vissale-soft/",
            "image_url":"https://app.vissale.com/assets/standard/images/vissale_logo.png",
            "subtitle":"We are here to serve you !",
            "buttons":[
              {
                "type":"web_url",
                "url":"http://vissale.vn/vissale-soft/",
                "title":"Visit us now :)",
                "webview_height_ratio":"tall"
              }
            ]
          }
        ]
      }
    }
  }
}';

    return $jsonData;
}

function howMuchAnswer($sender){
    $jsonAnswer = '{
      "recipient":{
        "id":"'.$sender.'"
      },
      "message":{
        "text":"All services have the same price, $100 / year"
      }
    }';
    return $jsonAnswer;
}

function howLongAnswer($sender){
    $jsonAnswer = '{
      "recipient":{
        "id":"'.$sender.'"
      },
      "message":{
        "text":"We serve you these packages:  $50/6 months OR $100 / one year"
      }
    }';
    return $jsonAnswer;
}

function vissaleAnswer($sender){
    $jsonAnswer = '{
      "recipient":{
        "id":"'.$sender.'"
      },
      "message":{
        "text":"We are very thankful for your considering to our service. 
        We bring the advices to run your business in the best way you can run. No much worries about money and time."
      }
    }';
    return $jsonAnswer;
}

function refundAnswer($sender){
    $jsonAnswer = '{
      "recipient":{
        "id":"'.$sender.'"
      },
      "message":{
        "text":"Yes, within one month, if you are disappointed, we will refund you :)"
      }
    }';
    return $jsonAnswer;
}

function parseMessage($message) {
    $test = preg_match("/(\bhow much\b)/i", $message, $keywords);
    if ($test==1) {
        return 'how_much';
    }

    $test = preg_match("/(\bhow long\b)/i", $message, $keywords);
    if ($test==1) {
        return "how_long";
    }

    $test = preg_match("/(\bvissale\b)/i", $message, $keywords);
    if ($test==1) {
        return "vissale";
    }

    $test = preg_match("/(\brefund\b)/i", $message, $keywords);
    if ($test==1) {
        return "refund";
    }

    return -1;
}

function detectAnswerMessage($sender, $message){
    $test = parseMessage($message);
    $message = null;

    switch ($test) {
        case 'how_much' :
            $message = howMuchAnswer($sender);
            break;

        case 'how_long' :
            $message = howLongAnswer($sender);
            break;

        case 'vissale' :
            $message = tplVisitVissale($sender);
            break;
        default :
            $message = null;
            break;
    }

    return $message;
}