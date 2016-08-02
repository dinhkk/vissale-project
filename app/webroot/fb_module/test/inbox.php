<?php
require_once dirname(__FILE__) . '/../src/core/config.php';
require_once dirname(__FILE__) . '/../FB.php';
$params = array(
    'entry' => array(
        array(
            'changes' => array(
                array(
                    'field' => 'conversations',
                    'value' => array(
                        'thread_id' => 't_mid.1459065654784:df1974fdf685c4b160',
                        'page_id' => '749336251850712'
                    )
                )
            ),
            'id' => '749336251850712',
            'time' => 1464253972
        )
    )
);
(new FB())->run($params);
exit(0);