<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'DebugKit.Toolbar',
        'Flash',
        'Paginator',
        'Search.Prg',
        'Session',
        'Cookie',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
            ),
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'username', //Default is 'username' in the userModel
                        'password' => 'password'  //Default is 'password' in the userModel
                    ),
                    'passwordHasher' => 'Blowfish'
                )
            ),
        //'authorize' => 'actions',
        //'actionPath' => 'controllers/',
        ),
        'Acl',
    );
    public $helpers = array('Html', 'Form', 'Session');

    public function beforeFilter() {
        //Configure AuthComponent
        parent::beforeFilter();

        $this->set("base_url", FULL_BASE_URL . "/");
    }

    public function isAuthorized($user = null) {
        // Any registered user can access public functions
        if (empty($this->request->params['prefix'])) {
            return true;
        }

        // Only admins can access admin functions
        if ($this->request->params['prefix'] === 'admin') {
            return (bool) ($user['is_group_admin'] === true);
        }

        // Default deny
        return false;
    }

    public $paginate = array(
        'limit' => LIMIT_DEFAULT,
    );

    public function beforeRender() {
        parent::beforeRender();

        $limits = Configure::read('fbsale.App.limits');
        $this->set('limits', $limits);

        // thực hiện lấy dữ liệu phân quyền trong user đẩy xuống view
        $user = $this->Auth->user();
        $user_level = !empty($user['level']) ? $user['level'] : ZEROLEVEL;
        $this->set('user_level', $user_level);

        $user_perm_code = $user_perm_id = $user_status_id = array();
        if (!empty($user['data'])) {
            $data = json_decode($user['data'], true);
            $user_perm_code = !empty($data['perm_code']) ? $data['perm_code'] : array();
            $user_perm_id = !empty($data['perm_id']) ? $data['perm_id'] : array();
            $user_status_id = !empty($data['status_id']) ? $data['status_id'] : array();
        }
        $this->set('user_perm_code', $user_perm_code);
        $this->set('user_perm_id', $user_perm_id);
        $this->set('user_status_id', $user_status_id);
    }

    public function _getGroup() {
        $user = CakeSession::read('Auth.User');
        return $user['group_id'];
    }

}
