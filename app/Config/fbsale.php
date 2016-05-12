<?php

if (!defined("LIMIT_DEFAULT")) {
    define("LIMIT_DEFAULT", 20);
}
// các mức level lọc dữ liệu
if (!defined("ADMINSYSTEM")) { // level cao nhất, không bị lọc theo status và group_id
    define("ADMINSYSTEM", "ADMINSYSTEM");
}
if (!defined("ADMINGROUP")) { // level thứ 2, bị lọc theo group_id, không bị lọc theo status
    define("ADMINGROUP", "ADMINGROUP");
}
if (!defined("USERGROUP")) { // level thứ 3, bị lọc theo cả status và group_id
    define("USERGROUP", "USERGROUP");
}
if (!defined("STATUS_ACTIVE")) {
    define("STATUS_ACTIVE", 1);
}
if (!defined("STATUS_DEACTIVE")) {
    define("STATUS_DEACTIVE", 0);
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
        'role_levels' => array(
            ADMINSYSTEM => ADMINSYSTEM,
            ADMINGROUP => ADMINGROUP,
            USERGROUP => USERGROUP,
        ),
        'status' => array(
            STATUS_ACTIVE => __('Kích hoạt'),
            STATUS_DEACTIVE => __('Tạm ngưng'),
        ),
    ),
    'StockBooks' => array(
        'is_locked' => array(
            0 => __('Chưa khóa'),
            1 => __('Đã khóa'),
        ),
    ),
);

