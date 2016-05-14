<?php

App::uses('AppController', 'Controller');

/**
 * Roles Controller
 *
 * @property Role $Role
 * @property PaginatorComponent $Paginator
 */
class RolesController extends AppController {

    public $uses = array(
        'Role',
        'Perm',
        'Status',
    );

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow();
    }

    protected function setInit() {
        $this->set('model_class', $this->modelClass);

        $status = Configure::read('fbsale.App.status');
        $this->set('status', $status);

        $role_levels = Configure::read('fbsale.App.role_levels');
        $this->set('role_levels', $role_levels);

        $perms = $this->Perm->find('list', array(
            'recursive' => -1,
            'fields' => array(
                'id', 'code', 'module',
            ),
        ));
        $this->set('perms', $perms);

        $order_status = $this->Status->getSystemStatus();
        $this->set('order_status', $order_status);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
        $this->setInit();

        $breadcrumb = array();
        $breadcrumb[] = array(
            'title' => __('home_title'),
            'url' => Router::url(array('controller' => 'DashBoard', 'action' => 'index'))
        );
        $breadcrumb[] = array(
            'title' => __('role_title'),
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
            'RolesStatus', 'RolesPerm',
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

        $this->setSearchConds($options);

        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate();
        $this->parseListData($list_data);

        $this->set('list_data', $list_data);
        $this->set('page_title', __('role_title'));
    }

    protected function setSearchConds(&$options) {

        if (!empty($this->request->query['perm_id'])) {
            $perm_id = $this->request->query['perm_id'];
            $options['joins'][] = array('table' => 'roles_perms',
                'alias' => 'RolesPerm',
                'type' => 'INNER',
                'conditions' => array(
                    'RolesPerm.role_id = ' . $this->modelClass . '.id',
                )
            );
            $options['conditions']['RolesPerm.perm_id'] = $perm_id;
        }
    }

    protected function parseListData(&$list_data) {

        if (empty($list_data)) {
            return;
        }
        foreach ($list_data as $k => $v) {
            if (!empty($v['RolesPerm'])) {
                $list_data[$k][$this->modelClass]['perm_id'] = Hash::extract($v['RolesPerm'], '{n}.perm_id');
            } else {
                $list_data[$k][$this->modelClass]['perm_id'] = array();
            }
            if (!empty($v['RolesStaus'])) {
                $list_data[$k][$this->modelClass]['status_id'] = Hash::extract($v['RolesStaus'], '{n}.status_id');
            } else {
                $list_data[$k][$this->modelClass]['status_id'] = array();
            }
        }
    }

    public function reqAdd() {

        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $res = array();
            $save_data = $this->request->data;
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

}
