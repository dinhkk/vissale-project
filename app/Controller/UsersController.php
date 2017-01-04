<?php

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('FacebookPersistentDataHandler', 'Lib');
use Facebook\Helpers\FacebookRedirectLoginHelper as FacebookRedirectLoginHelper;
use Facebook\Facebook as Facebook;

class UsersController extends AppController
{
    private $fb_user_token = null;

    public $uses = array(
        'Group',
        'User',
        'UsersRole',
        'Role',
        'FBPage'
    );


    public function beforeFilter()
    {
        //Configure AuthComponent
        parent::beforeFilter();

        $this->PermLimit->allow(array(
            'login', 'logout', 'register','facebookRegister', 'createPage','test'
        ));

        // Allow only the view and index actions.
        $this->Auth->allow(array('view', 'login', 'logout', 'register', 'facebookRegister', 'createPage', 'test'));
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
        //$myPersistentDataHandler = new FacebookPersistentDataHandler();
        //$helper = new FacebookRedirectLoginHelper($fbApp, $myPersistentDataHandler);

        $this->layout = 'register';

        $helper = $fbApp->getRedirectLoginHelper();

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

        $loginUrl = $helper->getLoginUrl( FULL_BASE_URL . "/users/facebookRegister", $permissions);
        $this->redirect($loginUrl);
    }

