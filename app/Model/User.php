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

    /**
     * sync
     * Thực hiện đồng bộ toàn bộ user mỗi khi role cha bị thay đổi về quyền, hoặc status
     * 
     * @param int $role_id
     * @return boolean
     */
    public function sync($role_id) {

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
            $perms_level = $this->getPermsLevel($v);
            $save_data[] = array(
                'id' => $v,
                'data' => $perms_level['data'],
                'level' => $perms_level['level'],
            );
        }
        return $this->saveAll($save_data);
    }

    /**
     * getPermsLevel
     * Cập nhật lại quyền và level của user, dựa vào user đang thuộc những role nào
     * 
     * @param int $id
     * @param array $role_ids
     * @return array
     */
    public function getPermsLevel($id, $role_ids = array()) {

        $result = array(
            'level' => ZEROLEVEL,
            'data' => null,
        );
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
                'status' => STATUS_ACTIVE,
            ),
        ));
        if (empty($roles)) {
            return $result;
        }
        $perms = array(
            'perm_id' => array(),
            'perm_code' => array(),
            'status_id' => array(),
        );
        $levels = array();
        foreach ($roles as $v) {
            if (empty($v[$Role->alias]['data'])) {
                continue;
            }
            if (!empty($v[$Role->alias]['level'])) {
                $levels[] = $v[$Role->alias]['level'];
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

        $result['data'] = json_encode($perms);
        $result['level'] = max($levels);

        return $result;
    }

}
