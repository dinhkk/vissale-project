<?php
App::uses('AppController', 'Controller');
/**
 * Roles Controller
 *
 * @property Role $Role
 * @property PaginatorComponent $Paginator
 */
class RolesController extends AppController {

	public $uses = array('Role','User', 'UsersRole');
/**
 * Components
 *
 * @var array
 */
	//public $components = array('Paginator');

	public function beforeFilter() {
		//Configure AuthComponent
		parent::beforeFilter();

	}

	protected function setInit() {
		$this->set('model_class', $this->modelClass);
		$this->set('page_title', __('role_page_title'));

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {

		$this->Role->recursive = 0;

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
			'title' => __('role_page_title'),
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
		$user = CakeSession::read('Auth.User');
		if ( $user['is_group_admin'] == true ){
			$this->set("action", true);
		}
		//var_dump($list_data);
		//die;
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid role'));
		}
		$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
		$this->set('role', $this->Role->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
				$this->Flash->success(__('The role has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The role could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Role->save($this->request->data)) {
				$this->Flash->success(__('The role has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The role could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
			$this->request->data = $this->Role->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Role->delete()) {
			$this->Flash->success(__('The role has been deleted.'));
		} else {
			$this->Flash->error(__('The role could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
