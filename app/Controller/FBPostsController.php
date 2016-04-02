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
			'FBPosts'
	);
	public $components = array (
			'Paginator',
			'RequestHandler'
	);
	public function index() {
		$this->_initData();
		$options = array ();
		$options ['order'] = array (
				'FBPosts.created' => 'DESC'
		);
		$options ['conditions'] ['FBPosts.group_id'] = 1;
		$this->Paginator->settings = $options;
		$list_post = $this->Paginator->paginate ( 'FBPosts' );
		$this->set ( 'posts', $list_post );
	}
	private function _initData(){
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
}
