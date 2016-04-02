<?php
App::uses ( 'AppController', 'Controller' );
/**
 * Orders Controller
 */
class OrdersController extends AppController {
	public $components = array (
			'Paginator',
			'RequestHandler'
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
			'Products',
			'OrderProducts' 
	);
	public $scaffold;
	public function index() {
		$group_id = 1;
		$options = array ();
		$options ['order'] = array (
				'Orders.created' => 'DESC' 
		);
		$options ['conditions'] ['Orders.group_id'] = $group_id;
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
				),
				'fields' => array (
						'Statuses.id',
						'Statuses.name' 
				) 
		) );
		$this->set ( 'statuses', $statuses );
		$shipping_services = $this->ShippingServices->find ( 'all', array (
				'conditions' => array (
						'or' => array (
								'ShippingServices.group_id' => $group_id,
								'ShippingServices.group_id' => 1 
						) 
				),
				'fields' => array (
						'ShippingServices.id',
						'ShippingServices.name' 
				) 
		) );
		$this->set ( 'shipping_services', $shipping_services );
		$bundles = $this->Bundles->find ( 'all', array (
				'conditions' => array (
						'Bundles.group_id' => $group_id 
				),
				'fields' => array (
						'Bundles.id',
						'Bundles.name' 
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
	private function _initOrderDataList() {
		$group_id = 1;
		// lay danh sach status
		$statuses = $this->Statuses->find ( 'list', array (
				'conditions' => array (
						'or' => array (
								'Statuses.group_id' => $group_id,
								'Statuses.group_id' => 1 
						) 
				),
				'fields' => array (
						'Statuses.id',
						'Statuses.name' 
				) 
		) );
		$this->set ( 'statuses', $statuses );
		$shipping_services = $this->ShippingServices->find ( 'list', array (
				'conditions' => array (
						'ShippingServices.group_id' => $group_id 
				),
				'fields' => array (
						'ShippingServices.id',
						'ShippingServices.name' 
				) 
		) );
		$this->set ( 'shipping_services', $shipping_services );
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
		$users = $this->Users->find ( 'list', array (
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
		$this->_initOrderDataList ();
		// lay default status
		$statuses = $this->viewVars ['statuses'];
		foreach ( $statuses as $id => $stt ) {
			if ($id == 1) {
				$this->set ( 'default_status', array (
						'id' => $id,
						'name' => $stt 
				) );
				break;
				
			}
		}
	}
	
	// ajax thay doi trang thai cua don hang: Xac nhan, chuyen hang, huy, ...
	public function setStatus() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$order_id = intval ( $this->request->query ['order_id'] );
		$status = intval ( $this->request->query ['status'] );
		$this->Orders->id = $order_id;
		if ($this->Orders->saveField ( 'status_id', $status )) {
			return 1;
		}
		return 0;
	}
	public function ajax_listproduct() {
		$this->layout = 'ajax';
		$products = $this->Products->find ( 'all' );
		$this->set ( 'products', $products );
	}
	public function update() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$data = array ();
		$order_id = $this->request->data ['order_id'];
		$postal_code = $this->request->data ['postal_code'];
		$data ['postal_code'] = $postal_code ? $postal_code : '';
		$customer_name = $this->request->data ['customer_name'];
		$data ['customer_name'] = $customer_name ? $customer_name : '';
		$mobile = $this->request->data ['mobile'];
		$data ['mobile'] = $mobile ? $mobile : '';
		$address = $this->request->data ['address'];
		$data ['address'] = $address ? $address : '';
		$city = $this->request->data ['city'];
		$data ['city'] = $city ? $city : '';
		$note1 = $this->request->data ['note1'];
		$data ['note1'] = $note1 ? $note1 : '';
		$note2 = $this->request->data ['note2'];
		$data ['note2'] = $note2 ? $note2 : '';
		$cancel_note = $this->request->data ['cancel_note'];
		$data ['cancel_note'] = $cancel_note ? $cancel_note : '';
		$shipping_note = $this->request->data ['shipping_note'];
		$data ['shipping_note'] = $shipping_note ? $shipping_note : '';
		$is_top_priority = $this->request->data ['is_top_priority'];
		$data ['is_top_priority'] = $is_top_priority ? 1 : 0;
		$shipping_service_id = $this->request->data ['shipping_service_id'];
		$data ['shipping_service_id'] = $shipping_service_id ? intval ( $shipping_service_id ) : 0;
		$is_send_sms = $this->request->data ['is_send_sms'];
		$data ['is_send_sms'] = $is_send_sms ? 1 : 0;
		$is_inner_city = $this->request->data ['is_inner_city'];
		$data ['is_inner_city'] = $is_inner_city ? 1 : 0;
		$bundle_id = $this->request->data ['bundle_id'];
		$data ['bundle_id'] = $bundle_id ? intval ( $bundle_id ) : 0;
		$status_id = $this->request->data ['status_id'];
		$data ['status_id'] = $status_id ? intval ( $status_id ) : 0;
		$discount_price = $this->request->data ['discount_price'];
		$data ['discount_price'] = $discount_price ? intval ( $discount_price ) : 0;
		$shipping_price = $this->request->data ['shipping_price'];
		$data ['shipping_price'] = $shipping_price ? intval ( $shipping_price ) : 0;
		$other_price = $this->request->data ['other_price'];
		$data ['other_price'] = $other_price ? intval ( $other_price ) : 0;
		$price = $this->request->data ['price']?intval($this->request->data ['price']):0;
		$data['price'] = $price?intval($price):0;
		$total_price = $this->request->data ['total_price']?intval($this->request->data ['total_price']):0;
		$data['total_price'] = $total_price;
		$order_product = $this->request->data ['order_product'];
		$current_date = date ( 'Y-m-d H:i:s' );
		$data ['modified'] = $current_date;
		$saveData = null;
		if ($order_product == '-1') {
			// khong co su thay doi
		} else {
			if (! $order_product) {
				// xoa het du lieu
				// $this->Products->deleteAll ( array (
				// 'order_id' => $order_id
				// ), false );
				if (! $this->OrderProducts->deleteAll ( array (
						'OrderProducts.order_id' => $order_id
				), false )) {
					$orderDataSource->rollback ();
					return 0;
				}
				return 1;
			} else {
				// $order_product = id_sl,id_sl
				$prd_list = explode ( ',', $order_product );
				echo $order_product;
				if (is_array ( $prd_list )) {
					foreach ( $prd_list as $prd ) {
						$prd = explode ( '_', $prd );
						if (! is_array ( $prd )) {
							return 0;
						}
						$product_id = intval ( $prd [0] );
						$qty = intval ( $prd [1] );
						if (! $product_id || ! $qty) {
							return 0;
						}
						$orderDataSource = $this->Orders->getDataSource ();
						$orderDataSource->begin ();
						// xoa du lieu cu truoc
						if (! $this->OrderProducts->deleteAll ( array (
								'OrderProducts.order_id' => $order_id 
						), false )) {
							$orderDataSource->rollback ();
							return 0;
						}
						// kiem tra xem order;product da co hay chua?
						if ($up = $this->OrderProducts->find ( 'first', array (
								'conditions' => array (
										'OrderProducts.order_id' => $order_id,
										'OrderProducts.product_id' => $product_id 
								) 
						) )) {
							// da ton tai
							if ($up ['OrderProducts']) {
								// thay doi so luong
								if ($up ['OrderProducts'] ['qty'] != $qty) {
									if (! $this->OrderProducts->save ( array (
											'id' => $up ['OrderProducts'] ['id'],
											'qty' => $qty,
											'modified' => date ( 'Y-m-d H:i:s' ) 
									) )) {
										$orderDataSource->rollback ();
										return 0;
									}
								} else {
									// so luong khong doi
									continue;
								}
							} else {
								// khong ton tai
								$orderDataSource->rollback ();
								return 0;
							}
						} else {
							// Lay don gia cho san pham do
							
							$product = $this->Products->find ( 'first', array (
									'Products.id' => $product_id 
							) );
							if ($product ['Products']) {
								// Them moi san pham
								$saveData [] = array (
										'product_id' => $product_id,
										'order_id' => $order_id,
										'qty' => $qty,
										'product_price' => $product ['Products'] ['price'],
										'created' => date ( 'Y-m-d H:i:s' ),
										'modified' => date ( 'Y-m-d H:i:s' ) 
								);
							} else {
								// khong ton tai san pham => bo qua
								$orderDataSource->rollback ();
								return 0;
							}
						}
					}
				}
			}
		}
		if ($saveData) {
			if (! $this->OrderProducts->saveAll ( $saveData )) {
				$orderDataSource->rollback ();
				return 0;
			}
		}
		$this->Orders->id = $order_id;
		if ($this->Orders->save ( $data )) {
			$orderDataSource->commit ();
			return 1;
		}
		$orderDataSource->rollback ();
		return 0;
	}
	private function _generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen ( $characters );
		$randomString = '';
		for($i = 0; $i < $length; $i ++) {
			$randomString .= $characters [rand ( 0, $charactersLength - 1 )];
		}
		return $randomString;
	}
	public function addOrder() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = 1;
		$data = array (
				'group_id' => $group_id 
		);
		$data ['code'] = $this->_generateRandomString ( 10 );
		$postal_code = $this->request->data ['postal_code'];
		$data ['postal_code'] = $postal_code ? $postal_code : '';
		$customer_name = $this->request->data ['customer_name'];
		$data ['customer_name'] = $customer_name ? $customer_name : '';
		$mobile = $this->request->data ['mobile'];
		$data ['mobile'] = $mobile ? $mobile : '';
		$address = $this->request->data ['address'];
		$data ['address'] = $address ? $address : '';
		$city = $this->request->data ['city'];
		$data ['city'] = $city ? $city : '';
		$note1 = $this->request->data ['note1'];
		$data ['note1'] = $note1 ? $note1 : '';
		$note2 = $this->request->data ['note2'];
		$data ['note2'] = $note2 ? $note2 : '';
		$cancel_note = $this->request->data ['cancel_note'];
		$data ['cancel_note'] = $cancel_note ? $cancel_note : '';
		$shipping_note = $this->request->data ['shipping_note'];
		$data ['shipping_note'] = $shipping_note ? $shipping_note : '';
		$is_top_priority = $this->request->data ['is_top_priority'];
		$data ['is_top_priority'] = $is_top_priority ? 1 : 0;
		$shipping_service_id = $this->request->data ['shipping_service_id'];
		$data ['shipping_service_id'] = $shipping_service_id ? intval ( $shipping_service_id ) : 0;
		$is_send_sms = $this->request->data ['is_send_sms'];
		$data ['is_send_sms'] = $is_send_sms ? 1 : 0;
		$is_inner_city = $this->request->data ['is_inner_city'];
		$data ['is_inner_city'] = $is_inner_city ? 1 : 0;
		$bundle_id = $this->request->data ['bundle_id'];
		$data ['bundle_id'] = $bundle_id ? intval ( $bundle_id ) : 0;
		$status_id = $this->request->data ['status_id'];
		$data ['status_id'] = $status_id ? intval ( $status_id ) : 0;
		$discount_price = $this->request->data ['discount_price'];
		$data ['discount_price'] = $discount_price ? intval ( $discount_price ) : 0;
		$shipping_price = $this->request->data ['shipping_price'];
		$data ['shipping_price'] = $shipping_price ? intval ( $shipping_price ) : 0;
		$other_price = $this->request->data ['other_price'];
		$data ['other_price'] = $other_price ? intval ( $other_price ) : 0;
		$current_date = date ( 'Y-m-d H:i:s' );
		$data ['created'] = $current_date;
		$data ['modified'] = $current_date;
		$price = $this->request->data ['price']?intval($this->request->data ['price']):0;
		$data['price'] = $price?intval($price):0;
		$total_price = $this->request->data ['total_price']?intval($this->request->data ['total_price']):0;
		$data['total_price'] = $total_price;
		// Insert order
		$orderDataSource = $this->Orders->getDataSource ();
		$orderDataSource->begin ();
		if (! $this->Orders->save ( $data )) {
			$orderDataSource->rollback ();
			return 0;
		}
		$order_id = $this->Orders->getLastInsertId ();
		if (! $order_id) {
			$orderDataSource->rollback ();
			return 0;
		}
		// insert orders_products
		$order_product = $this->request->data ['order_product'];
		$saveData = null;
		if ($order_product == '-1') {
			// khong co su thay doi
			return 1;
		} else {
			if (! $order_product) {
				return 1;
			} else {
				// $order_product = id_sl,id_sl
				$prd_list = explode ( ',', $order_product );
				if (is_array ( $prd_list )) {
					foreach ( $prd_list as $prd ) {
						$prd = explode ( '_', $prd );
						if (! is_array ( $prd )) {
							$orderDataSource->rollback ();
							return 0;
						}
						$product_id = intval ( $prd [0] );
						$qty = intval ( $prd [1] );
						if (! $product_id || ! $qty) {
							$orderDataSource->rollback ();
							return 0;
						}
						// Lay don gia cho san pham do
						$product = $this->Products->find ( 'first', array (
								'conditions' => array (
										'Products.id' => $product_id 
								) 
						) );
						if (isset ( $product ['Products'] ) && ! empty ( $product ['Products'] )) {
							// Them moi san pham
							$saveData [] = array (
									'product_id' => $product_id,
									'order_id' => $order_id,
									'qty' => $qty,
									'product_price' => $product ['Products'] ['price'],
									'created' => date ( 'Y-m-d H:i:s' ),
									'modified' => date ( 'Y-m-d H:i:s' ) 
							);
						} else {
							// khong ton tai san pham => bo qua
							$orderDataSource->rollback ();
							return 0;
						}
					}
				} else {
					$orderDataSource->rollback ();
					return 0;
				}
			}
		}
		if (! $this->OrderProducts->saveAll ($saveData)) {
			// insert loi
			$orderDataSource->rollback ();
			return 0;
		}
		$orderDataSource->commit ();
		return 1;
	}
	public function search() {
		$this->layout = 'ajax';
		$group_id = 1;
		$options ['order'] = array (
				'Orders.created' => 'DESC' 
		);
		$options ['conditions'] ['Orders.group_id'] = $group_id;
		$data = array (
				'Orders.group_id' => $group_id 
		);
		$search_email_phone = $this->request->data ['search_email_phone'];
		if (! empty ( $search_email_phone ))
			$options ['conditions'] ['or'] = array (
					'Orders.mobile LIKE' => "%{$search_email_phone}%",
					'Orders.customer_name LIKE' => "%{$search_email_phone}%" 
			);
		$search_check_ngaytao = $this->request->data ['search_email_phone'] ? 1 : 0;
		if ($search_check_ngaytao) {
			$search_ngaytao_from = $this->request->data ['search_ngaytao_from'];
			$options ['conditions'] ['Orders.created >='] = $search_ngaytao_from;
			$search_ngaytao_to = $this->request->data ['search_ngaytao_to'];
			$options ['conditions'] ['Orders.created <='] = $search_ngaytao_to;
		}
		$search_check_chuyen = $this->request->data ['search_check_chuyen'] ? 1 : 0;
		if ($search_check_ngaytao) {
			$search_chuyen_from = $this->request->data ['search_chuyen_from'];
			$options ['conditions'] ['Orders.delivered >='] = $search_chuyen_from;
			$search_chuyen_to = $this->request->data ['search_chuyen_to'];
			$options ['conditions'] ['Orders.delivered <='] = $search_chuyen_to;
		}
		$search_check_xacnhan = $this->request->data ['search_check_xacnhan'] ? 1 : 0;
		if ($search_check_xacnhan) {
			$search_xacnhan_from = $this->request->data ['search_xacnhan_from'];
			$options ['conditions'] ['Orders.confirmed >='] = $search_xacnhan_from;
			$search_xacnhan_to = $this->request->data ['search_xacnhan_to'];
			$options ['conditions'] ['Orders.confirmed <='] = $search_xacnhan_to;
		}
		$seach_shipping_service_id = $this->request->data ['seach_shipping_service_id'];
		if ($seach_shipping_service_id) {
			$options ['conditions'] ['Orders.shipping_service_id'] = explode ( ',', $seach_shipping_service_id );
		}
		$search_status_id = $this->request->data ['search_status_id'];
		if ($search_status_id) {
			$options ['conditions'] ['Orders.status_id'] = explode ( ',', $search_status_id );
		}
		$seach_viettel = $this->request->data ['seach_viettel'] ? 1 : 0;
		if ($seach_viettel) {
			// $options ['conditions']['Orders.telco_id'] = 1;
		}
		$search_mobi = $this->request->data ['search_mobi'] ? 1 : 0;
		if ($search_mobi) {
			// $options ['conditions']['Orders.telco_id'] = 2;
		}
		$seach_vnm = $this->request->data ['seach_vnm'] ? 1 : 0;
		if ($seach_vnm) {
			// $options ['conditions']['Orders.telco_id'] = 3;
		}
		$seach_vina = $this->request->data ['seach_vina'] ? 1 : 0;
		if ($seach_vina) {
			// $options ['conditions']['Orders.telco_id'] = 4;
		}
		$seach_sphone = $this->request->data ['seach_sphone'] ? 1 : 0;
		if ($seach_sphone) {
			// $options ['conditions']['Orders.telco_id'] = 5;
		}
		$seach_gmobile = $this->request->data ['seach_gmobile'] ? 1 : 0;
		if ($seach_gmobile) {
			// $options ['conditions']['Orders.telco_id'] = 6;
		}
		$search_noithanh = $this->request->data ['search_noithanh'] ? 1 : 0;
		if ($search_noithanh) {
			$options ['conditions'] ['Orders.is_inner_city'] = 1;
		}
		$seach_bundle_id = $this->request->data ['seach_bundle_id'];
		if ($seach_bundle_id) {
			$options ['conditions'] ['Orders.bundle_id'] = $seach_bundle_id;
		}
		$seach_user_id = $this->request->data ['seach_user_id'];
		if ($seach_user_id) {
			$options ['conditions'] ['Orders.user_assigned'] = $seach_user_id;
		}
		$this->Paginator->settings = $options;
		$list_order = $this->Paginator->paginate ( 'Orders' );
		$this->set ( 'orders', $list_order );
	}
}