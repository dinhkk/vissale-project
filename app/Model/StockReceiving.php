<?php

App::uses('AppModel', 'Model');

class StockReceiving extends AppModel {

    const CODE_PATTERN = 'PN-%s-%s';

    public $actsAs = array(
        'Search.Searchable'
    );
    public $filterArgs = array(
        'code' => array(
            'type' => 'like',
            'field' => 'code'
        ),
        'description' => array(
            'type' => 'like',
            'field' => 'description'
        ),
        'received' => array(
            'type' => 'value',
            'field' => 'received'
        ),
        'stock_book_id' => array(
            'type' => 'value',
            'field' => 'stock_book_id'
        ),
        'stock_id' => array(
            'type' => 'value',
            'field' => 'stock_id'
        ),
        'supplier_id' => array(
            'type' => 'value',
            'field' => 'supplier_id'
        ),
        'note' => array(
            'type' => 'like',
            'field' => 'note'
        ),
    );
    public $validate = array(
        'no' => array(
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
        'description' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 500),
                'message' => 'validate_name_max_lenght',
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'received' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'stock_book_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'stock_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'supplier_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
    );

    public function getCode($date = null, $no = null) {
        if (empty($date)) {
            $date = date("Y-m-d");
        }
        $code_pattern = self::CODE_PATTERN;
        $code = sprintf($code_pattern, date('Ymd', strtotime($date)), str_pad($no, 4, '0', STR_PAD_LEFT));
        return $code;
    }

    public function getNo($date = null) {
        if (empty($date)) {
            $date = date("Y-m-d");
        }
        // lấy ra no lớn nhất của ngày hiện tại
        $get = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'received' => $date,
            ),
            'order' => array(
                'no' => 'DESC',
            ),
        ));
        $last_no = !empty($get) ? $get[$this->alias]['no'] : 0;
        $no = (int) $last_no + 1;
        return str_pad($no, 4, '0', STR_PAD_LEFT);
    }

    public function getOpeningQty($product_id, $stock_id, $begin_at) {

        $opts = array(
            'recursive' => -1,
            'joins' => array(
                array('table' => 'stock_receivings_products',
                    'alias' => 'StockReceivingsProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'StockReceivingsProduct.stock_receiving_id = StockReceiving.id',
                    )
                ),
            ),
            'conditions' => array(
                'StockReceivingsProduct.product_id' => $product_id,
                'StockReceiving.stock_id' => $stock_id,
                'StockReceiving.received <' => $begin_at,
            ),
            'fields' => array(
                'SUM(StockReceivingsProduct.qty) AS total_qty',
            ),
            'group' => array(
                'StockReceivingsProduct.product_id',
            ),
        );
        $get_total_qty = $this->find('first', $opts);
        $total_qty = !empty($get_total_qty) ?
                $get_total_qty[0]['total_qty'] : 0;
        return $total_qty;
    }

    public function getClosingQty($product_id, $stock_id, $end_at) {

        $opts = array(
            'recursive' => -1,
            'joins' => array(
                array('table' => 'stock_receivings_products',
                    'alias' => 'StockReceivingsProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'StockReceivingsProduct.stock_receiving_id = StockReceiving.id',
                    )
                ),
            ),
            'conditions' => array(
                'StockReceivingsProduct.product_id' => $product_id,
                'StockReceiving.stock_id' => $stock_id,
                'StockReceiving.received <=' => $end_at,
            ),
            'fields' => array(
                'SUM(StockReceivingsProduct.qty) AS total_qty',
            ),
            'group' => array(
                'StockReceivingsProduct.product_id',
            ),
        );
        $get_total_qty = $this->find('first', $opts);
        $total_qty = !empty($get_total_qty) ?
                $get_total_qty[0]['total_qty'] : 0;
        return $total_qty;
    }

    public function getQty($product_id, $stock_id, $begin_at, $end_at) {

        $opts = array(
            'recursive' => -1,
            'joins' => array(
                array('table' => 'stock_receivings_products',
                    'alias' => 'StockReceivingsProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'StockReceivingsProduct.stock_receiving_id = StockReceiving.id',
                    )
                ),
            ),
            'conditions' => array(
                'StockReceivingsProduct.product_id' => $product_id,
                'StockReceiving.stock_id' => $stock_id,
                'StockReceiving.received <=' => $end_at,
                'StockReceiving.received >=' => $begin_at,
            ),
            'fields' => array(
                'SUM(StockReceivingsProduct.qty) AS total_qty',
            ),
            'group' => array(
                'StockReceivingsProduct.product_id',
            ),
        );
        $get_total_qty = $this->find('first', $opts);
        $total_qty = !empty($get_total_qty) ?
                $get_total_qty[0]['total_qty'] : 0;
        return $total_qty;
    }

}
