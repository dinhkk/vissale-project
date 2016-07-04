<?php

App::uses('AppModel', 'Model');

/**
 * Role Model
 *
 */
class Role extends AppModel {

    public $actsAs = array('Search.Searchable', 'Containable');
    public $filterArgs = array(
        'name' => array(
            'type' => 'like',
            'field' => 'name'
        ),
        'type' => array(
            'type' => 'value',
            'field' => 'type'
        ),
        'status' => array(
            'type' => 'value',
            'field' => 'status'
        ),
        'description' => array(
            'type' => 'like',
            'field' => 'description'
        ),
        'group_id' => array(
            'type' => 'value',
            'field' => 'group_id'
        ),
        'parent_id' => array(
            'type' => 'value',
            'field' => 'parent_id'
        ),
    );
    public $hasMany = array(
        'RolesPerm' => array(
            'className' => 'RolesPerm',
        ),
        'RolesStatus' => array(
            'className' => 'RolesStatus',
        ),
        'User' => array(
            'className' => 'User',
        ),
    );
    public $belongsTo = array(
        'Group' => array(
            'className' => 'Group',
        ),
    );
    public $validate = array(
        'name' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
    );

    public $disable_group_id = 1;

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['enable_print_perm'])) {
            if (!empty($this->data[$this->alias]['enable_print_perm'])) {
                $this->data[$this->alias]['perm_id'][] = PRINT_PERM_ID;
            } elseif (($key = array_search(PRINT_PERM_ID, $this->data[$this->alias]['perm_id'])) !== false) {
                unset($this->data[$this->alias]['perm_id'][$key]);
                $this->data[$this->alias]['perm_id'] = array_values($this->data[$this->alias]['perm_id']);
            }
        }
        if (isset($this->data[$this->alias]['enable_export_exel_perm'])) {
            if (!empty($this->data[$this->alias]['enable_print_perm'])) {
                $this->data[$this->alias]['perm_id'][] = EXPORT_EXEL_PERM_ID;
            } elseif (($key = array_search(EXPORT_EXEL_PERM_ID, $this->data[$this->alias]['perm_id'])) !== false) {
                unset($this->data[$this->alias]['perm_id'][$key]);
                $this->data[$this->alias]['perm_id'] = array_values($this->data[$this->alias]['perm_id']);
            }
        }
        if (isset($this->data[$this->alias]['perm_id']) && !isset($this->data[$this->alias]['status_id'])) {
            throw new NotImplementedException(__('Không thực hiện lưu khi cả 2 trường perm_id và status_id không xuất hiện cùng lúc'));
        }
        if (isset($this->data[$this->alias]['status_id']) && !isset($this->data[$this->alias]['perm_id'])) {
            throw new NotImplementedException(__('Không thực hiện lưu khi cả 2 trường perm_id và status_id không xuất hiện cùng lúc'));
        }
        if (isset($this->data[$this->alias]['perm_id']) && isset($this->data[$this->alias]['status_id'])) {
            // thực hiện cache các quyền hạn của roles trong trường data
            App::uses('Perm', 'Model');
            $Perm = new Perm();
            $perm_codes = $Perm->find('list', array(
                'recursive' => -1,
                'fields' => array(
                    'id', 'code',
                ),
                'conditions' => array(
                    'id' => $this->data[$this->alias]['perm_id'],
                ),
            ));
            if (empty($perm_codes)) {
                throw new NotImplementedException(__('Không tồn tại dữ liệu trong bảng perms'));
            }
            $data = array();
            $data['perm_id'] = array_keys($perm_codes);
            $data['perm_code'] = array_values($perm_codes);
            $data['status_id'] = $this->data[$this->alias]['status_id'];
            $this->data[$this->alias]['data'] = json_encode($data);
        }
    }

    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);

        if (isset($this->data[$this->alias]['perm_id'])) {
            // lưu lại quan hệ giữa roles và perms
            $this->RolesPerm->deleteAll(array(
                'RolesPerm.role_id' => $this->id,
                    ), false);
        }
        if (!empty($this->data[$this->alias]['perm_id'])) {
            $save_data = array();
            foreach ($this->data[$this->alias]['perm_id'] as $v) {
                $save_data[] = array(
                    'role_id' => $this->id,
                    'perm_id' => $v,
                );
            }
            $this->RolesPerm->saveAll($save_data);
        }
        if (isset($this->data[$this->alias]['status_id'])) {
            // lưu lại quan hệ giữa roles và statuses
            $this->RolesStatus->deleteAll(array(
                'RolesStatus.role_id' => $this->id,
                    ), false);
        }
        if (!empty($this->data[$this->alias]['status_id'])) {
            $save_data = array();
            foreach ($this->data[$this->alias]['status_id'] as $v) {
                $save_data[] = array(
                    'role_id' => $this->id,
                    'status_id' => $v,
                );
            }
            $this->RolesStatus->saveAll($save_data);
        }
        // khi có thay đổi quyền của role, thì đồng thời update lại quyền hạn của các  user thuộc role
        if (
                isset($this->data[$this->alias]['perm_id']) ||
                isset($this->data[$this->alias]['status_id']) ||
                isset($this->data[$this->alias]['status']) ||
                isset($this->data[$this->alias]['level'])
        ) {
            $this->User->sync($this->id);
        }

        // thực hiện tìm kiếm toàn bộ role clone để update lại quyền
        if (
                isset($this->data[$this->alias]['perm_id']) && isset($this->data[$this->alias]['status_id'])
        ) {
            $role_children = $this->find('all', array(
                'recursive' => -1,
                'conditions' => array(
                    'parent_id' => $this->id,
                ),
            ));
            if (empty($role_children)) {
                return true;
            }
            $save_data = array();
            foreach ($role_children as $v) {
                $save_data[] = array(
                    'id' => $v[$this->alias]['id'],
                    'status_id' => $this->data[$this->alias]['status_id'],
                    'perm_id' => $this->data[$this->alias]['perm_id'],
                    'group_id' => $v[$this->alias]['group_id'],
                );
            }
            $this->saveAll($save_data);
        } elseif (isset($this->data[$this->alias]['data'])) {
            $this->sync($this->id);
        }

        return true;
    }

    protected function sync($role_id) {

        $roles = $this->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'parent_id' => $role_id,
            ),
        ));
        if (empty($roles)) {
            return true;
        }
        $save_data = array();
        foreach ($roles as $v) {
            $data = json_decode($this->data[$this->alias]['data'], true);
            $perm_id = !empty($data['perm_id']) ? $data['perm_id'] : array();
            $status_id = !empty($data['status_id']) ? $data['status_id'] : array();
            $save_data[] = array(
                'id' => $v[$this->alias]['id'],
                'data' => $this->data[$this->alias]['data'],
//                'status' => $v[$this->alias]['status'],
                'group_id' => $v[$this->alias]['group_id'],
                'perm_id' => $perm_id,
                'status_id' => $status_id,
            );
        }
        return $this->saveAll($save_data);
    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        $level = CakeSession::read('Auth.User.level');
        if (empty($level)) {
            $this->User->sync($this->id);
            return true;
        }
        if ($level >= ADMINSYSTEM) {
            $this->User->sync($this->id);
            return true;
        }
        // Thực hiện kiểm tra, nếu level của user không phải là hệ thống, thì không được phép xóa các role của hệ thống
        $role = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $this->id,
            ),
        ));
        if (empty($role)) {
            throw new NotImplementedException(__('Không thực hiện xóa được role do role không tồn tại'));
        }
        // Nếu role thuộc role của hệ thống thì không cho phép xóa
        $is_system = $role[$this->alias]['is_system'];
        if (!empty($is_system)) {
            return false;
        }
        $this->User->sync($this->id);
        return true;
    }

    public function getByGroupIdLevel($group_id, $level = ADMINGROUP) {

        return $this->find('first', array(
                    'recursive' => -1,
                    'conditions' => array(
                        'group_id' => $group_id,
                        'level' => $level,
                    ),
        ));
    }

    public function getRoleForClone() {

        $this->Behaviors->disable('Level');
        $role_clone = $this->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'is_clone' => STATUS_ACTIVE,
            ),
        ));
        $this->Behaviors->enable('Level');
        if (empty($role_clone)) {
            throw new NotImplementedException(__('Không có role nào được thiết lập là is_clone'));
        }
        if (empty($role_clone[$this->alias]['data'])) {
            $role_clone[$this->alias]['perm_id'] = $role_clone[$this->alias]['status_id'] = array();
            return $role_clone;
        }
        $data = json_decode($role_clone[$this->alias]['data'], true);
        $role_clone[$this->alias]['perm_id'] = !empty($data['perm_id']) ? $data['perm_id'] : array();
        $role_clone[$this->alias]['status_id'] = !empty($data['status_id']) ? $data['status_id'] : array();
        return $role_clone;
    }

    /**
     * deActiveUsers
     * Thực hiện deactive toàn bộ các user nằm trong role bị xóa
     * @param type $role_id
     */
    protected function deActiveUsers($role_id) {

        $users = $this->User->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'role_id' => $role_id,
                'status' => STATUS_ACTIVE,
            ),
        ));
        if (empty($users)) {
            return true;
        }
        $save_data = array();
        foreach ($users as $v) {
            $save_data[] = array(
                'id' => $v[$this->alias]['id'],
                'status' => STATUS_DEACTIVE,
            );
        }
        return $this->User->saveAll($save_data);
    }

}
