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
			'OrderProducts',
			'OrderRevision',
			'OrderChange',
			'FBPostComments',
			'FBPage' 
	);
	public $scaffold;
	public function history() {
		$order_id = intval ( $this->request->query ['order_id'] );
		$group_id = $this->_getGroup ();
		// lay lich su
		$revisions = $this->OrderRevision->find ( 'all', array (
				'conditions' => array (
						'OrderRevision.order_id' => $order_id 
				),
				'fields' => array (
						'OrderRevision.id',
						'OrderRevision.before_order_status',
						'OrderRevision.order_status',
						'OrderRevision.user_created_name',
						'OrderRevision.modified' 
				) 
		) );
		$this->set ( 'revisions', $revisions );
		$changes = $this->OrderChange->find ( 'all', array (
				'conditions' => array (
						'OrderChange.order_id' => $order_id 
				),
				'fields' => array (
						'OrderChange.id',
						'OrderChange.field_label',
						'OrderChange.before_value',
						'OrderChange.value',
						'OrderChange.user_created_name',
						'OrderChange.modified' 
				) 
		) );
		$this->set ( 'changes', $changes );
	}
	public function index() {
		$group_id = $this->_getGroup ();
		$options = array ();
		$options ['order'] = array (
				'Orders.created' => 'DESC' 
		);
		$options ['conditions'] ['Orders.group_id'] = $group_id;
		$this->_initSearch ( $options );
		$this->Paginator->settings = $options;
		$list_order = $this->Paginator->paginate ( 'Orders' );
		$this->_initOrderData ();
		$this->set ( 'orders', $list_order );
	}
	private function _initSearch(&$options) {
		$group_id = $this->_getGroup ();
		$options ['order'] = array (
				'Orders.created' => 'DESC' 
		);
		$options ['conditions'] ['Orders.group_id'] = $group_id;
		$data = array (
				'Orders.group_id' => $group_id 
		);
		$search_email_phone = isset ( $this->request->query ['search_email_phone'] ) ? $this->request->query ['search_email_phone'] : '';
		if (! empty ( $search_email_phone )) {
			$options ['conditions'] ['or'] = array (
					'Orders.mobile LIKE' => "%{$search_email_phone}%",
					'Orders.customer_name LIKE' => "%{$search_email_phone}%" 
			);
		}
		$search_check_ngaytao = isset ( $this->request->query ['search_email_phone'] ) ? $this->request->query ['search_email_phone'] : 0;
		if ($search_check_ngaytao) {
			$search_ngaytao_from = isset ( $this->request->query ['search_ngaytao_from'] ) ? $this->request->query ['search_ngaytao_from'] : '';
			if ($search_ngaytao_from)
				$options ['conditions'] ['Orders.created >='] = $search_ngaytao_from;
			$search_ngaytao_to = isset ( $this->request->query ['search_ngaytao_to'] ) ? $this->request->query ['search_ngaytao_to'] : '';
			if ($search_ngaytao_to)
				$options ['conditions'] ['Orders.created <='] = $search_ngaytao_to;
		}
		$search_check_chuyen = isset ( $this->request->query ['search_check_chuyen'] ) ? $this->request->query ['search_check_chuyen'] : 0;
		if ($search_check_ngaytao) {
			$search_chuyen_from = isset ( $this->request->query ['search_chuyen_from'] ) ? $this->request->query ['search_chuyen_from'] : '';
			if ($search_chuyen_from)
				$options ['conditions'] ['Orders.delivered >='] = $search_chuyen_from;
			$search_chuyen_to = isset ( $this->request->query ['search_chuyen_to'] ) ? $this->request->query ['search_chuyen_to'] : '';
			if ($search_chuyen_to)
				$options ['conditions'] ['Orders.delivered <='] = $search_chuyen_to;
		}
		$search_check_xacnhan = isset ( $this->request->query ['search_check_xacnhan'] ) ? $this->request->query ['search_check_xacnhan'] : 0;
		if ($search_check_xacnhan) {
			$search_xacnhan_from = isset ( $this->request->query ['search_xacnhan_from'] ) ? $this->request->query ['search_xacnhan_from'] : '';
			if ($search_xacnhan_from)
				$options ['conditions'] ['Orders.confirmed >='] = $search_xacnhan_from;
			$search_xacnhan_to = isset ( $this->request->query ['search_xacnhan_to'] ) ? $this->request->query ['search_xacnhan_to'] : '';
			if ($search_xacnhan_to)
				$options ['conditions'] ['Orders.confirmed <='] = $search_xacnhan_to;
		}
		$seach_shipping_service_id = null;
		$search_status_id = null;
		foreach ( $this->request->query as $key => $value ) {
			if (strpos ( $key, 'search_shipping_service' ) !== false && $value) {
				$seach_shipping_service_id [] = $value;
			} elseif (strpos ( $key, 'search_status' ) !== false && $value) {
				$search_status_id [] = $value;
			}
		}
		if ($seach_shipping_service_id) {
			$options ['conditions'] ['Orders.shipping_service_id IN'] = $seach_shipping_service_id;
		}
		if ($search_status_id) {
			$options ['conditions'] ['Orders.status_id IN'] = $search_status_id;
		}
		$seach_viettel = isset ( $this->request->query ['seach_viettel'] ) ? $this->request->query ['seach_viettel'] : 0;
		if ($seach_viettel) {
			// $options ['conditions']['Orders.telco_id'] = 1;
		}
		$search_mobi = isset ( $this->request->query ['search_mobi'] ) ? $this->request->query ['search_mobi'] : 0;
		if ($search_mobi) {
			// $options ['conditions']['Orders.telco_id'] = 2;
		}
		$seach_vnm = isset ( $this->request->query ['seach_vnm'] ) ? $this->request->query ['seach_vnm'] : 0;
		if ($seach_vnm) {
			// $options ['conditions']['Orders.telco_id'] = 3;
		}
		$seach_vina = isset ( $this->request->query ['seach_vina'] ) ? $this->request->query ['seach_vina'] : 0;
		if ($seach_vina) {
			// $options ['conditions']['Orders.telco_id'] = 4;
		}
		$seach_sphone = isset ( $this->request->query ['seach_sphone'] ) ? $this->request->query ['seach_sphone'] : 0;
		if ($seach_sphone) {
			// $options ['conditions']['Orders.telco_id'] = 5;
		}
		$seach_gmobile = isset ( $this->request->query ['seach_gmobile'] ) ? $this->request->query ['seach_gmobile'] : 0;
		if ($seach_gmobile) {
			// $options ['conditions']['Orders.telco_id'] = 6;
		}
		$search_noithanh = isset ( $this->request->query ['search_noithanh'] ) ? $this->request->query ['search_noithanh'] : 0;
		if ($search_noithanh) {
			$options ['conditions'] ['Orders.is_inner_city'] = 1;
		}
		$seach_bundle_id = isset ( $this->request->query ['search_phanloai'] ) ? intval ( $this->request->query ['search_phanloai'] ) : 0;
		if ($seach_bundle_id) {
			$this->request->query ['search_phanloai'] = $seach_bundle_id;
			$options ['conditions'] ['Orders.bundle_id'] = $seach_bundle_id;
		}
		$seach_user_id = isset ( $this->request->query ['search_nhanvien'] ) ? intval ( $this->request->query ['search_nhanvien'] ) : 0;
		if ($seach_user_id) {
			$this->request->query ['search_nhanvien'] = $seach_user_id;
			$options ['conditions'] ['Orders.user_assigned'] = $seach_user_id;
		}
	}
	private function _initOrderData() {
		$group_id = $this->_getGroup ();
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
				),
				'fields' => array (
						'Users.id',
						'Users.username' 
				) 
		) );
		$this->set ( 'users', $users );
	}
	private function _initOrderDataList() {
		$group_id = $this->_getGroup ();
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
		$group_id = $this->_getGroup ();
		$options = array ();
		$options ['conditions'] ['Orders.group_id'] = $group_id;
		$options ['conditions'] ['Orders.id'] = $order_id;
		$this->Paginator->settings = $options;
		$order = $this->Orders->find ( 'first', $options );
		$this->_initOrderData ();
		$page = $this->FBPage->find ( 'first', array (
				'conditions' => array (
						'FBPage.id' => $order ['Orders'] ['fb_page_id'] 
				),
				'fields' => array (
						'FBPage.id',
						'FBPage.page_id',
						'FBPage.page_name' 
				) 
		) );
		$this->set ( 'page', $page );
		$this->set ( 'order', $order );
	}
	public function add() {
		$group_id = $this->_getGroup ();
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
		$group_id = $this->_getGroup ();
		$this->layout = 'ajax';
		$this->autoRender = false;
		$order_id = intval ( $this->request->query ['order_id'] );
		$status = intval ( $this->request->query ['status'] );
		$currentOrder = $this->Orders->find ( 'first', array (
				'conditions' => array (
						'Orders.id' => $order_id 
				) 
		) );
		$this->Orders->id = $order_id;
		if ($this->Orders->saveField ( 'status_id', $status )) {
			$updatedOrder = $this->Orders->find ( 'first', array (
					'conditions' => array (
							'Orders.id' => $order_id 
					) 
			) );
			$this->_processOrderHistory ( $group_id, $currentOrder, $updatedOrder, false, true );
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
		$group_id = $this->_getGroup ();
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
		$price = $this->request->data ['price'] ? intval ( $this->request->data ['price'] ) : 0;
		$data ['price'] = $price ? intval ( $price ) : 0;
		$total_price = $this->request->data ['total_price'] ? intval ( $this->request->data ['total_price'] ) : 0;
		$data ['total_price'] = $total_price;
		$order_product = $this->request->data ['order_product'];
		$current_date = date ( 'Y-m-d H:i:s' );
		$data ['modified'] = $current_date;
		$saveData = null;
		// Lay thong tin order truoc khi update de luu lich su
		$currentOrder = $this->Orders->find ( 'first', array (
				'conditions' => array (
						'Orders.id' => $order_id 
				) 
		) );
		$new_order_products = null;
		$orderDataSource = $this->Orders->getDataSource ();
		if ($order_product == '-1') {
			// khong co su thay doi san pham
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
						$new_order_products [$product_id] = $qty;
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
			// Lay thong tin order duoc cap nhat
			$updatedOrder = $this->Orders->find ( 'first', array (
					'conditions' => array (
							'Orders.id' => $order_id 
					) 
			) );
			$this->_processOrderHistory ( $group_id, $currentOrder, $updatedOrder, $order_product === '-1' ? false : true );
			return 1;
		}
		$orderDataSource->rollback ();
		return 0;
	}
	private function _processOrderHistory($group_id, &$currentOrder, &$updatedOrder, $isProductUpdated = true, $justStatus = false) {
		$user_modified = 1;
		$user_modified_name = 'CongMT';
		// trang thai
		$current_date = date ( 'Y-m-d H:i:s' );
		$order_revision_id = 0;
		if ($currentOrder ['Orders'] ['status_id'] != $updatedOrder ['Orders'] ['status_id']) {
			// cap nhat order_revisions
			// tao revision cho order cu
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
			$revisionData = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'before_order_status_id' => $currentOrder ['Orders'] ['status_id'],
					'before_order_status' => isset ( $statuses [$currentOrder ['Orders'] ['status_id']] ) ? $statuses [$currentOrder ['Orders'] ['status_id']] : '',
					'order_status_id' => $updatedOrder ['Orders'] ['status_id'],
					'order_status' => isset ( $statuses [$updatedOrder ['Orders'] ['status_id']] ) ? $statuses [$updatedOrder ['Orders'] ['status_id']] : '',
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
			$this->OrderRevision->create ();
			if ($this->OrderRevision->save ( $revisionData )) {
				$order_revision_id = $this->OrderRevision->getLastInsertId ();
			}
			if ($justStatus) {
				return;
			}
		}
		// cac thay doi khac
		$order_changes = null;
		// customer_name
		if ($currentOrder ['Orders'] ['customer_name'] != $updatedOrder ['Orders'] ['customer_name']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'customer_name',
					'field_label' => 'Tên khách hàng',
					'before_value' => $currentOrder ['Orders'] ['customer_name'],
					'value' => $updatedOrder ['Orders'] ['customer_name'],
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// postal_code
		if ($currentOrder ['Orders'] ['postal_code'] != $updatedOrder ['Orders'] ['postal_code']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'postal_code',
					'field_label' => 'Mã bưu điện',
					'before_value' => $currentOrder ['Orders'] ['postal_code'],
					'value' => $updatedOrder ['Orders'] ['postal_code'],
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// mobile
		if ($currentOrder ['Orders'] ['mobile'] != $updatedOrder ['Orders'] ['mobile']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'mobile',
					'field_label' => 'Số điện thoại',
					'before_value' => $currentOrder ['Orders'] ['mobile'],
					'value' => $updatedOrder ['Orders'] ['mobile'],
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// city
		if ($currentOrder ['Orders'] ['city'] != $updatedOrder ['Orders'] ['city']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'city',
					'field_label' => 'Thành phố',
					'before_value' => $currentOrder ['Orders'] ['city'],
					'value' => $updatedOrder ['Orders'] ['city'],
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// city
		if ($currentOrder ['Orders'] ['address'] != $updatedOrder ['Orders'] ['address']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'address',
					'field_label' => 'Địa chỉ',
					'before_value' => $currentOrder ['Orders'] ['address'],
					'value' => $updatedOrder ['Orders'] ['address'],
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// note1
		if ($currentOrder ['Orders'] ['note1'] != $updatedOrder ['Orders'] ['note1']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'note1',
					'field_label' => 'Chú ý 1',
					'before_value' => $currentOrder ['Orders'] ['note1'],
					'value' => $updatedOrder ['Orders'] ['note1'],
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// note2
		if ($currentOrder ['Orders'] ['note2'] != $updatedOrder ['Orders'] ['note2']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'note2',
					'field_label' => 'Chú ý 2',
					'before_value' => $currentOrder ['Orders'] ['note2'],
					'value' => $updatedOrder ['Orders'] ['note2'],
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// cancel_note
		if ($currentOrder ['Orders'] ['cancel_note'] != $updatedOrder ['Orders'] ['cancel_note']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'cancel_note',
					'field_label' => 'Lý do huỷ',
					'before_value' => $currentOrder ['Orders'] ['cancel_note'],
					'value' => $updatedOrder ['Orders'] ['cancel_note'],
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// is_top_priority
		if ($currentOrder ['Orders'] ['is_top_priority'] != $updatedOrder ['Orders'] ['is_top_priority']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'is_top_priority',
					'field_label' => 'Ghi chú chuyển hàng',
					'before_value' => $currentOrder ['Orders'] ['is_top_priority'] ? 'Có' : 'Không',
					'value' => $updatedOrder ['Orders'] ['is_top_priority'] ? 'Có' : 'Không',
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// is_send_sms
		if ($currentOrder ['Orders'] ['is_send_sms'] != $updatedOrder ['Orders'] ['is_send_sms']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'is_send_sms',
					'field_label' => 'Gửi tin nhắn',
					'before_value' => $currentOrder ['Orders'] ['is_send_sms'] ? 'Có' : 'Không',
					'value' => $updatedOrder ['Orders'] ['is_send_sms'] ? 'Có' : 'Không',
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// is_inner_city
		if ($currentOrder ['Orders'] ['is_inner_city'] != $updatedOrder ['Orders'] ['is_inner_city']) {
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'is_inner_city',
					'field_label' => 'Nội thành',
					'before_value' => $currentOrder ['Orders'] ['is_inner_city'] ? 'Có' : 'Không',
					'value' => $updatedOrder ['Orders'] ['is_inner_city'] ? 'Có' : 'Không',
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// shipping_service_id
		if ($currentOrder ['Orders'] ['shipping_service_id'] != $updatedOrder ['Orders'] ['shipping_service_id']) {
			$shipping_services = $this->ShippingServices->find ( 'list', array (
					'conditions' => array (
							'ShippingServices.group_id' => $group_id 
					),
					'fields' => array (
							'ShippingServices.id',
							'ShippingServices.name' 
					) 
			) );
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'shipping_service_id',
					'field_label' => 'Hình thức giao hàng',
					'before_value' => isset ( $shipping_services [$currentOrder ['Orders'] ['shipping_service_id']] ) ? $shipping_services [$currentOrder ['Orders'] ['shipping_service_id']] : '',
					'value' => isset ( $shipping_services [$updatedOrder ['Orders'] ['shipping_service_id']] ) ? $shipping_services [$updatedOrder ['Orders'] ['shipping_service_id']] : '',
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		// thay doi product
		if ($isProductUpdated) {
			// if (!count($currentOrder['Product'])) {
			// // order cu khong co san pham nao
			// foreach ($updatedOrder['Product'] as $prd){
			// $order_changes [] = array (
			// 'order_id' => $currentOrder ['Orders'] ['id'],
			// 'order_revision_id' => $order_revision_id,
			// 'field_name' => 'product',
			// 'field_label' => 'Thêm sản phẩm',
			// 'before_value' => '',
			// 'value' => "{$prd['name']}-SL: {$prd['qty']}",
			// 'created' => $current_date,
			// 'modified' => $current_date,
			// 'user_created' => $user_modified,
			// 'user_created_name' => $user_modified_name
			// );
			// }
			// }
			// else {
			// foreach ($currentOrder['Product'] as $prd){
			// if (!count($updatedOrder['Product'])) {
			// // xoa het product
			// $order_changes [] = array (
			// 'order_id' => $currentOrder ['Orders'] ['id'],
			// 'order_revision_id' => $order_revision_id,
			// 'field_name' => 'product',
			// 'field_label' => 'Xoá sản phẩm',
			// 'before_value' => '',
			// 'value' => $prd['name'],
			// 'created' => $current_date,
			// 'modified' => $current_date,
			// 'user_created' => $user_modified,
			// 'user_created_name' => $user_modified_name
			// );
			// }
			// else {
			// $is_removed = true;
			// foreach ($updatedOrder['Product'] as $i => $uprd){
			// if ($uprd['id']==$prd['id']) {
			// // cung product
			// // kiem tra xem co thay doi so luong khong
			// if ($uprd['OrdersProduct']['qty'] != $prd['OrdersProduct']['qty']) {
			// $order_changes [] = array (
			// 'order_id' => $currentOrder ['Orders'] ['id'],
			// 'order_revision_id' => $order_revision_id,
			// 'field_name' => 'product',
			// 'field_label' => $uprd['name'] . '-Số lượng',
			// 'before_value' => $prd['OrdersProduct']['qty'],
			// 'value' => $uprd['OrdersProduct']['qty'],
			// 'created' => $current_date,
			// 'modified' => $current_date,
			// 'user_created' => $user_modified,
			// 'user_created_name' => $user_modified_name
			// );
			// }
			// $is_removed = false;//san pham van ton tai
			// unset($updatedOrder['Product'][$i]);
			// }
			// }
			// if ($is_removed) {
			// // san pham da bi xoa
			// $order_changes [] = array (
			// 'order_id' => $currentOrder ['Orders'] ['id'],
			// 'order_revision_id' => $order_revision_id,
			// 'field_name' => 'product',
			// 'field_label' => 'Xoá sản phẩm',
			// 'before_value' => $prd['name'],
			// 'value' => '',
			// 'created' => $current_date,
			// 'modified' => $current_date,
			// 'user_created' => $user_modified,
			// 'user_created_name' => $user_modified_name
			// );
			// }
			// }
			// }
			// if (count($updatedOrder['Product'])) {
			// // day la nhung san pham duoc them moi
			// foreach ($updatedOrder['Product'] as $prd){
			// $order_changes [] = array (
			// 'order_id' => $currentOrder ['Orders'] ['id'],
			// 'order_revision_id' => $order_revision_id,
			// 'field_name' => 'product',
			// 'field_label' => 'Thêm sản phẩm',
			// 'before_value' => '',
			// 'value' => "{$prd['name']}-SL: {$prd['OrdersProduct']['qty']}",
			// 'created' => $current_date,
			// 'modified' => $current_date,
			// 'user_created' => $user_modified,
			// 'user_created_name' => $user_modified_name
			// );
			// }
			// }
			// }
			// Danh sach san pham cu
			$old_od = '';
			foreach ( $currentOrder ['Product'] as $od ) {
				$old_od [] = "SP: {$od['name']}, SL: {$od['OrdersProduct']['qty']}";
			}
			$new_od = '';
			foreach ( $updatedOrder ['Product'] as $od ) {
				$new_od [] = "SP: {$od['name']}, SL: {$od['OrdersProduct']['qty']}";
			}
			$order_changes [] = array (
					'order_id' => $currentOrder ['Orders'] ['id'],
					'order_revision_id' => $order_revision_id,
					'field_name' => 'product',
					'field_label' => 'Cập nhật sản phẩm',
					'before_value' => $old_od ? implode ( ' | ', $old_od ) : '',
					'value' => $new_od ? implode ( ' | ', $new_od ) : '',
					'created' => $current_date,
					'modified' => $current_date,
					'user_created' => $user_modified,
					'user_created_name' => $user_modified_name 
			);
		}
		if ($order_changes) {
			$this->OrderChange->create ();
			$this->OrderChange->saveAll ( $order_changes );
		}
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
		$group_id = $this->_getGroup ();
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
		$price = $this->request->data ['price'] ? intval ( $this->request->data ['price'] ) : 0;
		$data ['price'] = $price ? intval ( $price ) : 0;
		$total_price = $this->request->data ['total_price'] ? intval ( $this->request->data ['total_price'] ) : 0;
		$data ['total_price'] = $total_price;
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
		if (! $this->OrderProducts->saveAll ( $saveData )) {
			// insert loi
			$orderDataSource->rollback ();
			return 0;
		}
		$orderDataSource->commit ();
		return 1;
	}
	public function quick_chat() {
		$this->layout = 'ajax';
		$comment_id = $this->request->data ['comment_id'];
		$fb_user_id = $this->request->data ['fb_user_id'];
		$customer_name = $this->request->data ['customer_name'];
		$page_id = $this->request->data ['page_id'];
		$page_name = $this->request->data ['page_name'];
		$group_id = $this->_getGroup ();
		// lay conversation ung voi comment
		$conversation = $this->FBPostComments->find ( 'first', array (
				'conditions' => array (
						'FBPostComments.group_id' => $group_id,
						'FBPostComments.page_id' => $page_id,
						'or' => array (
								'FBPostComments.comment_id' => $comment_id,
								'FBPostComments.parent_comment_id' => $comment_id 
						),
						'FBPostComments.fb_conversation_id <>' => 0 
				),
				'fileds' => array (
						'FBPostComments.fb_conversation_id' 
				) 
		) );
		if (! $conversation) {
			$this->autoRender = false;
			return '0';
		}
		$fb_conversation_id = $conversation ['FBPostComments'] ['fb_conversation_id'];
		$sync_api = Configure::read ( 'sysconfig.FBChat.SYNC_MSG_API' ) . '?' . http_build_query ( array (
				'group_chat_id' => $fb_conversation_id 
		) );
		// goi api sync tu fb api ??? co nen ko??? vi se gay cham, timeout
		$rs = file_get_contents ( $sync_api );
		if ($rs !== 'SUCCESS') {
			// loi dong bo
			$this->autoRender = false;
			return '-1';
		}
		// load danh sach noi dung chat
		$messages = $this->FBPostComments->find ( 'all', array (
				'conditions' => array (
						'FBPostComments.group_id' => $group_id,
						'FBPostComments.page_id' => $page_id,
						'or' => array (
								'FBPostComments.comment_id' => $comment_id,
								'FBPostComments.parent_comment_id' => $comment_id 
						),
						'FBPostComments.fb_user_id IN' => array (
								$fb_user_id,
								$page_id 
						) 
				),
				'order' => array (
						'FBPostComments.user_created' => 'ASC' 
				),
				'fileds' => array (
						'FBPostComments.fb_user_id',
						'FBPostComments.content',
						'FBPostComments.user_created' 
				) 
		) );
		if (! $messages) {
			$this->autoRender = false;
			return '0';
		}
		$end = end ( $messages );
		$this->set ( 'last', $end ['FBPostComments'] ['user_created'] );
		$this->set ( 'fb_conversation_id', $fb_conversation_id );
		$this->set ( 'page_id', $page_id );
		$this->set ( 'fb_user_id', $fb_user_id );
		$this->set ( 'customer_name', $customer_name );
		$this->set ( 'page_name', $page_name );
		$this->set ( 'messages', $messages );
	}
	public function quick_chat_refresh() {
		$this->layout = 'ajax';
		$comment_id = $this->request->data ['comment_id'];
		$fb_user_id = $this->request->data ['fb_user_id'];
		$customer_name = $this->request->data ['customer_name'];
		$page_id = $this->request->data ['page_id'];
		$page_name = $this->request->data ['page_name'];
		$last = isset ( $this->request->data ['last'] ) ? $this->request->data ['last'] : 0;
		$fb_conversation_id = intval ( $this->request->data ['fb_conversation_id'] );
		// load lai noi dung chat qua fbapi
		$sync_api = Configure::read ( 'sysconfig.FBChat.SYNC_MSG_API' ) . '?' . http_build_query ( array (
				'group_chat_id' => $fb_conversation_id 
		) );
		// goi api sync tu fb api ??? co nen ko??? vi se gay cham, timeout
		$rs = file_get_contents ( $sync_api );
		if ($rs !== 'SUCCESS') {
			// loi dong bo
			$this->autoRender = false;
			return '-1';
		}
		$group_id = $this->_getGroup ();
		// load danh sach noi dung chat
		$messages = $this->FBPostComments->find ( 'all', array (
				'conditions' => array (
						'FBPostComments.group_id' => $group_id,
						'FBPostComments.page_id' => $page_id,
						'or' => array (
								'FBPostComments.comment_id' => $comment_id,
								'FBPostComments.parent_comment_id' => $comment_id 
						),
						'FBPostComments.fb_user_id IN' => array (
								$fb_user_id,
								$page_id 
						) 
				),
				'order' => array (
						'FBPostComments.user_created' => 'ASC' 
				),
				'fileds' => array (
						'FBPostComments.fb_user_id',
						'FBPostComments.content',
						'FBPostComments.user_created' 
				) 
		) );
		if (! $messages) {
			$this->autoRender = false;
			return '0';
		}
		$end = end ( $messages );
		$last_time = $end ['FBPostComments'] ['user_created'];
		if ($last_time > $last) {
			// co noi dung moi
			$this->set ( 'last', $last_time );
			$this->set ( 'page_id', $page_id );
			$this->set ( 'fb_user_id', $fb_user_id );
			$this->set ( 'customer_name', $customer_name );
			$this->set ( 'page_name', $page_name );
			$this->set ( 'messages', $messages );
			$this->set ( 'fb_conversation_id', $fb_conversation_id );
		} else {
			// khong co noi dung moi
			$this->autoRender = false;
			return '-1';
		}
	}
	public function quick_chat_send() {
		$page_id = $this->request->data ['page_id'];
		$page_name = $this->request->data ['page_name'];
		$fb_conversation_id = $this->request->data ['conv_id'];
		if (! $fb_conversation_id) {
			$this->autoRender = false;
			return '0';
		}
		$message = trim ( $this->request->data ['message'] );
		if (! $message) {
			$this->autoRender = false;
			return '0';
		}
		$send_api = Configure::read ( 'sysconfig.FBChat.SEND_MSG_API' );
		$send_api .= '?' . http_build_query ( array (
				'message' => $message,
				'group_chat_id' => $fb_conversation_id 
		) );
		// goi fb api send message
		$rs = file_get_contents ( $send_api );
		// $rs = 'SUCCESS';
		if ($rs == 'SUCCESS') {
			// $this->loadMsg ();
			$this->set ( 'page_id', $page_id );
			$this->set ( 'page_name', $page_name );
			$this->set ( 'message', $message );
		} else {
			$this->autoRender = false;
			return '0';
		}
	}
}