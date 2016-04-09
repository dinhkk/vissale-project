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
class Chat extends AppModel {
	public $useTable = 'fb_conversation';
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array (
	);
	
	// The Associations below have been created with all possible keys, those that are not needed can be removed
}
