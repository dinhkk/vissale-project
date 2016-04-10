<?php

App::uses('AppController', 'Controller');

class StockBooksProductsController extends AppController {

    public $uses = array(
        'StockBooksProduct',
    );

    public function reqIndex($id = null) {

        $this->layout = 'ajax';
        $this->setInit();
        $list_data = $this->{$this->modelClass}->findAllByStockBookId($id);
        $this->set('list_data', $list_data);
    }

    protected function setInit() {

        $this->set('model_class', $this->modelClass);
    }

}
