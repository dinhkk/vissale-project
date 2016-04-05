<?php
App::uses ( 'AppModel', 'Model' );
/**
 * orders Model
 * */
class OrderRevision extends AppModel {
	public $useTable = 'order_revisions';
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
			
	);
}
