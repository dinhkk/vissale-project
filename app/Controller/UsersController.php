<?php

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController {

    public $uses = array(
        'User',
        'UsersRole',
        'Role',
    );

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
        ),
        'PermLimit',
    );

    public function beforeFilter()
    {
        //Configure AuthComponent

        $this->PermLimit->allow(array(
            'login', 'logout','register'
        ));

        // Allow only the view and index actions.
        $this->Auth->allow(array('view', 'login', 'logout', 'register'));
    }

    public function index() {

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
        $this->setInit();
        $page_title = __('user_title');
        $this->set('page_title', $page_title);

        $breadcrumb = array();
        $breadcrumb[] = array(
            'title' => __('home_title'),
            'url' => Router::url(array('controller' => 'DashBoard', 'action' => 'index'))
        );
        $breadcrumb[] = array(
            'title' => __('user_title'),
            'url' => Router::url(array('action' => $this->action)),
        );
        $this->set('breadcrumb', $breadcrumb);

        $options = array(
            'order' => array(
                'modified' => 'DESC',
            ),
        );
        $options['recursive'] = -1;
        $options['contain'] = array(
            'UsersRole',
        );
        $page = $this->request->query('page');
        if (!empty($page)) {
            $options['page'] = $page;
        }
        $limit = $this->request->query('limit');
        if (!empty($limit)) {
            $options['limit'] = $limit;
        }
        $this->Prg->commonProcess();
        $options['conditions'] = $this->{$this->modelClass}->parseCriteria($this->Prg->parsedParams());
        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate();
        $this->parseListData($list_data);
        $this->set('list_data', $list_data);
    }

    protected function parseListData(&$list_data) {
        if (empty($list_data)) {
            return;
        }
        foreach ($list_data as $k => $v) {
            if (empty($v['UsersRole'])) {
                $list_data[$k][$this->modelClass]['role_id'] = array();
            } else {
                $list_data[$k][$this->modelClass]['role_id'] = Hash::extract($v['UsersRole'], '{n}.role_id');
            }
        }
    }

    public function reqAdd() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {

            $res = array();
            $save_data = $this->request->data;

            try {


                if ( $this->User->save($save_data) ) {


                    $res['error'] = 0;
                    $res['data'] = null;
                    echo json_encode($res);
                    die();

                } else {


                    $res['error'] = 1;
                    $res['data'] = array(
                        'validationErrors' => $this->User->validationErrors,
                    );
                    $this->layout = 'ajax';
                    $this->set('model_class', $this->modelClass);
                    $render = $this->render('req_add');
                    $res['data']['html'] = $render->body();
                    echo json_encode($res);
                    exit();
                }

            } catch (Exception $ex) {

                $res['error'] = 1;
                $res['data'] = array(
                    'validationErrors' => [
                        'username' => [$ex->getMessage()]
                    ],
                );
                //setlocale(LC_ALL, "vi_VN");
                $res['data']['error_msg'] = "Lỗi thêm nhân viên \n" . $ex->getMessage();
                $this->layout = 'ajax';
                $this->set('model_class', $this->modelClass);
                $render = $this->render('req_add');
                $res['data']['html'] = $render->body();
                echo json_encode($res);
                exit();

            }

        }
    }

    public function reqEdit($id = null) {

        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $res = array();
            $save_data = $this->request->data;
            if ($this->{$this->modelClass}->save($save_data)) {
                $res['error'] = 0;
                $res['data'] = null;
            } else {
                $res['error'] = 1;
                $res['data'] = array(
                    'validationErrors' => $this->{$this->modelClass}->validationErrors,
                );
                $this->layout = 'ajax';
                $this->set('model_class', $this->modelClass);
                $this->set('id', $id);
                $render = $this->render('req_edit');
                $res['data']['html'] = $render->body();
                echo json_encode($res);
                exit();
            }
            echo json_encode($res);
        }
    }

    public function reqDelete($id = null) {

        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $res = array();
            if ($this->{$this->modelClass}->delete($id)) {
                $res['error'] = 0;
                $res['data'] = null;
            } else {
                $res['error'] = 1;
                $res['data'] = null;
            }
            echo json_encode($res);
        }
    }

    protected function setInit() {

        $this->set('model_class', $this->modelClass);

        $get_roles = $this->Role->find('all', array(
            'recursive' => -1,
        ));
        $roles = $role_actives = array();
        if (!empty($get_roles)) {
            foreach ($get_roles as $v) {
                $roles[$v['Role']['id']] = $v['Role']['name'];
                if ($v['Role']['status'] == STATUS_ACTIVE) {
                    $role_actives[$v['Role']['id']] = $v['Role']['name'];
                }
            }
        }
        $this->set('role', $roles);
        $this->set('role_actives', $role_actives);

        $users = $this->{$this->modelClass}->find('list', array(
            'recursive' => -1,
            'fields' => array(
                'id', 'username',
            ),
        ));
        $this->set('users', $users);
    }

    public function login() {

        $this->layout = 'login';
        if ($this->Auth->user()) {
            return $this->redirect(['controller' => 'pages', 'action' => 'dashboard']);
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect(['controller' => 'pages', 'action' => 'dashboard']);
            }
            // Prior to 2.7 use
            $this->Session->setFlash(__('Username or password is incorrect'));
        }
    }

    public function register()
    {
        $this->layout = 'register';
    }

    public function logout() {

        $this->Session->setFlash('Good-Bye');
        $this->Auth->logout();
        CakeSession::destroy();
        return $this->redirect(['action' => 'login']);
    }

    public function resetPassword() {

        $id = $this->request->data($this->modelClass . '.id');
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->autoRender = false;
        $res = array(
            'error' => 0,
            'data' => null,
            'message' => '',
        );
        $password = $this->request->data($this->modelClass . '.password');
        $re_password = $this->request->data($this->modelClass . '.re_password');
        if ($password !== $re_password) {
            $res['error'] = 1;
            $res['message'] = __('Mật khẩu nhập không khớp');
        }
        if (!$this->{$this->modelClass}->save($this->request->data[$this->modelClass])) {
            $res['error'] = 2;
            $res['message'] = __('Mật khẩu nhập không hợp lệ, phải lớn hơn hoặc bằng 6 kí tự');
            $res['data'] = $this->{$this->modelClass}->validationErrors;
        }
        echo json_encode($res);
    }

    public function assignRole() {

        $id = $this->request->data($this->modelClass . '.id');
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->autoRender = false;
        $res = array(
            'error' => 0,
            'data' => null,
            'message' => '',
        );
        $role_id = $this->request->data($this->modelClass . '.role_id');
        if (empty($role_id)) {
            $res['error'] = 1;
            $res['message'] = __('Tài khoản phải được phân vào ít nhất 1 nhóm quyền');
            echo json_encode($res);
            exit();
        }
        if (!$this->{$this->modelClass}->save($this->request->data[$this->modelClass])) {
            $res['error'] = 2;
            $res['message'] = __('Lỗi, không lưu thành công');
            $res['data'] = $this->{$this->modelClass}->validationErrors;
        }
        echo json_encode($res);
    }

}
