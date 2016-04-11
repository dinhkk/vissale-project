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

    public function getCode($date = null) {
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
        $code_pattern = self::CODE_PATTERN;
        if (empty($get)) {
            $code = sprintf($code_pattern, date('Ymd', strtotime($date)), '0001');
        } else {
            $no = (int) $get[$this->alias]['no'] + 1;
            $code = sprintf($code_pattern, date('Ymd', strtotime($date)), str_pad($no, 4, '0', STR_PAD_LEFT));
        }
        return $code;
    }

}
