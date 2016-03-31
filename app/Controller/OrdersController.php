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
			'Statuses',
			'Bundles',
			'Users',
			'Products' 
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
		$this->_initOrderData ();
		$this->set ( 'orders', $list_order );
	}
	private function _initOrderData() {
		$group_id = 1;
		// lay danh sach status
		$statuses = $this->Statuses->find ( 'all', array (
				'conditions' => array (
						'Statuses.group_id' => $group_id 
				) 
		) );
		$this->set ( 'statuses', $statuses );
		$shipping_services = $this->ShippingServices->find ( 'all', array (
				'conditions' => array (
						'ShippingServices.group_id' => $group_id 
				) 
		) );
		$this->set ( 'shipping_services', $shipping_services );
		$bundles = $this->Bundles->find ( 'all', array (
				'conditions' => array (
						'Bundles.group_id' => $group_id 
				) 
		) );
		$this->set ( 'bundles', $bundles );
		$users = $this->Users->find ( 'all', array (
				'conditions' => array (
						'Users.status' => 0,
						'Users.group_id' => $group_id 
				) 
		) );
		$this->set ( 'users', $users );
	}
	public function view() {
		$order_id = intval ( $this->request->query ['order_id'] );
		$group_id = 1;
		$options = array ();
		$options ['conditions'] ['Orders.group_id'] = $group_id;
		$options ['conditions'] ['Orders.id'] = $order_id;
		$this->Paginator->settings = $options;
		$order = $this->Orders->find ( 'first', $options );
		$this->_initOrderData ();
		$this->set ( 'order', $order );
	}
	public function add() {
		$group_id = 1;
		$options = array ();
		$options ['conditions'] ['Orders.group_id'] = $group_id;
		$options ['conditions'] ['Orders.id'] = $order_id;
		$this->Paginator->settings = $options;
		$this->_initOrderData ();
		// lay default status
		$statuses = $this->viewVars ['statuses'];
		foreach ( $statuses as $stt ) {
			if ($stt ['Statuses'] ['is_default']) {
				$this->set ( 'default_status', array (
						'id' => $stt ['Statuses'] ['id'],
						'name' => $stt ['Statuses'] ['name'] 
				) );
				break;
			}
		}
	}
	
	// ajax thay doi trang thai cua don hang: Xac nhan, chuyen hang, huy, ...
	public function setStatus() {
		$this->autoRender = false;
		$order_id = intval ( $this->request->query ['order_id'] );
		$status = intval ( $this->request->query ['status'] );
		$this->Orders->id = $order_id;
		if ($this->Orders->saveField ( 'status', $status )) {
			return 1;
		}
		return 0;
	}
}
