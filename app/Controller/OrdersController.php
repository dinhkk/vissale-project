<?php
App::uses ( 'AppController', 'Controller' );
/**
 * Orders Controller
 */
class OrdersController extends AppController {
	public $components = array (
			'Paginator' 
	);
	
	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $uses = array (
			'Orders',
			'ShippingServices',
			'Statuses' 
	);
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
		if ($list_order) {
			$this->_initOrderData ();
		}
	}
	private function _initOrderData() {
		
// 			// lay danh sach status
// 		$statuses = $this->Statuses->find ( 'all' );
// 		$this->set ( 'statuses', $statuses );
// 		$shipping_services = $this->ShippingServices->find ( 'all' );
// 		$this->set ( 'shipping_services', $shipping_services );
	}
}
