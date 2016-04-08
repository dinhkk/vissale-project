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
class FBConversationMessage extends AppModel {
	public $useTable = 'fb_conversation_messages';
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
