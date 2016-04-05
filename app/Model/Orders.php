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
class Orders extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array (
			
	);
	
	// The Associations below have been created with all possible keys, those that are not needed can be removed
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array (
			'ShippingServices' => array (
					'className' => 'ShippingServices',
					'foreignKey' => 'shipping_service_id',
					'fields' => 'id,name'
			),
			'Statuses' => array (
					'className' => 'Statuses',
					'foreignKey' => 'status_id',
					'fields' => 'id,name'
			),
			'FBPosts' => array (
					'className' => 'FBPosts',
					'foreignKey' => 'fb_post_id',
					'fields' => 'id,post_id'
			),
			'FBPostComments' => array (
					'className' => 'FBPostComments',
					'foreignKey' => 'fb_comment_id',
					'fields' => 'id,comment_id'
			),
			'FBCustomers' => array (
					'className' => 'FBCustomers',
					'foreignKey' => 'fb_customer_id',
					'fields' => 'id,fb_id,phone,fb_name'
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
					'unique' => true,
					'fields' => 'id,name,bundle_id,code,color,size,price'
			) 
	);
}
