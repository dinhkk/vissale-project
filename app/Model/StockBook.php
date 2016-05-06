<?php

App::uses('AppModel', 'Model');

class StockBook extends AppModel {

    public $actsAs = array(
        'Search.Searchable'
    );
    public $filterArgs = array(
        'name' => array(
            'type' => 'like',
            'field' => 'name'
        ),
        'code' => array(
            'type' => 'like',
            'field' => 'code'
        ),
        'begin_at' => array(
            'type' => 'value',
            'field' => 'begin_at'
        ),
        'end_at' => array(
            'type' => 'value',
            'field' => 'end_at'
        ),
        'is_locked' => array(
            'type' => 'value',
            'field' => 'is_locked'
        ),
    );
    public $validate = array(
        'name' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'code' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'begin_at' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'end_at' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
    );

    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);

        if ($created) {
            // thực hiện khóa lại các kỳ khác
            $this->updateAll(array('is_locked' => 1), array('id !=' => $this->id));

            App::uses('StockBooksProduct', 'Model');
            App::uses('StocksProduct', 'Model');
            $StockBooksProduct = new StockBooksProduct();
            $StockBooksProduct->deleteAll(array(
                'stock_book_id' => $this->id,
                    ), false);
            $StocksProduct = new StocksProduct();
            $stocks_product = $StocksProduct->find('all');
            if (empty($stocks_product)) {
                return true;
            }
            $save_data = array();
            foreach ($stocks_product as $v) {
                $save_data[] = array(
                    'stock_book_id' => $this->id,
                    'stock_id' => $v[$StocksProduct->alias]['stock_id'],
                    'stock_code' => $v[$StocksProduct->alias]['stock_code'],
                    'product_id' => $v[$StocksProduct->alias]['product_id'],
                    'product_code' => $v[$StocksProduct->alias]['product_code'],
                    'product_alias' => $v[$StocksProduct->alias]['product_alias'],
                    'qty' => $v[$StocksProduct->alias]['qty'],
                    'price' => $v[$StocksProduct->alias]['price'],
                    'total_price' => $v[$StocksProduct->alias]['total_price'],
                );
            }
            $StockBooksProduct->saveAll($save_data);
        }
    }

    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);

        if (isset($this->data[$this->alias]['begin_at']) && isset($this->data[$this->alias]['end_at'])) {
            if ($this->data[$this->alias]['begin_at'] > $this->data[$this->alias]['end_at']) {
                $this->validationErrors['begin_at'][] = __('validate_begin_end');
                return false;
            }
        }
    }

    public function getActive() {

        return $this->find('list', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'is_locked' => 0,
                    ),
        ));
    }

}
