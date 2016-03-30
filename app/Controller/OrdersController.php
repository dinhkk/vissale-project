<?php
App::uses ( 'AppController', 'Controller' );
/**
 * Orders Controller
 */
class OrdersController extends AppController {
	
	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $scaffold;
	public function index() {
		$options = array ();
		$options ['order'] = array (
				'created' => 'DESC' 
		);
		$options ['conditions'] ['group_id'] = 1;
		$this->Paginator->settings = $options;
		$list_order = $this->Paginator->paginate ( 'Orders' );
		$this->set ( 'orders', $list_order );
	}
}
