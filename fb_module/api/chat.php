<?php
/**
 * Thuc hien dong bo noi dung conversation 
 */
error_reporting(0);
require_once dirname(__FILE__) . '/../FB.php';
$group_chat_id = intval($_REQUEST['group_chat_id']);
if (! $group_chat_id) {
    echo 'ERROR';
    exit(0);
}
$message = trim($_REQUEST['message']);
if (empty($message)) {
    echo 'ERROR';
    exit(0);
}
if ((new FB())->chat($group_chat_id, $message)) {
    echo 'SUCCESS';
    exit(0);
}
echo 'ERROR';
exit(0);