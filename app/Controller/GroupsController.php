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

	public $uses = ['Group','User'];
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
			'title' => __('user_title'),
			'url' => Router::url(array('action' => $this->action)),
		);
		$this->set('breadcrumb', $breadcrumb);

		$options = array(
			'order' => array(
				'modified' => 'DESC',
			),
		);
		//$options['recursive'] = -1;
		$page = $this->request->query('page');
		if (!empty($page)) {
			$options['page'] = $page;
		}
		$limit = $this->request->query('limit');
		if (!empty($limit)) {
			$options['limit'] = $limit;
		}
		$options['joins'] = array(
			array('table' => 'users',
				'alias' => 'User',
				'type' => 'INNER',
				'conditions' => array(
					'Group.code = User.username',
				)
			)
		);
		$options['fields'] = ["Group.*", "User.*"];
		//$this->Prg->commonProcess();
		//$options['conditions'] = $this->{$this->modelClass}->parseCriteria($this->Prg->parsedParams());
		//$options ['conditions'] ['group_id'] = $this->_getGroup();
		$this->Paginator->settings = $options;

		$list_data = $this->Paginator->paginate();
		//var_dump($list_data); die;
		$this->set('groups', $list_data);

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

	//add parent save data
	public function reqAdd() {

		$this->autoRender = false;

		if ($this->request->is('ajax')) {
			$res = array();
			$save_data = $this->request->data;

			$dataSource = $this->Group->getDataSource();
			$dataSource->begin();

			if ($this->{$this->modelClass}->save($save_data)) {
				
				//active webhook when create group
				$test = file_get_contents( Configure::read('sysconfig.FBPage.FB_ACTIVE_PAGE').$this->Group->id );
				if ( intval($test)==1 ) {
					$dataSource->commit();
					$res['error'] = 0;
					$res['data'] = null;
				} else {
					$dataSource->rollback();
					$res['error'] = 1;
					$res['data'] = "Không thể tạo mới goup, hãy thử lại sai vài phút !";
				}


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

			//change group admin pw
			if ( !empty($save_data['action']) && $save_data['action']=="change_password" ) :
				if ( $this->comparePasswords($save_data)==true ){

					$this->User->read( null, $save_data['user_id'] );
					$this->User->set('password', $save_data['new_password']);
					$save = $this->User->save();
					if ($save){
						$this->updatedUserSuccess($save_data);
					} else {
						$this->updateUserFail($save_data);
					}


				} else {
					$this->updateUserFail($save_data);
				}
				die;
			endif;
			//#end change password

			if ($this->{$this->modelClass}->save( $save_data )) {

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

	public function reqDelete($id = null) {
		if (!$this->{$this->modelClass}->exists($id)) {
			throw new NotFoundException(__('invalid_data'));
		}
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$res = array();
			if ($this->{$this->modelClass}->delete($id)) {
				//deactivate all users
				$this->User->updateAll(
					array('User.status' => '0'),
					array('User.group_id' => $id)
				);
				$res ['error'] = 0;
				$res ['data'] = null;
			} else {
				$res ['error'] = 1;
				$res ['data'] = null;
			}
			echo json_encode($res);
		}
	}

	protected function updatedUserSuccess($data)
	{
		$res ['error'] = 0;
		$res ['data'] = null;
		$res['data']['msg'] = "ok";
		echo json_encode ( $res );
		exit();
	}

	protected function updateUserFail($data)
	{
		$res['error'] = 1;
		$res['data'] = array(
			'validationErrors' => $this->{$this->modelClass}->validationErrors,
		);
		$this->layout = 'ajax';
		$this->set('model_class', $this->modelClass);
		$this->set('id', $data['id']);
		$render = $this->render('req_edit');
		$res['data']['error_msg'] = __('Passwords not matched');
		echo json_encode($res);
		exit();
	}


	/**
	 * @param $save_data
	 * @return bool
	 */
	protected function comparePasswords($save_data)
	{

		if(!empty($save_data['new_password']) && !empty($save_data['re_password'])) {
			$test = strcmp($save_data['re_password'], $save_data['new_password']);
			if ($test==0) return true;
		}
		
		return false;
	}
}
