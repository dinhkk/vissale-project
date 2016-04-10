<?php

App::uses('AppModel', 'Model');

class StockBooksProduct extends AppModel {

    public $actsAs = array(
        'Search.Searchable'
    );
    public $filterArgs = array(
        'product_alias' => array(
            'type' => 'like',
            'field' => 'product_alias'
        ),
        'qty' => array(
            'type' => 'value',
            'field' => 'qty'
        ),
        'total_price' => array(
            'type' => 'value',
            'field' => 'total_price'
        ),
        'stock_code' => array(
            'type' => 'like',
            'field' => 'stock_code'
        ),
    );

}
