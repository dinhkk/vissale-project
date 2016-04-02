<?php
App::uses ( 'AppModel', 'Model' );
/**
 * orders Model
 * */
class OrderProducts extends AppModel {
	public $useTable = 'orders_products';
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
// 			'Group' => array (
// 					'className' => 'Group',
// 					'foreignKey' => 'group_id'
// 			) 
	);
}
