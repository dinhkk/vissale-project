<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Group $Group
 * @property Product $Product
 * @property Role $Role
 */


App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {

	public $actsAs = array('Search.Searchable');

	public $filterArgs = array(
		'name' => array(
			'type' => 'like',
			'field' => 'name'
		),
	);

	public function beforeSave($options = array()) {
		parent::beforeSave($options);

		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}
	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	
	public $validate = array (
		'username' => array(
			'rule' => 'isUnique',
			'message' => 'This username has already been taken.'
		),
		'phone' => array(
			'rule' => 'isUnique',
			'message' => 'This phone has already been taken.'
		)
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
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
	public $hasAndBelongsToMany = array(
		'Role' => array(
			'className' => 'Role',
			'joinTable' => 'users_roles',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'role_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
