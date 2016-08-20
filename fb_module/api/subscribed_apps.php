<?php
error_reporting(0);
if (empty($_GET['page_id'])) {
    exit(0);
}
if (empty($_GET['act'])) {
    exit(0);
}
require_once dirname(__FILE__) . '/../FB.php';
if ($_GET['act'] === 'active') {
    if ((new FB())->createPageSubscribedApps($_GET['page_id'])) {
        echo '1';
        exit(0);
    }
} elseif ($_GET['act'] === 'deactive') {
    if ((new FB())->deletePageSubscribedApps($_GET['page_id'])) {
        echo '1';
        exit(0);
    }
}
echo '0';
exit(0);