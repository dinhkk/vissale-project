<?php
App::uses ( 'AppController', 'Controller' );
class ProductsController extends AppController {
	public $uses = array (
			'Product',
			'Bundle',
			'Unit' 
	);
	public function index() {
		if ($this->request->is ( 'ajax' )) {
			$this->layout = 'ajax';
		}
		$this->setInit ();
		$page_title = __ ( 'product_title' );
		$this->set ( 'page_title', $page_title );
		
		$breadcrumb = array ();
		$breadcrumb [] = array (
				'title' => __ ( 'home_title' ),
				'url' => Router::url ( array (
						'controller' => 'DashBoard',
						'action' => 'index' 
				) ) 
		);
		$breadcrumb [] = array (
				'title' => __ ( 'product_title' ),
				'url' => Router::url ( array (
						'action' => $this->action 
				) ) 
		);
		$this->set ( 'breadcrumb', $breadcrumb );
		
		$options = array (
				'order' => array (
						'modified' => 'DESC' 
				) 
		);
		$options ['recursive'] = - 1;
		$page = $this->request->query ( 'page' );
		if (! empty ( $page )) {
			$options ['page'] = $page;
		}
		$limit = $this->request->query ( 'limit' );
		if (! empty ( $limit )) {
			$options ['limit'] = $limit;
		}
		$this->Prg->commonProcess ();
		$options ['conditions'] = $this->{$this->modelClass}->parseCriteria ( $this->Prg->parsedParams () );

		$this->Paginator->settings = $options;
		
		$list_data = $this->Paginator->paginate ();
		$this->set ( 'list_data', $list_data );
	}
	public function reqAdd() {
		$this->autoRender = false;
		
		if ($this->request->is ( 'ajax' )) {
			$this->setInit ();
			$res = array ();
			$save_data = $this->request->data;

			if ($this->{$this->modelClass}->save ( $save_data )) {
				$res ['error'] = 0;
				$res ['data'] = null;
				echo json_encode ( $res );
			} else {
				$res ['error'] = 1;
				$res ['data'] = array (
						'validationErrors' => $this->{$this->modelClass}->validationErrors 
				);
				$this->layout = 'ajax';
				$this->set ( 'model_class', $this->modelClass );
				$render = $this->render ( 'req_add' );
				$res ['data'] ['html'] = $render->body ();
				echo json_encode ( $res );
				exit ();
			}
		}
	}
	public function reqEdit($id = null) {
		if (! $this->{$this->modelClass}->exists ( $id )) {
			throw new NotFoundException ( __ ( 'invalid_data' ) );
		}
		$this->autoRender = false;
		if ($this->request->is ( 'ajax' )) {
			$this->setInit ();
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
	public function reqClone($id = null) {
		$data = $this->{$this->modelClass}->find ( 'first', array (
				'recursive' => - 1,
				'conditions' => array (
						'id' => $id 
				) 
		) );
		if (empty ( $data )) {
			throw new NotFoundException ( __ ( 'invalid_data' ) );
		}
		$this->autoRender = false;
		if ($this->request->is ( 'ajax' )) {
			$this->setInit ();
			$res = array ();
			$save_data = Hash::merge ( $data [$this->modelClass], $this->request->data );
			unset ( $save_data ['id'] );
			// thực hiện xóa validate cho code
			$this->Product->validator ()->remove ( 'code', 'isUnique' );
			$this->Product->clone = 1;
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
				$render = $this->render ( 'req_clone' );
				$res ['data'] ['html'] = $render->body ();
				echo json_encode ( $res );
				exit ();
			}
			echo json_encode ( $res );
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
	protected function setInit() {
		$this->set ( 'model_class', $this->modelClass );
		
		$units = $this->Unit->find ( 'list');
		$this->set ( 'units', $units );
		
		$bundles = $this->Bundle->find ( 'list');


		$this->set ( 'bundles', $bundles );
	}
}
