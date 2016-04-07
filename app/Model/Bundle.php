<?php

App::uses('AppModel', 'Model');

class Bundle extends AppModel {

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
                'rule' => array('maxLength', 1),
                'message' => 'validate_name_max_lenght',
            ),
        ),
    );

}
