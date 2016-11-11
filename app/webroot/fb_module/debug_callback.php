<?php
require_once("src/facebook_api/src/Facebook/autoload.php");
$config = require_once("src/core/config.php");

$fb = new Facebook\Facebook([
    'app_id' => '268218990208633',
    'app_secret' => 'e313330c4cd846c5d2b51b8879c7e0c1',
    'default_graph_version' => 'v2.7',
]);

$fb->setDefaultAccessToken('EAAYUhceeTjwBAKqfkyZAe5d5pnJblcE4vr3bnVzws8pbHvwATVkZBMlHJZBjaZAi8j1ZBeS5MSNZCFptpdQ2G7cQZCz6ZC9KqPJAqah1ERRB9ebWU2SOopBDs7uOIootAeaP635P5suPdjB29BoAZCz6FcNnkkWEGic9SdPPFJoxucgZDZD');

