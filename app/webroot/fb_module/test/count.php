<?php
/**
 * Created by PhpStorm.
 * User: dinhkk
 * Date: 10/30/16
 * Time: 3:12 PM
 */

require_once dirname(__FILE__) . '/../src/core/config.php';
require_once dirname(__FILE__) . '/../FB.php';
require_once dirname(__FILE__) . '/../src/db/FBDBProcess.php';

$db = new FBDBProcess();

try {
    $test = $db->countParentPostComment('1748976875353195', '935291856560419', '935291856560419_1125944930828443', 0);
    printf('%s', $test);
} catch (Exception $e) {
    printf('%s', $e->getMessage());
}