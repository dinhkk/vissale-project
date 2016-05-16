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

    public function makePassword() {
        $this->autoRender = false;
        App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
        $password = $this->request->query('password');
        debug($password);
        $passwordHasher = new BlowfishPasswordHasher();
        $hash_password = $passwordHasher->hash($password);
        debug($hash_password);
    }

    public function role() {
        $this->loadModel('Role');
        $roles = $this->Role->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'group_id' => GROUP_SYSTEM_ID,
                'level <= ' . ADMINGROUP,
            ),
        ));
        debug($roles);
        $this->render('empty');
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

}
