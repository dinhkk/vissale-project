<?php
/**
 * Thuc hien dong bo noi dung conversation 
 */
error_reporting(0);
require_once dirname(__FILE__) . '/../FB.php';
$msg = 'test test test';
if ((new FB())->chat(75, $msg)) {
    echo 'SUCCESS';
    exit(0);
}
echo 'ERROR';
exit(0);