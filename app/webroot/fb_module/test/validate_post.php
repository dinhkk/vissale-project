<?php
require_once dirname(__FILE__) . '/../FB.php';
$fb = new FB();
if ($post_id = $fb->validatePost('1001405796594892', 6)) {
    echo json_encode(array(
        'post_id' => $post_id
    ));
} else
    echo '0';
exit(0);