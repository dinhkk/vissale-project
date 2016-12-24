<?php
/**
 * Thuc hien dong bo noi dung conversation 
 */
error_reporting(0);
require_once dirname(__FILE__) . '/../FB.php';

header('Content-Type: application/json');
$content = array(
    'success' => false,
    'data' => null
);


$group_chat_id = intval($_REQUEST['group_chat_id']);
if (! $group_chat_id) {
    echo json_encode($content);
    exit(0);
}
$message = !empty($_REQUEST['message']) ? trim($_REQUEST['message']) : null;
$private_reply = !empty($_REQUEST['is_private']) ? true : false;
$attachment_url = !empty($_REQUEST['attachment_url']) ? $_REQUEST['attachment_url'] : null;

if (empty($message) && empty($message)) {
    echo json_encode($content);
    exit(0);
}

$result = (new FB())->chat($group_chat_id, $message, $attachment_url, $private_reply);

if (!$result) {
    echo json_encode($content);
    exit(0);
}


//when success
$content['success'] = true;
$content['data'] = $result;
echo json_encode($content);

exit(0);