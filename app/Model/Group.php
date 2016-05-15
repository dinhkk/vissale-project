<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 * @property FbUser $FbUser
 * @property BillingPrint $BillingPrint
 * @property Bundle $Bundle
 * @property FbBlacklist $FbBlacklist
 * @property FbConversation $FbConversation
 * @property FbConversationMessage $FbConversationMessage
 * @property FbCronConfig $FbCronConfig
 * @property FbCustomer $FbCustomer
 * @property FbPage $FbPage
 * @property FbPostComment $FbPostComment
 * @property FbPost $FbPost
 * @property Order $Order
 * @property Product $Product
 * @property Role $Role
 * @property ShippingService $ShippingService
 * @property Status $Status
 * @property StockBook $StockBook
 * @property StockDelivering $StockDelivering
 * @property StockReceiving $StockReceiving
 * @property Stock $Stock
 * @property Supplier $Supplier
 * @property Unit $Unit
 * @property User $User
 */
class Group extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(

	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'BillingPrint' => array(
			'className' => 'BillingPrint',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Bundle' => array(
			'className' => 'Bundle',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		/*'FbBlacklist' => array(
			'className' => 'FbBlacklist',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),*/
		/*'FbConversation' => array(
			'className' => 'FbConversation',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),*/
		'FbConversationMessage' => array(
			'className' => 'FbConversationMessage',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'FBCronConfig' => array(
			'className' => 'FBCronConfig',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'FbCustomer' => array(
			'className' => 'FbCustomer',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'FbPage' => array(
			'className' => 'FbPage',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'FbPostComment' => array(
			'className' => 'FbPostComment',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'FbPost' => array(
			'className' => 'FbPost',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ShippingService' => array(
			'className' => 'ShippingService',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'StockBook' => array(
			'className' => 'StockBook',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'StockDelivering' => array(
			'className' => 'StockDelivering',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'StockReceiving' => array(
			'className' => 'StockReceiving',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Stock' => array(
			'className' => 'Stock',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Supplier' => array(
			'className' => 'Supplier',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Unit' => array(
			'className' => 'Unit',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function beforeSave($options = array()) {
		
		if ( !empty($this->data[$this->alias]['id']) ) {
			unset( $this->data[$this->alias]['code'] );
		}
		return true;
	}

	public function afterSave($created, $options = array()){
		parent::afterSave($created,$options);

		if ($created){
			$this->copySystemData();
		}
		return true;
	}

	protected function copySystemData(){
		$dataSource = $this->getDataSource();
		$dataSource->begin();
		$flag = true;
		//
		$save = $this->query("INSERT INTO `fb_cron_config`(group_id,_key,type,description,value,level, parent_id)
				SELECT {$this->id},_key,type,description,value,level,1 FROM `fb_cron_config`  where `group_id` = 1");
		if (!$save) $flag = false;

		$save = $this->query("INSERT INTO `roles`(group_id,level,name,description,data,parent_id)
				SELECT {$this->id},level,name,description,data,1 FROM `roles`  where `group_id` = 1 AND `level` <=100");
		if (!$save) $flag = false;

		$UserModel = ClassRegistry::init('User');
		$user['username'] 	= $this->data[$this->alias]['code'];
		$user['name'] 		= $this->data[$this->alias]['name'];
		$user['phone'] 		= $this->data[$this->alias]['phone'];
		$user['address'] 	= $this->data[$this->alias]['address'];
		$user['level'] 		= 100;
		$user['group_id'] 	= $this->id;

		$save = $UserModel->save($user);
		if (!$save) $flag = false;

		if ($flag) $dataSource->commit();
		if (!$flag) $dataSource->rollback();
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'code' => array(
			//'rule' => 'isUnique',
			//'message' => 'This username has already been taken.'
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Already taken.'
			),
			'username' => array(
				'rule' => 'alphaNumericDashUnderscore',
				'required' => true,
				'message' => 'Letters and numbers only'
			),
			'between' => array(
				'rule' => array('lengthBetween', 5, 40),
				'message' => 'Must lengthen between 5 and 40 characters.'
			)
		),
		'phone' => array(
			'rule' => 'isUnique',
			'message' => 'This phone has already been taken.'
		)
	);
	
}
