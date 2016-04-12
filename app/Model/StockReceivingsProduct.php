<?php

App::uses('AppModel', 'Model');

class StockReceivingsProduct extends AppModel {

    public $actsAs = array(
        'Search.Searchable'
    );
    public $filterArgs = array(
        'product_code' => array(
            'type' => 'like',
            'field' => 'product_code'
        ),
        'product_alias' => array(
            'type' => 'like',
            'field' => 'product_alias'
        ),
        'product_name' => array(
            'type' => 'like',
            'field' => 'product_name'
        ),
        'product_color' => array(
            'type' => 'like',
            'field' => 'product_color'
        ),
        'product_size' => array(
            'type' => 'like',
            'field' => 'product_size'
        ),
        'qty' => array(
            'type' => 'value',
            'field' => 'qty'
        ),
        'price' => array(
            'type' => 'value',
            'field' => 'price'
        ),
        'total_price' => array(
            'type' => 'value',
            'field' => 'total_price'
        ),
    );
    public $validate = array(
        'product_id' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'qty' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'price' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'total_price' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['product_id'])) {
            $product_id = $this->data[$this->alias]['product_id'];
            App::uses('Product', 'Model');
            $Product = new Product();
            $product = $Product->findById($product_id);
            if (empty($product)) {
                throw new NotImplementedException(__('product with id=%s does not exists.', $product_id));
            }
            $this->data[$this->alias]['product_code'] = $product[$Product->alias]['code'];
            $this->data[$this->alias]['product_alias'] = $product[$Product->alias]['alias'];
            $this->data[$this->alias]['product_name'] = $product[$Product->alias]['name'];
            $this->data[$this->alias]['product_color'] = $product[$Product->alias]['color'];
            $this->data[$this->alias]['product_size'] = $product[$Product->alias]['size'];
        }
        if (isset($this->data[$this->alias]['price']) && isset($this->data[$this->alias]['qty'])) {
            $this->data[$this->alias]['total_price'] = (int) $this->data[$this->alias]['price'] * (int) $this->data[$this->alias]['qty'];
        }
    }

}
