<?php

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController {


    public $uses = array('User');

    public $components = array(
        'DebugKit.Toolbar',
        'Flash',
        'Paginator',
        'Search.Prg',
        'Session', 'Cookie',

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
            )
        )
    );

    protected function setInit() {

        $this->set('model_class', $this->modelClass);
    }

    public function login() {

        $this->layout = 'login';

        if ($this->request->is('post')) {

            // Important: Use login() without arguments! See warning below.

            $passwordHasher = new BlowfishPasswordHasher();
            $this->request->data['password'] = $passwordHasher->hash(
                $this->request->data['password']
            );
            debug($this->data['password']);

            if ( $this->Auth->login() ) {

                $this->request->data;

                //return $this->redirect( ['controller' => 'pages', 'action'=>'dashboard'] );


                die('434343');
            }
            

            debug( $this->request->data );

            // Prior to 2.7 use
            $this->Session->setFlash(__('Username or password is incorrect'));
        }
    }

    public function logout() {
        $this->Auth->logout();
    }

    public function index() {

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
        $this->setInit();
        $page_title = __('user_page_title');
        $this->set('page_title', $page_title);

        $breadcrumb = array();
        $breadcrumb[] = array(
            'title' => __('home_title'),
            'url' => Router::url(array('controller' => 'DashBoard', 'action' => 'index'))
        );
        $breadcrumb[] = array(
            'title' => __('user_page_title'),
            'url' => Router::url(array('action' => $this->action)),
        );
        $this->set('breadcrumb', $breadcrumb);

        $options = array(
            'order' => array(
                'modified' => 'DESC',
            ),
        );

        $options['recursive'] = -1;
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

        //debug( $list_data ); die;

        $this->set('list_data', $list_data);
    }

    public function reqAdd() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $res = array();
            $save_data = $this->request->data;

            //debug( $save_data ); die;

            if ($this->{$this->modelClass}->save($save_data)) {
                $res['error'] = 0;
                $res['data'] = null;
                echo json_encode($res);
            } else {
                $res['error'] = 1;
                $res['data'] = array(
                    'validationErrors' => $this->{$this->modelClass}->validationErrors,
                );
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

            if ( strcmp($save_data['new_password'], $save_data['re_password']) ==0){
                $save_data['password'] = $save_data['new_password'];
            } else {
                $res['error'] = 1;
                $res['data'] = array(
                    'validationErrors' => $this->{$this->modelClass}->validationErrors,
                );
                $this->layout = 'ajax';
                $this->set('model_class', $this->modelClass);
                $this->set('id', $id);
                $render = $this->render('req_edit');
                $res['data']['error_msg'] = __('passwords_not_equal_try_again');
                echo json_encode($res);
                exit();
            }

            if ( $this->User->save($save_data) ) {
                $res['error'] = 0;
                $res['data']['msg'] = "ok";
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

    public function delete($id = null) {

    }
    

    
}
