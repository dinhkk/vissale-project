<?php

App::uses('AppController', 'Controller');

class StockReceivingsController extends AppController {

    public $uses = array(
        'StockReceiving',
        'Stock',
        'StockBook',
        'Supplier',
    );

    public function index() {

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
        $this->setInit();
        $page_title = __('stock_receiving_title');
        $this->set('page_title', $page_title);

        $breadcrumb = array();
        $breadcrumb[] = array(
            'title' => __('home_title'),
            'url' => Router::url(array('controller' => 'DashBoard', 'action' => 'index'))
        );
        $breadcrumb[] = array(
            'title' => __('stock_receiving_title'),
            'url' => Router::url(array('action' => $this->action)),
        );
        $this->set('breadcrumb', $breadcrumb);

        $options = array(
            'order' => array(
                'modified' => 'DESC',
            ),
        );
        $options['recursive'] = -1;
        $page = $this->request->query('page');
        if (!empty($page)) {
            $options['page'] = $page;
        }
        $limit = $this->request->query('limit');
        if (!empty($limit)) {
            $options['limit'] = $limit;
        }
        $this->Prg->commonProcess();
        $options['conditions'] = $this->{$this->modelClass}->parseCriteria($this->Prg->parsedParams());
        $options ['conditions'] ['group_id'] = $this->_getGroup ();
        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate();
        $this->set('list_data', $list_data);

        $no = $this->{$this->modelClass}->getNo();
        $this->set('no', $no);

        // thực hiện tự tạo ra code
        $code = $this->{$this->modelClass}->getCode(null, $no);
        $this->set('code', $code);
    }

    public function reqAdd() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $this->setInit();
            
            $no = $this->{$this->modelClass}->getNo();
            $this->set('no', $no);

            // thực hiện tự tạo ra code
            $code = $this->{$this->modelClass}->getCode(null, $no);
            $this->set('code', $code);
            
            $res = array();
            $save_data = $this->request->data;
            if ($this->{$this->modelClass}->save($save_data)) {
                $res['error'] = 0;
                $res['data'] = null;
                echo json_encode($res);
            } else {
                $res['error'] = 1;
                $res['data'] = array(
                    'validationErrors' => $this->{$this->modelClass}->validationErrors,
                );
                $this->layout = 'ajax';
                $this->set('model_class', $this->modelClass);
                $render = $this->render('req_add');
                $res['data']['html'] = $render->body();
                echo json_encode($res);
                exit();
            }
        }
    }

    public function reqEdit($id = null) {

        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $this->setInit();
            $res = array();
            $save_data = $this->request->data;
            if ($this->{$this->modelClass}->save($save_data)) {
                $res['error'] = 0;
                $res['data'] = null;
            } else {
                $res['error'] = 1;
                $res['data'] = array(
                    'validationErrors' => $this->{$this->modelClass}->validationErrors,
                );
                $this->layout = 'ajax';
                $this->set('model_class', $this->modelClass);
                $this->set('id', $id);
                $render = $this->render('req_edit');
                $res['data']['html'] = $render->body();
                echo json_encode($res);
                exit();
            }
            echo json_encode($res);
        }
    }

    public function reqDelete($id = null) {

        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $res = array();
            if ($this->{$this->modelClass}->delete($id)) {
                $res['error'] = 0;
                $res['data'] = null;
            } else {
                $res['error'] = 1;
                $res['data'] = null;
            }
            echo json_encode($res);
        }
    }

    protected function setInit() {

        $this->set('model_class', $this->modelClass);

        $stock_books = $this->StockBook->getActive();
        $this->set('stock_books', $stock_books);

        $stocks = $this->Stock->find('list');
        $this->set('stocks', $stocks);

        $suppliers = $this->Supplier->find('list');
        $this->set('suppliers', $suppliers);
    }

}
