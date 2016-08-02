<?php
$config['sysconfig'] = array(
   	'FBPost' => array(
   		'GET_PAGE_ID_BY_POST' => 'http://login.vissale.com/api/detect_pageid.php',
                'VALIDATE_POST' => 'http://login.vissale.com/api/validate_post.php'
   	),
	'FBPage'=>array(
		'FB_LOGIN' => 'http://login.vissale.com/login.php',
        'FB_SUBSCRIBED_APPS' => 'https://vissale.com/fb_module/api/subscribed_apps.php',
		'FB_ACTIVE_PAGE'     => 'https://vissale.com/fb_module/api/create_webhook.php?group_id='
	),
	'FBChat'=>array(
		'SEND_MSG_API' => 'https://vissale.com/fb_module/api/chat.php',
		'SYNC_MSG_API' => 'http://login.vissale.com/api/sync_chat.php'
	),
	'FB_CORE' => array(
		'CLEAR_CACHE' => 'http://login.vissale.com/api/cc.php'
	)
);
