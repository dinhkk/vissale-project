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
			'FBPage',
			'FBCronConfig' 
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
		$options ['conditions'] ['FBPosts.group_id'] = $this->_getGroup ();
		$list_post = $this->FBPosts->find('all', $options);
		// cat bo page_id ra khoi post_id
		if ($list_post){
		    foreach ($list_post as &$post){
		        $post['post_id'] = $this->_getPostIdForView($post['post_id']);
		    }
		}
		$this->set ( 'posts', $list_post );
	}
	private function _initData() {
		$group_id = $this->_getGroup ();
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
		$pages = $this->FBPage->find ( 'list', array (
		    'conditions' => array (
		        'FBPage.group_id' => $group_id
		    ),
		    'fields' => array (
		        'FBPage.id',
		        'FBPage.page_name'
		    )
		) );
		$this->set ( 'pages', $pages );
	}
	private function _getPostIdForView($post_id){
	    $post_id = explode('_', $post_id);
	    return $post_id[1];
	}
	public function edit() {
		$this->layout = 'ajax';
		$id = intval ( $this->request->query ['id'] );
		$options = array ();
		$options ['conditions'] ['FBPosts.group_id'] = 1;
		$options ['conditions'] ['FBPosts.id'] = $id;
		$post = $this->FBPosts->find ( 'first', $options );
		if ($post)
		    $post['post_id'] = $this->_getPostIdForView($post['post_id']);
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
		if ($post)
		    $post['post_id'] = $this->_getPostIdForView($post['post_id']);
		$this->set ( 'post', $post );
		$this->_initEditData ();
	}
	public function editPost() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$post_id = $this->request->data ['post_id'];
		$fb_page_id = $this->request->data ['fb_page_id'];
	    $fb_page_id = $this->request->data ['fb_page_id'];
		$post_id = $this->_validatePost($post_id, $fb_page_id);
		if (!$post_id){
		    return -1;
		}
		$post_data = explode('_', $post_id);
		$page_id = $post_data[0];
		if (!$page_id){
		    return -2;
		}
		$this->request->data ['page_id'] = $page_id;
		$this->request->data ['fb_page_id'] = $fb_page_id;
		$this->request->data ['post_id'] = $post_id;
		if ($this->FBPosts->save ( $this->request->data, true )) {
			return 1;
		}
		return 0;
	}
	private function _validatePost($post_id, $fb_page_id) {
		// lay page tu post_id
		$validate_post_api = Configure::read ( 'sysconfig.FBPost.VALIDATE_POST' );
		$post_id = file_get_contents ( "{$validate_post_api}?post_id={$post_id}&db_page_id=$fb_page_id" );
		if ($post_id){
		    $post_id = json_decode($post_id, true);
		    if ($post_id){
		        if ($post_id['post_id']){
		            return $post_id['post_id'];
		        }
		    }
		}
		return false;
	}
	public function addPost() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = $this->_getGroup ();
		$this->request->data ['group_id'] = $group_id;
		$post_id = $this->request->data ['post_id'];
		$fb_page_id = $this->request->data ['fb_page_id'];
		$post_id = $this->_validatePost($post_id, $fb_page_id);
		if (!$post_id){
		    return -3;
		}
		$post_data = explode('_', $post_id);
		$page_id = $post_data[0];
		if (!$page_id){
		    return -2;
		}
		// lay config
		$config = $this->FBCronConfig->find ( 'first', array (
				'conditions' => array (
						'FBCronConfig.group_id' => $group_id 
				) 
		) );
		if (! $config) {
			return - 1;
		}
		if (empty ( $this->request->data ['answer_phone'] ))
			$this->request->data ['answer_phone'] = $config ['answer_phone'];
		if (empty ( $this->request->data ['answer_nophone'] ))
			$this->request->data ['answer_nophone'] = $config ['answer_nophone'];
		$this->request->data ['hide_phone_comment'] = $config ['hide_phone_comment'];
		$this->request->date['last_time_fetch_comment'] = time();
		$this->request->date['next_time_fetch_comment'] = time();
		$this->request->data ['page_id'] = $page_id;
		$this->request->data ['fb_page_id'] = $fb_page_id;
		$this->request->data ['post_id'] = $post_id;
		if ($this->FBPosts->save ( $this->request->data, true )) {
			return 1;
		}
		return 0;
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
		$group_id = $this->_getGroup ();
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
		$pages = $this->FBPage->find ( 'list', array (
		    'conditions' => array (
		        'FBPage.group_id' => $group_id
		    ),
		    'fields' => array (
		        'FBPage.id',
		        'FBPage.page_name'
		    )
		) );
		$this->set ( 'pages', $pages );
	}
}
