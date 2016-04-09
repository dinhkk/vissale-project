<?php

App::uses('AppModel', 'Model');

class Unit extends AppModel {

    public $actsAs = array(
        'Search.Searchable'
    );
    public $filterArgs = array(
        'name' => array(
            'type' => 'like',
            'field' => 'name'
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
    );

}
