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
class ShippingServices extends AppModel {
	public $useTable = 'shipping_services';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
// 		'Group' => array(
// 			'className' => 'Group',
// 			'foreignKey' => 'group_id'
// 		)
	);

}
