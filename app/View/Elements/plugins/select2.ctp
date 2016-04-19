<?php

echo $this->start('css');
echo $this->Html->css(array(
    '/assets/global/plugins/select2/css/select2.min',
    '/assets/global/plugins/select2/css/select2-bootstrap.min',
));
echo $this->end();

echo $this->start('script');
echo $this->Html->script(array(
    '/assets/global/plugins/select2/js/select2.full.min',
));
echo $this->end();
