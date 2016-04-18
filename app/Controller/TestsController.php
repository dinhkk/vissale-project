<?php

App::uses('AppController', 'Controller');

class TestsController extends AppController {

    public function openingQty() {

        $this->loadModel('StockReceiving');
        $product_id = 10;
        $stock_id = 1;
        $begin_at = '2016-04-13';
        $receiving_qty = $this->StockReceiving->getOpeningQty($product_id, $stock_id, $begin_at);
        debug($receiving_qty);
        $this->render('empty');
    }

}
