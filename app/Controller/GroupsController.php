<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property 'SecurityComponent $'Security
 * @property RequestHandler'Component $RequestHandler'
 * @property SessionComponent $Session
 */
class GroupsController extends AppController {

	public $uses = ['Group'];
/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Text', 'Js', 'Time');

/**
 * Components
 *
 * @var array
 **/
	public $components = array('Paginator', 'Flash', 'RequestHandler', 'Session');


	protected function setInit() {
		$this->set('model_class', $this->modelClass);
		$this->set('page_title', __('Quản lý group'));
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->setInit();
		$this->Group->recursive = 0;
		$this->set('groups', $this->Paginator->paginate());
		//
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
		$this->set('group', $this->Group->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Flash->success(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The group could not be saved. Please, try again.'));
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
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->save($this->request->data)) {
				$this->Flash->success(__('The group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Group->delete()) {
			$this->Flash->success(__('The group has been deleted.'));
		} else {
			$this->Flash->error(__('The group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	//add parent save data
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
		if (! $this->{$this->modelClass}->exists ( $id )) {
			throw new NotFoundException ( __ ( 'invalid_data' ) );
		}
		$this->autoRender = false;
		if ($this->request->is ( 'ajax' )) {
			$res = array ();
			$save_data = $this->request->data;
			if ($this->{$this->modelClass}->save ( $save_data )) {
				$res ['error'] = 0;
				$res ['data'] = null;
			} else {
				$res ['error'] = 1;
				$res ['data'] = array (
					'validationErrors' => $this->{$this->modelClass}->validationErrors
				);
				$this->layout = 'ajax';
				$this->set ( 'model_class', $this->modelClass );
				$this->set ( 'id', $id );
				$render = $this->render ( 'req_edit' );
				$res ['data'] ['html'] = $render->body ();
				echo json_encode ( $res );
				exit ();
			}
			echo json_encode ( $res );
		}
	}
}
