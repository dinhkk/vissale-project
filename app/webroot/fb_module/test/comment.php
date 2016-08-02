<?php
require_once dirname(__FILE__) . '/../src/core/config.php';
require_once dirname(__FILE__) . '/../FB.php';
$params = array(
    'entry' => array(
        array(
            'changes' => array(
                array(
                    'field' => 'feed',
                    'value' => array(
                        'parent_id' => '749336251850712_944136642370671',
                        'sender_name' => 'Tien Cong Mac',
                        'comment_id' => '944136642370671_951035608347441',
                        'sender_id' => '176718519385100',
                        'item' => 'comment',
                        'verb' => 'add',
                        'created_time' => 1463371355,
                        'post_id' => '749336251850712_944136642370671',
                        'message' => 'so day nhe'
                    )
                )
            ),
            'id' => '749336251850712',
            'time' => 1463371355
        )
    )
);
(new FB())->run($params);
exit(0);