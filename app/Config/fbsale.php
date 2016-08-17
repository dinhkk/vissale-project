<?php

if (!defined("LIMIT_DEFAULT")) {
    define("LIMIT_DEFAULT", 20);
}
// các mức level lọc dữ liệu
if (!defined("ADMINSYSTEM")) { // level cao nhất, không bị lọc theo status và group_id
    define("ADMINSYSTEM", 150);
}
if (!defined("ADMINGROUP")) { // level thứ 2, bị lọc theo group_id, không bị lọc theo status
    define("ADMINGROUP", 100);
}
if (!defined("USERGROUP")) { // level thứ 3, bị lọc theo cả status và group_id
    define("USERGROUP", 50);
}
if (!defined("ZEROLEVEL")) { // level thứ 3, bị lọc theo cả status và group_id
    define("ZEROLEVEL", 0);
}
if (!defined("STATUS_ACTIVE")) {
    define("STATUS_ACTIVE", 1);
}
if (!defined("STATUS_DEACTIVE")) {
    define("STATUS_DEACTIVE", 0);
}
// quyền hạn liên quan tới trạng thái in và xuất exel
if (!defined("PRINT_PERM_ID")) {
    define("PRINT_PERM_ID", 132); // trỏ tới OrdersController::print
}
if (!defined("EXPORT_EXEL_PERM_ID")) {
    define("EXPORT_EXEL_PERM_ID", 133); //  trỏ tới OrdersController::exportExel
}
if (!defined("GROUP_SYSTEM_ID")) {
    define("GROUP_SYSTEM_ID", 1); //  trỏ tới OrdersController::exportExel
}
if (!defined("DEFAULT_PASSWORD")) {
    define("DEFAULT_PASSWORD", '123456'); //  trỏ tới OrdersController::exportExel
}


if (!defined("LIMIT_MAX_POSTCODES")) {
    define("LIMIT_MAX_POSTCODES", '10000');
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
            ADMINSYSTEM => __('Admin hệ thống'),
            ADMINGROUP => __('Admin khách hàng'),
            USERGROUP => __('Quản trị viên khách hàng'),
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


if (!defined("STATUS_XAC_NHAN")) {
    define("STATUS_XAC_NHAN", 7); //
}