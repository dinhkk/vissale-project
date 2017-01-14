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

    protected $logged_user;

    public $uses = array ('Users');

    public $components = array(
        //'DebugKit.Toolbar',
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
            'loginRedirect' => array('controller' => 'Orders', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'Users', 'action' => 'login'),
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
        'PermLimit',
    );
    public $helpers = array('Html', 'Form', 'Session', 'Common');

    public function beforeFilter() {
        //Configure AuthComponent
        parent::beforeFilter();

        //check login via iframe
        $this->doLoginViaIFrame();

        //set default values
        $this->set("base_url", FULL_BASE_URL . "/");
        $this->PermLimit->allow(array(
            'login', 'logout',
        ));

        $this->logged_user = CakeSession::read('Auth.User');
        $this->set("logged_user", $this->logged_user);
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
        $this->set('user_group_id', $this->_getGroup());
    }

    public function _getGroup() {
        $user = CakeSession::read('Auth.User');
        return $user['group_id'];
    }
    
    public function requestGet($url, $param) {
        $request = $url . '?' . http_build_query ( $param );
        CakeLog::write('debug', "request register page $request" );
        // Get cURL resource
        $curl = curl_init ();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array ( $curl, array (
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $request
        ) );
        // Send the request & save response to $resp
        $resp = curl_exec ( $curl );
        // Close request to clear up some resources
        curl_close ( $curl );
        //var_dump($curl);
        return $resp;
    }

    public function clearCache()
    {
        $clear_url = Configure::read('sysconfig.FB_CORE.CLEAR_CACHE');
        shell_exec("curl {$clear_url}");
    }

    protected function getLoginIFrameUser($md5)
    {
        $user = $this->Users->find('first', array(
            'conditions' => array('md5(concat("vs", id))' => $md5),
        ));

        return $user;
    }

    protected function doLoginViaIFrame()
    {
        //check login via iframe
        $act = !empty($this->request->query['act']) ? $this->request->query['act'] : null;
        $user_token = !empty($this->request->query['user_id']) ? $this->request->query['user_id'] : null;

        if ($act == "do_login" && !empty($user_token)) {
            $checkLogin = $this->getLoginIFrameUser($user_token);
            if ($checkLogin) {
                $params = $this->request->params;
                $dataLogin = $checkLogin['Users'];
                unset($checkLogin['Users']['password']);
                $login = $this->Auth->login($dataLogin);
                if ($login == true) {
                    CakeSession::write('LoginIFrame', true);
                    $uri = "?";
                    if ( !empty($this->request->query['conversation_id']) ) {
                        $conversation_id = $this->request->query['conversation_id'];
                        $uri .= "conversation_id={$conversation_id}&";
                    }
                    if ( !empty($this->request->query['order_id']) ) {
                        $order_id = $this->request->query['order_id'];
                        $uri .= "order_id={$order_id}&";
                    }

                    $this->redirect([
                        'controller' => $params['controller'],
                        'action' => $params['action'] . $uri
                    ]);
                }
            }
        }
        if ($act == "do_logout") {
            $this->Auth->logout();
            CakeSession::destroy();
        }
        if (!empty(CakeSession::read('LoginIFrame'))) {
            $this->set("LoginIFrame", CakeSession::read('LoginIFrame'));
        } else {
            $this->set("LoginIFrame", false);
        }
    }


    protected function seoUrl($string)
    {
        //Lower case everything

        $string = strtolower($string);
        $string = $this->jam_remove_vnm($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    protected function jam_remove_vnm($string)
    {
        $trans = array(
            /*
                special char
            */
            'ỡ' => 'o', 'õ' => 'o', 'Ố' => 'o', 'ấ' => 'a', 'ị' => 'i', 'ầ' => 'a', 'ả' => 'a', 'ỏ' => 'o', 'ọ' => 'o', 'ể' => 'e', 'ữ' => 'u', 'ạ' => 'a',
            'ỹ' => 'y', 'ũ' => 'u', 'ủ' => 'u', 'α' => 'a', 'Ã' => 'a', 'ụ' => 'u', 'ẹ' => 'e'

        , 'à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
            'ă' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a',
            'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
            'À' => 'a', 'Á' => 'a', 'Ả' => 'a', 'Ã' => 'a', 'Ạ' => 'a',
            'Ă' => 'a', 'Ằ' => 'a', 'Ắ' => 'a', 'Ẳ' => 'a', 'Ẵ' => 'a', 'Ặ' => 'a',
            'Â' => 'a', 'Ầ' => 'a', 'Ấ' => 'a', 'Ẩ' => 'a', 'Ẫ' => 'a', 'Ậ' => 'a',
            'đ' => 'd', 'Đ' => 'd',
            'è' => 'e', 'é' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
            'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
            'È' => 'e', 'É' => 'e', 'Ẻ' => 'e', 'Ẽ' => 'e', 'Ẹ' => 'e',
            'Ê' => 'e', 'Ề' => 'e', 'Ế' => 'e', 'Ể' => 'e', 'Ễ' => 'e', 'Ệ' => 'e',
            'ì' => 'i', 'í' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
            'Ì' => 'i', 'Í' => 'i', 'Ỉ' => 'i', 'Ĩ' => 'i', 'Ị' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
            'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
            'ơ' => 'o', 'ờ' => 'o', 'ớ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
            'Ò' => 'o', 'Ó' => 'o', 'Ỏ' => 'o', 'Õ' => 'o', 'Ọ' => 'o',
            'Ô' => 'o', 'Ồ' => 'o', 'Ố' => 'o', 'Ổ' => 'o', 'Ỗ' => 'o', 'Ộ' => 'o',
            'Ơ' => 'o', 'Ờ' => 'o', 'Ớ' => 'o', 'Ở' => 'o', 'Ỡ' => 'o', 'Ợ' => 'o',
            'ù' => 'u', 'ú' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
            'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
            'Ù' => 'u', 'Ú' => 'u', 'Ủ' => 'u', 'Ũ' => 'u', 'Ụ' => 'u',
            'Ư' => 'u', 'Ừ' => 'u', 'Ứ' => 'u', 'Ử' => 'u', 'Ữ' => 'u', 'Ự' => 'u',
            'ỳ' => 'y', 'ý' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
            'Y' => 'y', 'Ỳ' => 'y', 'Ý' => 'y', 'Ỷ' => 'y', 'Ỹ' => 'y', 'Ỵ' => 'y',
            '`' => '', '“' => '-', '”' => '-'

        );
        return strtr($string, $trans);
    }
}
