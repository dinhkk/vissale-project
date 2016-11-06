<?php
require_once("vendor/autoload.php");

use Services\Group;
use Carbon\Carbon;

$id = 1;
$group = new Group($id);
$options = $group->getOptions();

