<?php
require_once dirname(__FILE__) . '/../src/core/Fanpage.core.php';
$config = array(
    'fb_app_id'=>'1539094453087535',
    'fb_app_secret_key'=>'2e11e305701be5b305c4691eb0b11210',
    'fb_app_version'=>'v2.5'
);
$fb = new Fanpage($config);
var_dump($fb->createWebhook());
//var_dump($fb->getWebhookSubscriptions($config['fb_app_id']));
//var_dump($fb->createPageSubscribedApps('734899429950601', 'EAANwODEJRXABACffT29ZBAPVJ9VEo2rxZAG5C8xdZBZBHUpA9EdbgRJxUa3r3YZCuLdzibfw38kvksBPmAZC4zxFl74XWYtZBUmcjZB1pYvQjZCHWnbXHhZCZCQ6PULOXI3v1YG0X99DUzUZA5NzXtoBXogq7Sck2jvZBXM25bYmeCHeKShRGilXcZB6QiQN332jQ96LoZD'));