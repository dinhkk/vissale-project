<?php

App::uses('AppModel', 'Model');

/**
 * Role Model
 *
 */
class Role extends AppModel {

    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        'name' => array(
            'type' => 'like',
            'field' => 'name'
        ),
        'type' => array(
            'type' => 'value',
            'field' => 'type'
        ),
        'status' => array(
            'type' => 'value',
            'field' => 'status'
        ),
        'description' => array(
            'type' => 'like',
            'field' => 'description'
        ),
    );
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_created',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
