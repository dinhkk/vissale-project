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
/**
 * Display field
 *
 * @var string
 */


}
