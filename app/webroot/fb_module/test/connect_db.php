<?php
require_once dirname(__FILE__) . '/../src/db/DBMysql.php';
DBMysql::getInstance();
var_dump(mysqli_connect_error());