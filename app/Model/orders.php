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
class orders extends AppModel {
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
			),
			'FbPage' => array (
					'className' => 'FbPage',
					'foreignKey' => 'fb_page_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			),
			'FbComment' => array (
					'className' => 'FbComment',
					'foreignKey' => 'fb_comment_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			),
			'ShippingService' => array (
					'className' => 'ShippingService',
					'foreignKey' => 'shipping_service_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			),
			'Statuses' => array (
					'className' => 'Statuses',
					'foreignKey' => 'status_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			),
			'Duplicate' => array (
					'className' => 'Duplicate',
					'foreignKey' => 'duplicate_id',
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
					'foreignKey' => 'order_id',
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
