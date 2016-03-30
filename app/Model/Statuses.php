<?php
App::uses ( 'AppModel', 'Model' );
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
class Statuses extends AppModel {
	public $useTable = 'statuses';
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array (
			'code' => array (
					'notBlank' => array (
							'rule' => array (
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
	public $belongsTo = array (
			'Group' => array (
					'className' => 'Group',
					'foreignKey' => 'group_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			) 
	);
	
	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array (
			'Product' => array (
					'className' => 'Product',
					'joinTable' => 'orders_products',
					'foreignKey' => 'orders_id',
					'associationForeignKey' => 'product_id',
					'unique' => 'keepExisting',
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'finderQuery' => '' 
			) 
	);
}
