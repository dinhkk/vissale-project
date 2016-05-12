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
        'RolesPerm',
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

        $options['recursive'] = 1;
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
        $this->set('list_data', $list_data);
        $this->set('page_title', __('role_title'));
    }

}
