<?php
require_once dirname(__FILE__) . '/src/core/config.php';
require_once dirname(__FILE__) . '/FB.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['hub_mode'] == 'subscribe' && $_GET['hub_verify_token'] == FB_APP_VERIFY_TOKEN) {
    echo $_GET['hub_challenge'];
} else 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Here you can do whatever you want with the JSON object that you receive from FaceBook.
        // Before you decide what to do with the notification object you might aswell just check if
        // you are actually getting one. You can do this by choosing to output the object to a textfile.
        // It can be done by simply adding the following line:
        (new FB())->run(json_decode(file_get_contents('php://input'), true));
    }
exit(0);