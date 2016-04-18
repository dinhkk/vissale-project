<?php
App::uses ( 'AppController', 'Controller' );
class FBPostsController extends AppController {
	
	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $scaffold;
	public $uses = array (
			'Products',
			'Bundles',
			'FBPosts',
			'FBPage' 
	);
	public $components = array (
			'Paginator',
			'RequestHandler' 
	);
	public function index() {
		$this->_initData ();
		$options = array ();
		$options ['order'] = array (
				'FBPosts.created' => 'DESC' 
		);
		$options ['conditions'] ['FBPosts.group_id'] = 1;
		$this->Paginator->settings = $options;
		$list_post = $this->Paginator->paginate ( 'FBPosts' );
		$this->set ( 'posts', $list_post );
	}
	private function _initData() {
		$group_id = 1;
		$bundles = $this->Bundles->find ( 'list', array (
				'conditions' => array (
						'Bundles.group_id' => $group_id 
				),
				'fields' => array (
						'Bundles.id',
						'Bundles.name' 
				) 
		) );
		$this->set ( 'bundles', $bundles );
	}
	public function edit() {
		$this->layout = 'ajax';
		$id = intval ( $this->request->query ['id'] );
		$options = array ();
		$options ['conditions'] ['FBPosts.group_id'] = 1;
		$options ['conditions'] ['FBPosts.id'] = $id;
		$post = $this->FBPosts->find ( 'first', $options );
		$this->set ( 'post', $post );
		$this->_initEditData ();
	}
	public function add() {
		$this->layout = 'ajax';
		$this->_initEditData ();
	}
	public function copy() {
		$this->layout = 'ajax';
		$id = intval ( $this->request->query ['id'] );
		$options = array ();
		$options ['conditions'] ['FBPosts.group_id'] = 1;
		$options ['conditions'] ['FBPosts.id'] = $id;
		$post = $this->FBPosts->find ( 'first', $options );
		$this->set ( 'post', $post );
		$this->_initEditData ();
	}
	public function editPost() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$post_id = $this->request->data ['post_id'];
		$page = $this->_getPageByPost($post_id);
		if (!$page){
			return 0;
		}
		$this->request->data ['page_id'] = $page['page_id'];
		$this->request->data ['fb_page_id'] = $page['fb_page_id'];
		$this->request->data ['post_id'] = "{$page['page_id']}_{$post_id}";
		if ($this->FBPosts->save ( $this->request->data, true )) {
			return 1;
		}
		return 0;
	}
	private function _getPageByPost($post_id) {
		// lay page tu post_id
		$detect_page_from_post_api = Configure::read ( 'sysconfig.FBPost.GET_PAGE_ID_BY_POST' );
		$page_id = file_get_contents ( "{$detect_page_from_post_api}?post_id={$post_id}" );
		if (empty ( $page_id )) {
			// khong lay duoc page
			return false;
		}
		// lay fb_page_id theo page_id
		$options = array (
				'conditions' => array (
						'FBPage.page_id' => $page_id 
				) 
		);
		$page = $this->FBPage->find ( 'first', $options );
		if (! $page) {
			// page khong ton tai tren he thong
			return false;
		}
		if ($page ['FBPage'] ['status'] !== '0') {
			// page khong duoc active
			return false;
		}
		$fb_page_id = $page ['FBPage'] ['id'];
		return array(
				'page_id'=>$page_id,
				'fb_page_id'=>$fb_page_id
		);
	}
	public function addPost() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = 1;
		$this->request->data ['group_id'] = $group_id;
		$post_id = $this->request->data ['post_id'];
		$page = $this->_getPageByPost($post_id);
		if (!$page){
			return -1;
		}
		$this->request->data ['page_id'] = $page['page_id'];
		$this->request->data ['fb_page_id'] = $page['fb_page_id'];
		$this->request->data ['post_id'] = "{$page['page_id']}_{$post_id}";
		if ($this->FBPosts->save ( $this->request->data, true )) {
			return 1;
		}
		return json_encode($page);
	}
	public function delete() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		if ($this->FBPosts->delete ( $this->request->query ['id'] )) {
			return 1;
		}
		return 0;
	}
	private function _initEditData() {
		$group_id = 1;
		$bundles = $this->Bundles->find ( 'list', array (
				'conditions' => array (
						'Bundles.group_id' => $group_id 
				),
				'fields' => array (
						'Bundles.id',
						'Bundles.name' 
				) 
		) );
		$this->set ( 'bundles', $bundles );
		$products = $this->Products->find ( 'list', array (
				'conditions' => array (
						'Products.group_id' => $group_id 
				),
				'fields' => array (
						'Products.id',
						'Products.name' 
				) 
		) );
		$this->set ( 'products', $products );
	}
}
