<?php
if (empty ( $_GET ['post_id'] )) {
	exit ( 0 );
}
require_once dirname ( __FILE__ ) . '/../src/core/Fanpage.core.php';
$page_id = Fanpage::getPageIdOfPost ( $_GET ['post_id'] );
if ($page_id) {
	echo $page_id;
	exit ( 0 );
}