    public function facebookRegister()
    {
        $this->layout = "register";

        $fbApp = self::fbInstance();
        $helper = $fbApp->getRedirectLoginHelper();
        //$myPersistentDataHandler = new FacebookPersistentDataHandler();
        //$helper = new FacebookRedirectLoginHelper($fbApp, $myPersistentDataHandler);

        $accessToken = null;

        try {
            $accessToken = $helper->getAccessToken();
            $this->fb_user_token = $accessToken;
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $res = $fbApp->get ( 'me?fields=id,name,email,accounts', $accessToken);
        //$res = $res->getBody();
        $data = $res->getDecodedBody();


        $pages = !empty($data['accounts']['data']) ? $data['accounts']['data'] : [];
        $fb_user_id = $data['id'];
        $fb_user_name = $data['name'];

        $group_id = $this->isRegisteredFBUser($fb_user_id);

        if (!$group_id) {
            $data = array(
                'fb_user_id' => $fb_user_id,
                'fb_user_name' => $fb_user_name,
                'fb_user_token' => $this->fb_user_token,
                'code' => $fb_user_id,
                'name' => $fb_user_name,
                'phone' => "+84" . uniqid(),
                'address' => "N/A"
            );

            $group_id = $this->createGroup($data);
        }

        $csrf_token = uniqid("vissale_");
        CakeSession::write('csrf_token', $csrf_token);

        $this->set('group_id', $group_id);
        $this->set('pages', $pages);
        $this->set('csrf_token', $csrf_token);
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

        return new Facebook([
            'app_id' => '1317628464949315',
            'app_secret' => '28ca48bc299c5824a6d5b1d85699b647',
            'default_access_token' => '1317628464949315|TWppNpYRWdVvDK_ziqFC6fU4Rtw',
            'default_graph_version' => 'v2.8',
            //'persistent_data_handler' => 'session'
            'persistent_data_handler' => new FacebookPersistentDataHandler()
        ]);
    }

    private function isRegisteredFBUser($fb_user_id)
    {
        $conditions = array(
            'fb_user_id' => $fb_user_id
        );

        $group = $this->Group->find('first', array(
            'conditions' => $conditions
        ));

        if (!empty($group)) {
            $this->Group->read(null, $group['Group']['id']);
            $this->Group->set('fb_user_token', $this->fb_user_token);
            $this->Group->save();
        }

        return !empty($group) ? $group['Group']['id'] : false;
    }

    private function createGroup(Array $data)
    {

        if ( $this->Group->save($data) ) {
            $this->createGroupV2($data);
            return $this->Group->id;
        }
//        debug($this->Group->validationErrors);
        return false;
    }

    private function createGroupV2($data)
    {
        $url = "https://app.vissale.com/outsite_register.php?username={$data['fb_user_id']}&full_name={$data['fb_user_id']}&email={$data['email']}";
        return file_get_contents($url);
    }

    public function createPage()
    {
        $this->layout = "register";
        $message = null;
        $data = [];
        if ($this->request->is("post")) {
            $data = $this->request->data;
        }
        $csrf_token = CakeSession::read('csrf_token');
        if ($csrf_token != $data['csrf_token']) {
            die('token is not valid');
        }
        //debug($data);

        $conditions = array(
            'page_id' =>  $data['page_id']
        );

        $page = $this->FBPage->find('first', array(
            'conditions' => $conditions
        ));

        if (!$page) {
            $this->FBPage->create();
            $page = $this->FBPage->save($data);
            $message = "Page đã được đăng tạo";

            $this->subscribeApp($data['page_id'], $data['page_token']);
        }
        if ($page && $page['FBPage']['group_id'] == $data['group_id']) {
            $this->FBPage->id = $page['FBPage']['id'];
            $this->FBPage->saveField('token', $data['page_token']);

            $message = "Page đã được cập nhật";
            $this->subscribeApp($data['page_id'], $data['page_token']);
        }

        if ($page && $page['FBPage']['group_id'] != $data['group_id']) {
            $message = "Page đã tồn tạo trong hệ thống! Hãy thử lại với page khác.";
        }

        //CakeSession::write('fb_reg_msg', $message);
        $this->set('message', $message);
    }

    private function subscribeApp($page_id, $page_token_key)
    {
        $fbApp = self::fbInstance();
        $res = $fbApp->post ( "/{$page_id}/subscribed_apps", array(), $page_token_key);
        return $res->getDecodedBody();
    }

    public function test()
    {
        $str = "{\"id\":\"1871539413077337\",\"name\":\"Tr\u1ecbnh Th\u1ebf \u0110\u1ecbnh\",\"accounts\":{\"data\":[{\"access_token\":\"EAASuYEiZAaEMBAN6c12nTfKgrjHgMYIojXkFDB7iR1MEUSNvrTV1mODTVhqdmgqSAllVP2KojrppluQk4RY45ENjDXotmiSRyiF4rM8KrJ4nSCjV1PzyTtvTpzJvgfgXxrhXXXMZBpVyMfHNRnbUZB2nwyYW8gVKO9EkPfZBddstHMnai8Lk\",\"category\":\"Computer Company\",\"name\":\"wordpress.shared.all\",\"id\":\"949376755131130\",\"perms\":[\"ADMINISTER\",\"EDIT_PROFILE\",\"CREATE_CONTENT\",\"MODERATE_CONTENT\",\"CREATE_ADS\",\"BASIC_ADMIN\"]},{\"access_token\":\"EAASuYEiZAaEMBAJ3BibXQ2pdeITdpaUl3rI6xNvILg1T9KZAFIKZAAtcnIzA0annjIMFBtEbpJVTwZCxNMvpMouZAvWZAHcJ5roYleQ3jxnOZAczvwjqCrfxB7QRuiYy7mgMiv3hq8p4tlZAfxWaZACKLTUsPv0qYkdjMXVtayLsDTYWat7SIri63\",\"category\":\"Company\",\"name\":\"Testsynchronous\",\"id\":\"577673849024489\",\"perms\":[\"ADMINISTER\",\"EDIT_PROFILE\",\"CREATE_CONTENT\",\"MODERATE_CONTENT\",\"CREATE_ADS\",\"BASIC_ADMIN\"]},{\"access_token\":\"EAASuYEiZAaEMBANtEl6iphcXrEAROujDcOwfaChxaKf0lDOPqsFWJVVwwCsqRhs0f5YL5pELsZCOek5ZA1YjqLyXXXGj9uOZAZBLKf0yIBQXSNqardTh9qCVAZBJrwnRpABWCQlzHX9i9EahOO0ywKeiFAFTQUEa0uOmw9FgosZAUimHNWvZB8mn\",\"category\":\"Book Store\",\"category_list\":[{\"id\":\"197048876974331\",\"name\":\"Book Store\"}],\"name\":\"THAI HA BOOK\",\"id\":\"1737388339830381\",\"perms\":[\"ADMINISTER\",\"EDIT_PROFILE\",\"CREATE_CONTENT\",\"MODERATE_CONTENT\",\"CREATE_ADS\",\"BASIC_ADMIN\"]},{\"access_token\":\"EAASuYEiZAaEMBAAb8TZCJ1RYg3cQzfF3GzSV9eZBzDkl7AUbpiCMxw1jSs13PcpElkPtZANX8MBeZCFyck1Po0UvuLqiv8TMv6rKXmZBjNySAKIowpIIwWHIO40wUpgE3EOFiLdqsk3sXsSLIRcIm7G0ZB9qg3LFwQUNAJhQ5qOOgzK4kXpIvr1\",\"category\":\"Community\",\"name\":\"Dinhkk's page shop\",\"id\":\"645302418891504\",\"perms\":[\"ADMINISTER\",\"EDIT_PROFILE\",\"CREATE_CONTENT\",\"MODERATE_CONTENT\",\"CREATE_ADS\",\"BASIC_ADMIN\"]},{\"access_token\":\"EAASuYEiZAaEMBAHA4ipGlX2yPXhdGUxzcngmXASbZAwRjmx5a5XbsvgRxmhJr73uZBATZBWa7JTBcgR8LODeMywYpge9nKgk0MLvWT8ZAD3tQXhEZAz46xMFXJZBfxl2PZAjaZBIPymBl8S1fEbV2nn9ZA6IgxCaGvOOSqZCJShuXrjuAILKigGT7ao\",\"category\":\"Software\",\"name\":\"Vissale\",\"id\":\"166317653801276\",\"perms\":[\"ADMINISTER\",\"EDIT_PROFILE\",\"CREATE_CONTENT\",\"MODERATE_CONTENT\",\"CREATE_ADS\",\"BASIC_ADMIN\"]},{\"access_token\":\"EAASuYEiZAaEMBAAmn4DvEf01ipAm2xrDB9XXVmUSPZBPpi0fyJy3j1idDQW0gvcwGmQer0BWyQCj4VUA7xBndMwFxoPbjF3QM30cxkWQPPEgDsIVUwpfqXXjH7afUmbI9ltJ1b8G8ZBoq45pIKI1piHijSDEjY6I3DoOjxhOaCb8Q8taLmG\",\"category\":\"Product\/Service\",\"name\":\"Testcanhduongsinh\",\"id\":\"1308198229225478\",\"perms\":[\"ADMINISTER\",\"EDIT_PROFILE\",\"CREATE_CONTENT\",\"MODERATE_CONTENT\",\"CREATE_ADS\",\"BASIC_ADMIN\"]},{\"access_token\":\"EAASuYEiZAaEMBAOSK6WvHekwfZCeaQSKuncuTcGiuFtjWZCQzlADYmNzeNf4xqBSsxMlIv4wWSGw2En5Szi5ZBfc0a08vOd4AOKaFgFh1SltmmGEf8pp92l7ZAJ0YFFdqffKomJJZCEpcOoFPjCZBmiyHG26cYPfMRnN038dVcjlxXpBSFjZBNQX\",\"category\":\"Fashion\",\"category_list\":[{\"id\":\"871941916244102\",\"name\":\"Fashion\"}],\"name\":\"\u00c1o Phao VNXK Ch\u1ea5t L\u01b0\u1ee3ng Cao\",\"id\":\"1409730169067190\",\"perms\":[\"EDIT_PROFILE\",\"CREATE_CONTENT\",\"MODERATE_CONTENT\",\"CREATE_ADS\",\"BASIC_ADMIN\"]}],\"paging\":{\"cursors\":{\"before\":\"OTQ5Mzc2NzU1MTMxMTMw\",\"after\":\"MTQwOTczMDE2OTA2NzE5MAZDZD\"}}}}";

        $data = json_decode($str, true);
        //for test
        $this->fb_user_token = "ABABAB";
        $this->layout = "register";


        $pages = !empty($data['accounts']['data']) ? $data['accounts']['data'] : [];
        $fb_user_id = $data['id'];
        $fb_user_name = $data['name'];

        $group_id = $this->isRegisteredFBUser($fb_user_id);

        if (!$group_id) {
            $data = array(
                'fb_user_id' => $fb_user_id,
                'fb_user_name' => $fb_user_name,
                'fb_user_token' => $this->fb_user_token,
                'code' => $fb_user_id,
                'name' => $fb_user_name,
                'phone' => "+84" . uniqid(),
                'address' => "N/A"
            );

            $group_id = $this->createGroup($data);
        }

        $csrf_token = uniqid("vissale_");
        CakeSession::write('csrf_token', $csrf_token);

        $this->set('group_id', $group_id);
        $this->set('pages', $pages);
        $this->set('csrf_token', $csrf_token);

        //die;
    }
}
