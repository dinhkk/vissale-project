<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $actsAs = array(
        'Level', // thực hiện lọc dữ liệu dựa vào level của user
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        // xử lý chung dành cho phân quyền
        $user = CakeSession::read('Auth.User');
        if (!empty($user)) {
            if (!isset($this->data[$this->alias]['user_created']) && empty($this->data[$this->alias]['id'])) {
                $this->data[$this->alias]['user_created'] = $user['id'];
            }
            if (!isset($this->data[$this->alias]['group_id']) && !empty($user['group_id'])) {
                $this->data[$this->alias]['group_id'] = $user['group_id'];
            }
            if (!isset($this->data[$this->alias]['user_modified']) && !empty($this->data[$this->alias]['id'])) {
                $this->data[$this->alias]['user_modified'] = $user['id'];
            }
            // nếu user thuộc user hệ thống, tự động set group_id thành group_id mặc định
            if (!isset($this->data[$this->alias]['group_id']) && !empty($user['level']) && $user['level'] >= ADMINSYSTEM) {
                $this->data[$this->alias]['group_id'] = SYSTEM_GROUP_ID;
            }
        }
    }

    public function _getGroup() {
        $user = CakeSession::read('Auth.User');
        return $user['group_id'];
    }

    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('|^[0-9a-zA-Z_-]*$|', $value);
    }

}
