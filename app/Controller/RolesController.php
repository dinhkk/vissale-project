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
        'Group',
    );

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow();
    }

    protected function setInit() {
        $this->set('model_class', $this->modelClass);

        $status = Configure::read('fbsale.App.status');
        $this->set('status', $status);

        $level = $this->Auth->user('level');

        if ($level >= ADMINSYSTEM) {
            $role_levels = Configure::read('fbsale.App.role_levels');
            $this->set('role_levels', $role_levels);

            $perms = $this->Perm->find('list', array(
                'recursive' => -1,
                'fields' => array(
                    'id', 'code', 'module',
                ),
            ));
            $this->set('perms', $perms);

            $groups = $this->Group->find('list', array(
                'recursive' => -1,
                'fields' => array(
                    'id', 'code',
                ),
            ));
            $this->set('groups', $groups);

            $parents = $this->{$this->modelClass}->find('list', array(
                'recursive' => -1,
                'fields' => array(
                    'id', 'name',
                ),
                'options' => array(
                    'parent_id' => null,
                )
            ));
            $this->set('parents', $parents);
        }

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

        if (isset($this->request->query['enable_print_perm'])) {
            if (!empty($this->request->query['enable_print_perm'])) {
                $this->request->query['perm_id'][] = PRINT_PERM_ID;
            } elseif (($key = array_search(PRINT_PERM_ID, $this->request->query['perm_id'])) !== false) {
                unset($this->request->query['perm_id'][$key]);
                $this->request->query['perm_id'] = array_values($this->request->query['perm_id']);
            }
        }
        if (isset($this->request->query['enable_export_exel_perm'])) {
            if (!empty($this->request->query['enable_export_exel_perm'])) {
                $this->request->query['perm_id'][] = EXPORT_EXEL_PERM_ID;
            } elseif (($key = array_search(EXPORT_EXEL_PERM_ID, $this->request->query['perm_id'])) !== false) {
                unset($this->request->query['perm_id'][$key]);
                $this->request->query['perm_id'] = array_values($this->request->query['perm_id']);
            }
        }
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
            $list_data[$k][$this->modelClass]['enable_print_perm'] = 0;
            $list_data[$k][$this->modelClass]['enable_export_exel_perm'] = 0;
            if (!empty($v['RolesPerm'])) {
                $list_data[$k][$this->modelClass]['perm_id'] = Hash::extract($v['RolesPerm'], '{n}.perm_id');
                if (in_array(PRINT_PERM_ID, $list_data[$k][$this->modelClass]['perm_id'])) {
                    $list_data[$k][$this->modelClass]['enable_print_perm'] = 1;
                }
                if (in_array(EXPORT_EXEL_PERM_ID, $list_data[$k][$this->modelClass]['perm_id'])) {
                    $list_data[$k][$this->modelClass]['enable_export_exel_perm'] = 1;
                }
            } else {
                $list_data[$k][$this->modelClass]['perm_id'] = array();
            }
            if (!empty($v['RolesStatus'])) {
                $list_data[$k][$this->modelClass]['status_id'] = Hash::extract($v['RolesStatus'], '{n}.status_id');
            } else {
                $list_data[$k][$this->modelClass]['status_id'] = array();
            }
        }
    }

    public function reqAdd() {

        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $this->setInit();
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
            $this->setInit();
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
                $this->parseData($this->request->data, $id);
                $render = $this->render('req_edit');
                $res['data']['html'] = $render->body();
                echo json_encode($res);
                exit();
            }
            echo json_encode($res);
        }
    }

    protected function parseData(&$data, $id) {

        if (empty($data)) {
            return;
        }
        $v = $this->{$this->modelClass}->find('first', array(
            'recursive' => -1,
            'contain' => array(
                'RolesPerm', 'RolesStatus',
            ),
            'conditions' => array(
                $this->modelClass . '.id' => $id,
            ),
        ));
        $data[$this->modelClass]['enable_print_perm'] = 0;
        $data[$this->modelClass]['enable_export_exel_perm'] = 0;
        if (!empty($v['RolesPerm'])) {
            $data[$this->modelClass]['perm_id'] = Hash::extract($v['RolesPerm'], '{n}.perm_id');
            if (in_array(PRINT_PERM_ID, $data[$this->modelClass]['perm_id'])) {
                $data[$this->modelClass]['enable_print_perm'] = 1;
            }
            if (in_array(EXPORT_EXEL_PERM_ID, $data[$this->modelClass]['perm_id'])) {
                $data[$this->modelClass]['enable_export_exel_perm'] = 1;
            }
        } else {
            $data[$this->modelClass]['perm_id'] = array();
        }
        if (!empty($v['RolesStatus'])) {
            $data[$this->modelClass]['status_id'] = Hash::extract($v['RolesStatus'], '{n}.status_id');
        } else {
            $data[$this->modelClass]['status_id'] = array();
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
                $res['message'] = __('');
            }
            echo json_encode($res);
        }
    }

}
