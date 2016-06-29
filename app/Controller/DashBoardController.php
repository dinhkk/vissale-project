<?php

App::uses('AppController', 'Controller');

class DashBoardController extends AppController {

    public $uses = array('Statuses','Orders');

    public function index() {

        if ($this->request->is("post")){
            $this->charts();
            die;
        }
    }

    public function charts(){
        $user = $this->Auth->user();
        $this->Prg->commonProcess ();
        $options ['conditions'] = $this->{$this->modelClass}->parseCriteria ( $this->Prg->parsedParams () );
        $group = $this->_getGroup();
        $options ['conditions']['group_id IN'] = array(1, $group);
        $options['fields'] = array("id","name");
        $options['limit'] = 1000;

        $list_statues = $this->Statuses->find('list', $options);
        $list_statues['10'] = 'Chưa xác nhận';

        //orders
        $group_id = $this->_getGroup ();
        $options = array ();
        $options ['order'] = array (
            'Orders.created' => 'DESC',
        );
        $options ['conditions'] ['Orders.group_id'] = $group_id;
        $options ['conditions']['created >='] = "2012-01-01";
        $options['fields'] = array('Orders.status_id');

        $list_orders = $this->Orders->find('list', $options);
        $count_status = array_count_values($list_orders);
        $total_order = count($list_orders);
        $percent_status = array();


        foreach ($count_status as $key => $value) {
            $percent_status[$key] = round( ($value/$total_order), 5, PHP_ROUND_HALF_UP) * 100;
        }

        $charts_data = array();
        foreach ($list_statues as $index => $item) {
            $data =  array(
                'name' => $item,
                'y'     => !empty($percent_status[$index]) ? $percent_status[$index] : 0,
            );
            if ($index == 7){
                $data['sliced'] = true;
                $data['selected'] = true;
            }
            $charts_data[] = $data;
        }

        echo json_encode($charts_data);
    }

}
