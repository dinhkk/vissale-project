<?php

App::uses('AppModel', 'Model');

/**
 * orders Model
 *
 * @property Group $Group
 * @property FbCustomer $FbCustomer
 * @property FbPage $FbPage
 * @property FbPost $FbPost
 * @property FbComment $FbComment
 * @property ShippingService $ShippingService
 * @property Bundle $Bundle
 * @property Status $Status
 * @property Duplicate $Duplicate
 * @property Product $Product
 */
class Status extends AppModel {

    public $useTable = 'statuses';
    public $actsAs = array('Search.Searchable');
    public $filterArgs = array(
        'name' => array(
            'type' => 'like',
            'field' => 'name'
        ),
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(
            'notBlank' => array(
                'rule' => array(
                    'notBlank'
                )
            )
        // 'message' => 'Your custom message here',
        // 'allowEmpty' => false,
        // 'required' => false,
        // 'last' => false, // Stop validation after this rule
        // 'on' => 'create', // Limit validation to 'create' or 'update' operations
        )
    );

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
// 			'Group' => array (
// 					'className' => 'Group',
// 					'foreignKey' => 'group_id'
// 			) 
    );

    public function beforeFind($query) {
        parent::beforeFind($query);

        return true;
    }

    /**
     * getSystemStatus
     * Lấy ra danh sách các trạng thái cố định của hệ thống
     */
    public function getSystemStatus() {

        return $this->find('list', array(
                    'recursive' => -1,
                    'fields' => array(
                        'id', 'name',
                    ),
                    'conditions' => array(
                        'is_system' => 1,
                    ),
        ));
    }

}
