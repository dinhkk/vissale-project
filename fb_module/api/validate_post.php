<?php
if (empty($_GET['post_id'])) {
    exit(0);
}
if (empty($_GET['fb_page_id'])) {
    exit(0);
}
require_once dirname(__FILE__) . '/../FB.php';
$fb = new FB();
if ($post_id = $fb->validatePost($_GET['post_id'], $_GET['fb_page_id'])) {
    echo json_encode(array(
        'post_id' => $post_id
    ));
} else
    echo '0';
exit(0);