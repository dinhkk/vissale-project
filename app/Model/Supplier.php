<?php

App::uses('AppModel', 'Model');

class Supplier extends AppModel {

    public $actsAs = array(
        'Search.Searchable'
    );
    public $filterArgs = array(
        'name' => array(
            'type' => 'like',
            'field' => 'name'
        ),
        'phone' => array(
            'type' => 'like',
            'field' => 'phone'
        ),
        'note' => array(
            'type' => 'like',
            'field' => 'note'
        ),
        'address' => array(
            'type' => 'like',
            'field' => 'address'
        ),
        'tax_code' => array(
            'type' => 'like',
            'field' => 'tax_code'
        ),
        'email' => array(
            'type' => 'like',
            'field' => 'email'
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
        'phone' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
        ),
        'note' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 500),
                'message' => 'validate_name_max_lenght',
            ),
        ),
        'address' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
        ),
        'tax_code' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
        ),
        'email' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'validate_email',
                'allowEmpty' => true,
            ),
        ),
    );

}
