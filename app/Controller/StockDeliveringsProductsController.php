<?php

App::uses('AppController', 'Controller');

class StockDeliveringsProductsController extends AppController {

    public $uses = array(
        'StockDeliveringsProduct',
        'Product',
    );

    public function reqIndex($id = null) {

        $this->layout = 'ajax';
        $this->setInit();
        $this->Prg->commonProcess();
        $options = array();
        $options['conditions'] = $this->{$this->modelClass}->parseCriteria($this->Prg->parsedParams());
        $options['conditions']['stock_delivering_id'] = $id;
        $list_data = $this->{$this->modelClass}->find('all', $options);
        $this->setProductInfo($list_data);
        $this->set('list_data', $list_data);

        $this->set('stock_delivering_id', $id);
    }

    protected function setProductInfo(&$list_data) {

        if (empty($list_data)) {
            return;
        }
        $products = array();
        foreach ($list_data as $k => $v) {
            $product_id = $v[$this->modelClass]['product_id'];
            if (empty($products[$product_id])) {
                $products[$product_id] = $this->Product->findById($product_id);
            }
            if (!empty($products[$product_id])) {
                $list_data[$k]['Product'] = $products[$product_id]['Product'];
            }
        }
    }

    public function reqAdd($id = null) {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $this->setInit();
            $this->set('stock_delivering_id', $id);
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

        $products = $this->Product->listByAlias();
        $this->set('products', $products);
    }

}
