<?php
$config['sysconfig'] = array(
   'FBPost' => array(
   		'GET_PAGE_ID_BY_POST' => 'http://login.vingrowth.com/api/detect_pageid.php',
        'VALIDATE_POST' => 'http://login.vingrowth.com/api/validate_post.php'
   ),
	'FBPage'=>array(
			'FB_LOGIN' => 'http://login.vingrowth.com/login.php',
	        'FB_SUBSCRIBED_APPS' => 'http://login.vingrowth.com/api/subscribed_apps.php',
	),
	'FBChat'=>array(
			'SEND_MSG_API' => 'http://login.vingrowth.com/api/chat.php',
			'SYNC_MSG_API' => 'http://login.vingrowth.com/api/sync_chat.php'
	),
	'FB_CORE' => array(
			'CLEAR_CACHE' => 'http://login.vingrowth.com/api/cc.php'
	)
);
