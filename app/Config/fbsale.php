<?php

if (!defined("LIMIT_DEFAULT")) {
    define("LIMIT_DEFAULT", 20);
}
$config['fbsale'] = array(
    'App' => array(
        'name' => 'FBSale',
        'limits' => array(
            10 => 10,
            20 => 20,
            50 => 50,
            100 => 100,
        ),
    ),
);

