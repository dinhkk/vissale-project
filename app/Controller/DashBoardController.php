<?php

App::uses('AppController', 'Controller');
App::uses('BaseLog', 'Log/Engine');

class DashBoardController extends AppController {

    public $uses = array('Statuses','Orders','User');
    public $components = array("Dompdf");

    public function _initData(){
        $list_users = $this->User->find("list", [
                "fields" => ["id", "name"]
            ]
            );
        $this->set("list_users", $list_users);
    }

    public function index() {

        if ($this->request->is("post")){
            $this->ordersCharts();
            die;
        }
    }

    public function ordersStatic()
    {
        if ($this->request->is("post")){
            $orders = $this->ordersChartsByDates($this->request->data);
            echo json_encode($orders);
            die();
        }

    }

    public function usersStatic()
    {
        $this->getOneUserOrders(null);

        $this->_initData();


        if ($this->request->is("post")) {

            $this->exportPdfUsers( $this->request->data );

            die;
        }

    }

    public function exportPdfUsers($data=null){
        $view = new View($this,false);
        $view->viewPath='Elements';
        $view->layout=false;

        $users = $this->getUsersOrders( $data, $view );

        $view->set('page_title', "Tổng hợp doanh số tất cả nhân viên");

        $view->set('users', $users);
        if ( !empty($data['User']['id']) ) {
            $view->set('selected_user', $users[0]);
        }
        
        $html=$view->render('users_sale_report');

        //
        $dompdf = $this->Dompdf->getInstance();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("bao_cao_doanh_so", array("Attachment"=>0) );
    }

    private function getUsersOrders($data=null, $view=null){
        $start = !empty($data['start_date']) ? $data['start_date'] : date('Y-m-01');
        $end = !empty($data['end_date']) ? $data['end_date'] : date('Y-m-d');

        if (!empty($view)) {
            $view->set("start_date", $start);
            $view->set("end_date", $end);
        }


        $conditions = array();
        if (!empty($data['User']['id'])) {
            $conditions['User.id'] =  $data['User']['id'];
        }
        $this->User->Behaviors->load('Containable');


        $users = $this->User->find("all", array(
            'conditions' => $conditions,
            'contain' => array(
                'AssignedOrders' => array(
                    'conditions' => array(
                        "created BETWEEN '{$start}' AND '{$end}'"
                    )
                ),
                'CancelOrders' => array(
                    'conditions' => array(
                        "CancelOrders.created BETWEEN '{$start}' AND '{$end}'"
                    )
                ),
                'SuccessOrders' => array(
                    'conditions' => array(
                        "SuccessOrders.created BETWEEN '{$start}' AND '{$end}'"
                    )
                ),
                'ConfirmOrders' => array(
                    'conditions' => array(
                        "ConfirmOrders.created BETWEEN '{$start}' AND '{$end}'"
                    )
                ),
                'ReturnOrders' => array(
                    'conditions' => array(
                        "ReturnOrders.created BETWEEN '{$start}' AND '{$end}'"
                    )
                )

            )
        ));

        foreach ($users as &$user) {
            $user['total_orders']   = count($user['AssignedOrders']);
            $user['success_orders'] = count($user['SuccessOrders']);
            $user['confirm_orders'] = count($user['ConfirmOrders']);
            $user['cancel_orders']  = count($user['CancelOrders']);
            $user['return_orders']  = count($user['ReturnOrders']);

            $user['total_sales'] = 0;

            if ($user['total_orders'] > 0 ){
                foreach ($user['AssignedOrders'] as $order) {
                    if (in_array($order['status_id'], [5, 7])) {
                        $user['total_sales'] += $order['total_price'];
                    }

                }
            }
        }

        //log database
        $log =$this->Orders->getDatasource()->getLog();
        CakeLog::write('debug', print_r($log, true) );


        //return result
        return $users;
    }

