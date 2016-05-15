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
            $this->data[$this->alias]['data']['perm_id'] = array_keys($perm_codes);
            $this->data[$this->alias]['data']['perm_code'] = array_values($perm_codes);
            $this->data[$this->alias]['data']['status_id'] = $this->data[$this->alias]['status_id'];
            $this->data[$this->alias]['data'] = json_encode($this->data[$this->alias]['data']);
        }
    }

    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);

        if (isset($this->data[$this->alias]['perm_id'])) {
            // lưu lại quan hệ giữa roles và perms
            $this->RolesPerm->deleteAll(array(
                'RolesPerm.role_id' => $this->id,
                    ), false);
            $save_data = array();
            if (!empty($this->data[$this->alias]['perm_id'])) {
                foreach ($this->data[$this->alias]['perm_id'] as $v) {
                    $save_data[] = array(
                        'role_id' => $this->id,
                        'perm_id' => $v,
                    );
                }
                $this->RolesPerm->saveAll($save_data);
            }
        }
        if (isset($this->data[$this->alias]['status_id'])) {
            // lưu lại quan hệ giữa roles và statuses
            $this->RolesStatus->deleteAll(array(
                'RolesStatus.role_id' => $this->id,
                    ), false);
            $save_data = array();
            if (!empty($this->data[$this->alias]['status_id'])) {
                foreach ($this->data[$this->alias]['status_id'] as $v) {
                    $save_data[] = array(
                        'role_id' => $this->id,
                        'status_id' => $v,
                    );
                }
                $this->RolesStatus->saveAll($save_data);
            }
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
        if (isset($this->data[$this->alias]['data'])) {
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
            $save_data[] = array(
                'id' => $v[$this->alias]['id'],
                'data' => $this->data[$this->alias]['data'],
                'status' => $v[$this->alias]['status'],
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
        $parent_id = $role[$this->alias]['parent_id'];
        if (!empty($parent_id)) {
            $this->User->sync($this->id);
            return true;
        }
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
