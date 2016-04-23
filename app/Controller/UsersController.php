<?php

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController {


    public $uses = array('User');
    
    public function beforeFilter() {
        //Configure AuthComponent
        parent::beforeFilter();
    }

    protected function setInit() {

        $this->set('model_class', $this->modelClass);
    }

    public function login() {

        $this->layout = 'login';


        if ( $this->Auth->user() ){
            return $this->redirect( ['controller' => 'pages', 'action'=>'dashboard'] );
        }
        

        if ($this->request->is('post')) {

            // Important: Use login() without arguments! See warning below.

            if ( $this->Auth->login() ) {

                $this->request->data;

                return $this->redirect( ['controller' => 'pages', 'action'=>'dashboard'] );


            }
            // Prior to 2.7 use
            $this->Session->setFlash(__('Username or password is incorrect'));
        }
    }

    public function logout() {
        $this->Session->setFlash('Good-Bye');
        $this->Auth->logout();
        return $this->redirect(['action'=>'login']);
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

            //change pw
            if ( !empty($save_data['action']) && $save_data['action']=="change_password" ) :
                if ( !empty($save_data['new_password']) &&
                    !empty($save_data['re_password']) &&
                    strcmp($save_data['re_password'], $save_data['re_password']) ==0){
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
            endif;
            //end change password

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

    public function reqDelete($id = null) {
        if (! $this->{$this->modelClass}->exists ( $id )) {
            throw new NotFoundException ( __ ( 'invalid_data' ) );
        }
        $this->autoRender = false;
        if ($this->request->is ( 'ajax' )) {
            $res = array ();
            if ($this->{$this->modelClass}->delete ( $id )) {
                $res ['error'] = 0;
                $res ['data'] = null;
            } else {
                $res ['error'] = 1;
                $res ['data'] = null;
            }
            echo json_encode ( $res );
        }
    }
    

    
}
