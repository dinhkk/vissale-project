<?php

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('FacebookPersistentDataHandler', 'Lib');
use Facebook\Helpers\FacebookRedirectLoginHelper;

class UsersController extends AppController
{

    public $uses = array(
        'User',
        'UsersRole',
        'Role',
    );


    public function beforeFilter()
    {
        //Configure AuthComponent
        parent::beforeFilter();

        $this->PermLimit->allow(array(
            'login', 'logout', 'register','facebookRegister'
        ));

        // Allow only the view and index actions.
        $this->Auth->allow(array('view', 'login', 'logout', 'register', 'facebookRegister'));
    }

    public function index()
    {

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

    protected function setInit()
    {

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

    protected function parseListData(&$list_data)
    {
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

    public function reqAdd()
    {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {

            $res = array();
            $save_data = $this->request->data;

            try {


                if ($this->User->save($save_data)) {


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

    public function reqEdit($id = null)
    {

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

    public function reqDelete($id = null)
    {

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

    public function login()
    {

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
        $fbApp = self::fbInstance();
        $myPersistentDataHandler = new FacebookPersistentDataHandler();
        $helper = new FacebookRedirectLoginHelper($fbApp, $myPersistentDataHandler);

        $this->layout = 'register';

        //$helper = $fb->getRedirectLoginHelper();

        $permissions = array(
            'manage_pages',
            'read_page_mailboxes',
            'publish_pages',
            //'user_posts',
            //'publish_actions',
            'pages_messaging',
            //'pages_messaging_phone_number',
            //'pages_messaging_subscriptions'

        ); // optional

        $loginUrl = $helper->getLoginUrl("https://vissale.com.vn/users/facebookRegister", $permissions);
        $this->redirect($loginUrl);
    }

    public function facebookRegister()
    {
        $fbApp = self::fbInstance();
        $myPersistentDataHandler = new FacebookPersistentDataHandler();
        $helper = new FacebookRedirectLoginHelper($fbApp, $myPersistentDataHandler);
        $accessToken = null;

        try {
            $accessToken = $helper->getAccessToken();

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $res = $fbApp->get ( 'me?fields=id,name,email,accounts', $accessToken);
        $res = $res->getBody();

        var_dump($res); die;
    }

    public function logout()
    {

        $this->Session->setFlash('Good-Bye');
        $this->Auth->logout();
        CakeSession::destroy();
        return $this->redirect(['action' => 'login']);
    }

    public function resetPassword()
    {

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

    public function assignRole()
    {

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

    private static function fbInstance()
    {

        return new Facebook\Facebook([
            'app_id' => '1317628464949315',
            'app_secret' => '28ca48bc299c5824a6d5b1d85699b647',
            'default_access_token' => '1317628464949315|TWppNpYRWdVvDK_ziqFC6fU4Rtw',
            'default_graph_version' => 'v2.8',
            //'persistent_data_handler' => 'session'
            //'persistent_data_handler' => new FacebookPersistentDataHandler()
        ]);
    }

}
