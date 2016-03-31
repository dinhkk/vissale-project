<?php

echo $this->start('css');
echo $this->Html->css(array(
    '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min',
));
echo $this->end();

echo $this->start('script');
echo $this->Html->script(array(
    '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker',
));
echo $this->end();
