<?php
require_once("vendor/autoload.php");
require_once("FB.php");

use Services\Group;

//$val = null;
//var_dump(isset($val));die;

//$id = 1;
//$group = new Group($id);
//var_dump( $group->isJobAvailable() );


$data = array(
    'id' => '1111212121212'
);

$fb = new FB();

$fb->run($data);
