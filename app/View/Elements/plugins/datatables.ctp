<?php

echo $this->start('css');
echo $this->Html->css(array(
    '/assets/global/plugins/datatables/datatables.min',
    '/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap',
));
echo $this->end();

//echo $this->start('script');
//echo $this->Html->script(array(
//    '/assets/global/scripts/datatable',
//    '/assets/global/plugins/datatables/datatables.min',
//    '/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap',
//    '/assets/pages/scripts/table-datatables-editable.min',
//));
//echo $this->end();
