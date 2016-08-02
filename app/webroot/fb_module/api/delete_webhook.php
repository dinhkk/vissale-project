<?php
error_reporting(0);
if (empty($_GET['group_id'])) {
    exit(0);
}
require_once dirname(__FILE__) . '/../FB.php';
if ((new FB())->deleteWebHook($_GET['group_id'])) {
    echo '1';
    exit(0);
}
echo '0';
exit(0);