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
    public $validate = array(
        'username' => array(
            //'rule' => 'isUnique',
            //'message' => 'This username has already been taken.'
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => 'Already taken.'
            ),
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
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
    /* public $hasAndBelongsToMany = array(
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
      ); */

    public $hasMany = array(
        'UsersRole' => array(
            'className' => 'UsersRole',
            'foreignKey' => 'user_id',
        )
    );

    public function sync($role_id, $status) {

        $user_ids = $this->UsersRole->find('list', array(
            'recursive' => -1,
            'conditions' => array(
                'role_id' => $role_id,
            ),
            'fields' => array(
                'id', 'user_id',
            ),
        ));
        if (empty($user_ids)) {
            return true;
        }
        $save_data = array();
        foreach ($user_ids as $v) {
            $save_data[] = array(
                'id' => $v,
                'status' => $status,
                'data' => $this->getPerms($v),
            );
        }
        return $this->saveAll($save_data);
    }

    public function getPerms($id, $role_ids = array()) {

        if (empty($role_ids)) {
            $role_ids = $this->UsersRole->find('list', array(
                'recursive' => -1,
                'conditions' => array(
                    'user_id' => $id,
                ),
                'fields' => array(
                    'id', 'role_id',
                ),
            ));
        }
        App::uses('Role', 'Model');
        $Role = new Role();
        $roles = $Role->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => array_values($role_ids),
            ),
        ));
        if (empty($roles)) {
            return null;
        }
        $perms = array(
            'perm_id' => array(),
            'perm_code' => array(),
            'status_id' => array(),
        );
        foreach ($roles as $v) {
            if (empty($v[$Role->alias]['data'])) {
                continue;
            }
            $data = json_decode($v[$Role->alias]['data'], true);
            if (empty($data)) {
                continue;
            }
            if (!empty($data['perm_id'])) {
                $perms['perm_id'] = array_merge($data['perm_id'], $perms['perm_id']);
            }
            if (!empty($data['perm_code'])) {
                $perms['perm_code'] = array_merge($data['perm_code'], $perms['perm_code']);
            }
            if (!empty($data['status_id'])) {
                $perms['status_id'] = array_merge($data['status_id'], $perms['status_id']);
            }
        }
        $perms['perm_id'] = array_unique($perms['perm_id']);
        $perms['perm_code'] = array_unique($perms['perm_code']);
        $perms['status_id'] = array_unique($perms['status_id']);

        return json_encode($data);
    }

}
