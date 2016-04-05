<?php
App::uses ( 'AppModel', 'Model' );
/**
 * orders Model
 */
class FBPosts extends AppModel {
	public $useTable = 'fb_posts';
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
// 		'post_id' => array(
// 			'required' => array(
// 				'rule' => array('notEmpty')
// 			),
// 			'unique' => array(
// 				'rule' => 'isUnique'
// 			),
// 		)
		'product_id'=>array(
				'rule'=>'naturalNumber',
				'required' => true,
		),
		'post_id'=>'isUnique'
	);
	
	// The Associations below have been created with all possible keys, those that are not needed can be removed
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	//public $belongsTo = array (
// 			'Group' => array (
// 					'className' => 'Group',
// 					'foreignKey' => 'group_id'
// 			) 
	//);
	public $belongsTo = array(
			'Products' => array (
					'className' => 'Products',
					'foreignKey' => 'product_id' 
			),
			'Bundles' => array (
					'className' => 'Bundles',
					'foreignKey' => 'bundle_id'
			)
	);
}
