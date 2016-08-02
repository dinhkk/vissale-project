<?php
/**
 * Cau hinh App facebook
 */
define('FB_APP_CALLBACK_URL', 'https://vissale.com/fb_module/fb_callback.php');
define('FB_APP_VERIFY_TOKEN', '0aaffee84f94dc316242d01bb7c94690');
define('FB_APP_ID', '967811573302640');
define('FB_APP_SECRET', '51b9c0cac5a277d1c86e356ad2a13b64');
define('FB_API_VER', 'v2.5');
define('FB_APP_DOMAIN', 'http://login.vissale.com/');
define('CALLBACK_AFTER_SYNCPAGE', 'FBPage');

/**
 * Trang thoi don hang mac dinh
 */

define('ORDER_STATUS_SUCCESS', 5); // don hang da thanh cong
define('ORDER_STATUS_CANCELED', 9); // don hang da bi huy
define('ORDER_STATUS_DEFAULT', 10); // trang thai mac dinh khi tao don hang