    private function getOneUserOrders($data){
        $start_date = !empty($data['start_date']) ? $data['start_date'] : date('Y-m-01');
        $end_date = !empty($data['end_date']) ? $data['end_date'] : date('Y-m-d');

        $datesRanges = $this->getDatesRange($start_date,$end_date);

        $conditions = array();
        if (!empty($data['User']['id'])) {
            $conditions['User.id'] =  $data['User']['id'];
        }
        $this->User->Behaviors->load('Containable');

        $conditions['User.id'] =  68;
        $user_data = $this->User->find("first", array(
            'conditions' => $conditions,
            'contain' => array(
                'AssignedOrders' => array(
                    'conditions' => array(
                        "created BETWEEN '{$start_date}' AND '{$end_date}'"
                    )
                ),
            )
        ));

        //format orders
        $list_orders = [];
        foreach ($user_data['AssignedOrders'] as $index => $_order) {
            $_order['created'] = date("Y-m-d", strtotime($_order['created']));
            $list_orders[$index]['Orders'] = $_order;
        }

        $statuses = $this->getSystemStatuses();

        $data_dates = [];

        foreach ($datesRanges as $key => $date){
            $data_dates[$key]['date'] = $date;

            foreach ($statuses as $index => $status) {
                $data_dates[$key][ $index ]['name'] = $statuses[$index]['name'];
                $data_dates[$key][ $index ]['count'] =  $this->countStatusInOrderOnDate($index, $date, $list_orders);
                $data_dates[$key][ $index ]['total'] =  $this->countSalesInOrderOnDate($index, $date, $list_orders);
                $statuses[$index]['total'] += $this->countSalesInOrderOnDate($index, $date, $list_orders);
            }
        }

        var_dump( $data_dates );
        var_dump($statuses);
    }

    public function ordersCharts($query = null){
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
        $options ['conditions']['created >='] = date("Y")."-".date("m")."-01";
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

        $log =$this->Orders->getDatasource()->getLog();
        CakeLog::write('debug', print_r($log, true) );
    }

    public function ordersChartsByDates($query = null){
        $start_date = !empty($query['start_date']) ? $query['start_date'] : date('Y-m-01');
        $end_date = !empty($query['end_date']) ? $query['end_date'] : date('Y-m-d');
        $group_id = $this->_getGroup();

        $orders = $this->Orders->find('all', array(
            'conditions' => array(
                "DATE(Orders.created) BETWEEN '{$start_date}' AND '{$end_date}'",
                'Orders.group_id' => $group_id
            ),
            'fields' => array("Orders.status_id","Orders.created")
        ));


        $list_orders = array();
        foreach ($orders as $order) {
            $order['Orders']['created'] = date("Y-m-d", strtotime($order['Orders']['created']));
            $list_orders[] = $order;
        }

        $options ['conditions']['group_id IN'] = array(1, $group_id);
        $options['fields'] = array("id","name");
        $options['limit'] = 1000;
        $list_statues = $this->Statuses->find('list', $options);
        $list_statues['10'] = 'Chưa xác nhận';

        $datesRanges = $this->getDatesRange($start_date,$end_date);

        $data = array();
        $data['categories'] = $datesRanges;

        $counter = 0;
        foreach ($list_statues as $index => $value) {
            foreach ($datesRanges as $key => $date){
                $count = $this->countStatusInOrderOnDate($index, $date, $list_orders);
                $data['counter'][$counter]['data'][$key] = $count;
                //$data['data'][$index]['date'][$key] = $date;
            }
            $data['counter'][$counter]['name'] = $value;
            $counter ++;
        }

        //log database
        $log =$this->Orders->getDatasource()->getLog();
        CakeLog::write('debug', print_r($log, true) );

        return $data;
    }

    public function getDatesRange($start_date,$end_date){
        $begin = new DateTime( $start_date );
        $end = new DateTime( $end_date );
        $end = $end->modify( '+1 day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        $dates = array();
        foreach($daterange as $date){
            $dates[] = $date->format("Y-m-d");
        }
         return $dates;
    }

    function countStatusInOrderOnDate($status_id,$date, $orders){
        $count = 0;
        foreach ($orders as $order) {
            if ( $order['Orders']['status_id']==$status_id && $order['Orders']['created'] == $date){
                $count += 1;
            }
        }
        return $count;
    }

    function countSalesInOrderOnDate($status_id,$date, $orders){
        $count = 0;
        foreach ($orders as $order) {
            if ( $order['Orders']['status_id']==$status_id && $order['Orders']['created'] == $date){
                $count += $order['Orders']['total_price'];
            }
        }
        return $count;
    }


    function getSystemStatuses()
    {
        $list = array(

            7 => [
                    "name" =>"Xác Nhận",
                    "total" => 0
                ],
            9 => [
                    "name" =>"Hủy",
                    "total" => 0
                ],
            5 => [
                    "name" =>"Thành Công",
                    "total" => 0
            ],
            6 => [
                    "name" =>"Chuyển Hoàn",
                    "total" => 0
            ],

        );

        return $list;
    }
}
