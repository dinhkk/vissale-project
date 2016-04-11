<?php

App::uses('AppController', 'Controller');

class StockReceivingsProductsController extends AppController {

    public $uses = array(
        'StockReceivingsProduct',
    );

    public function reqIndex($id = null) {

        $this->layout = 'ajax';
        $this->setInit();
        $this->Prg->commonProcess();
        $options = array();
        $options['conditions'] = $this->{$this->modelClass}->parseCriteria($this->Prg->parsedParams());
        $options['conditions']['stock_book_id'] = $id;
        $list_data = $this->{$this->modelClass}->find('all', $options);
        $this->set('list_data', $list_data);
    }

    protected function setInit() {

        $this->set('model_class', $this->modelClass);
    }

}
