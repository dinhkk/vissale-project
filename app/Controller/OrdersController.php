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
				'Orders.created' => 'DESC' 
		);
		$options ['conditions'] ['Orders.group_id'] = 1;
		$this->Paginator->settings = $options;
		$list_order = $this->Paginator->paginate ( 'Orders' );
		//$orderData = $this->_initOrderData ();
		$this->set ( 'orders', $list_order );
	}
	private function _initOrderData() {
		
		// lay danh sach status
		$statuses = $this->Statuses->find ( 'all' );
		$this->set ( 'statuses', $statuses );
		$shipping_services = $this->ShippingServices->find ( 'all' );
		$this->set ( 'shipping_services', $shipping_services );
		return array (
				'statuses' => $statuses,
				'shipping_services' => $shipping_services 
		);
	}
}
