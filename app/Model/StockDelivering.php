<?php

App::uses('AppModel', 'Model');

class StockDelivering extends AppModel {

    const CODE_PATTERN = 'PX-%s-%s';

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
        'delivered' => array(
            'type' => 'value',
            'field' => 'delivered'
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
        'delivered' => array(
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
                'delivered' => $date,
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
                array('table' => 'stock_deliverings_products',
                    'alias' => 'StockDeliveringsProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'StockDeliveringsProduct.stock_delivering_id = StockDelivering.id',
                    )
                ),
            ),
            'conditions' => array(
                'StockDeliveringsProduct.product_id' => $product_id,
                'StockDelivering.stock_id' => $stock_id,
                'StockDelivering.delivered <' => $begin_at,
            ),
            'fields' => array(
                'SUM(StockDeliveringsProduct.qty) AS total_qty',
            ),
            'group' => array(
                'StockDeliveringsProduct.product_id',
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
                array('table' => 'stock_deliverings_products',
                    'alias' => 'StockDeliveringsProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'StockDeliveringsProduct.stock_delivering_id = StockDelivering.id',
                    )
                ),
            ),
            'conditions' => array(
                'StockDeliveringsProduct.product_id' => $product_id,
                'StockDelivering.stock_id' => $stock_id,
                'StockDelivering.delivered <=' => $end_at,
            ),
            'fields' => array(
                'SUM(StockDeliveringsProduct.qty) AS total_qty',
            ),
            'group' => array(
                'StockDeliveringsProduct.product_id',
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
                array('table' => 'stock_deliverings_products',
                    'alias' => 'StockDeliveringsProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'StockDeliveringsProduct.stock_delivering_id = StockDelivering.id',
                    )
                ),
            ),
            'conditions' => array(
                'StockDeliveringsProduct.product_id' => $product_id,
                'StockDelivering.stock_id' => $stock_id,
                'StockDelivering.delivered <=' => $end_at,
                'StockDelivering.delivered >=' => $begin_at,
            ),
            'fields' => array(
                'SUM(StockDeliveringsProduct.qty) AS total_qty',
            ),
            'group' => array(
                'StockDeliveringsProduct.product_id',
            ),
        );
        $get_total_qty = $this->find('first', $opts);
        $total_qty = !empty($get_total_qty) ?
                $get_total_qty[0]['total_qty'] : 0;
        return $total_qty;
    }

}
