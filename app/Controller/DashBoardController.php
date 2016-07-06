<?php

App::uses('AppController', 'Controller');
App::uses('BaseLog', 'Log/Engine');

class DashBoardController extends AppController {

    public $uses = array('Statuses','Orders','User');
    public $components = array("Dompdf");
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
        $this->exportPdfUsers();

        $log =$this->Orders->getDatasource()->getLog();
        CakeLog::write('debug', print_r($log, true) );
        die;
    }

    public function exportPdfUsers(){
        $view = new View($this,false);
        $view->viewPath='Elements';
        $view->layout=false;

        $users = $data = $this->getUsersOrders( $this->resquest );

        $view->set('page_title', "Tổng hợp doanh số tất cả nhân viên");
        $view->set('users', $users);


        $html=$view->render('users_sale_report');

        //
        $dompdf = $this->Dompdf->getInstance();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("bao_cao_doanh_so");
    }

    private function getUsersOrders($query){
        $users = $this->User->find("all", array(

        ));

        foreach ($users as &$user) {
            $user['total_orders'] = count($user['AssignedOrders']);
            $user['total_sales'] = 0;

            if ($user['total_orders'] > 0){
                foreach ($user['AssignedOrders'] as $order) {
                    $user['total_sales'] += $order['total_price'];
                }
            }
        }

        return $users;
    }

    private function getOneUserOrders($query){

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

        $log =$this->Orders->getDatasource()->getLog();
        CakeLog::write('debug', print_r($log, true) );

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
}
