<?php
App::uses ( 'AppController', 'Controller' );
class FBPageController extends AppController {
	
	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $components = array (
			'RequestHandler' 
	);
	public $scaffold;
	public $uses = array (
			'FBPage',
			'FBCronConfig' 
	);
	public function index() {
		$group_id = $this->_getGroup ();
		// danh sach pages
		$pages = $this->FBPage->find ( 'all', array (
				'conditions' => array (
						'FBPage.group_id' => $group_id 
				),
				'fields' => array (
						'FBPage.id',
						'FBPage.page_id',
						'FBPage.page_name',
						'FBPage.status' 
				) 
		) );
		$this->set ( 'pages', $pages );
		// lay config
		$configs = $this->FBCronConfig->find ( 'list', array (
				'conditions' => array (
						'FBCronConfig.group_id' => $group_id,
						'FBCronConfig.level' => 1 
				),
				'fields' => array (
						'FBCronConfig._key',
						'FBCronConfig.value' 
				) 
		) );
		foreach ( $configs as $key => $value ) {
			$this->set ( $key, $value );
		}
		$this->set ( 'fblogin_url', Configure::read ( 'sysconfig.FBPage.FB_LOGIN' ) . "?group_id={$group_id}" );
	}
	public function updateConfig() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = $this->_getGroup ();
		//var_dump( $this->request->data ) ; die;
		// reply_comment_has_phone:reply_comment_has_phone,reply_comment_nophone:reply_comment_nophone,is_like:is_like,
		// is_hide_phone:is_hide_phone,is_hide_nophone:is_hide_nophone,is_inbox:is_inbox,chia_donhang:chia_donhang
		// Lay cau hinh cu
		$currentConfig = $this->FBCronConfig->find ( 'list', array (
				'conditions' => array (
						'FBCronConfig.group_id' => $group_id 
				),
				'fields' => array (
						'FBCronConfig._key',
						'FBCronConfig.value' 
				) 
		) );
		$this->FBCronConfig->group_id = $group_id;
		$configDataSource = $this->FBCronConfig->getDataSource ();
		if ($this->request->data ['reply_comment_has_phone'] != $currentConfig ['reply_comment_has_phone']) {
			if (! $this->FBCronConfig->updateAll ( array (
					'FBCronConfig.value' => "'{$this->request->data ['reply_comment_has_phone']}'" 
			), array (
					'FBCronConfig.group_id' => $group_id,
					'FBCronConfig._key' => 'reply_comment_has_phone' 
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		if ($this->request->data ['reply_comment_nophone'] != $currentConfig ['reply_comment_nophone']) {
			if (! $this->FBCronConfig->updateAll ( array (
					'FBCronConfig.value' => "'{$this->request->data ['reply_comment_nophone']}'" 
			), array (
					'FBCronConfig.group_id' => $group_id,
					'FBCronConfig._key' => 'reply_comment_nophone' 
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		$is_like = $this->request->data ['is_like'] == '1' ? 1 : 0;
		if ($is_like != $currentConfig ['like_comment']) {
			if (! $this->FBCronConfig->updateAll ( array (
					'FBCronConfig.value' => $is_like 
			), array (
					'FBCronConfig.group_id' => $group_id,
					'FBCronConfig._key' => 'like_comment' 
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		$is_hide_phone = $this->request->data ['is_hide_phone'] == '1' ? 1 : 0;
		if ($is_hide_phone != $currentConfig ['hide_phone_comment']) {
			if (! $this->FBCronConfig->updateAll ( array (
					'FBCronConfig.value' => $is_hide_phone 
			), array (
					'FBCronConfig.group_id' => $group_id,
					'FBCronConfig._key' => 'hide_phone_comment' 
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		$is_hide_nophone = $this->request->data ['is_hide_nophone'] == '1' ? 1 : 0;
		if ($is_hide_nophone != $currentConfig ['hide_nophone_comment']) {
			if (! $this->FBCronConfig->updateAll ( array (
					'FBCronConfig.value' => $is_hide_nophone 
			), array (
					'FBCronConfig.group_id' => $group_id,
					'FBCronConfig._key' => 'hide_nophone_comment' 
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		$is_inbox = $this->request->data ['is_inbox'] == '1' ? 1 : 0;
		if ($is_inbox != $currentConfig ['reply_conversation']) {
			if (! $this->FBCronConfig->updateAll ( array (
					'FBCronConfig.value' => $is_inbox 
			), array (
					'FBCronConfig.group_id' => $group_id,
					'FBCronConfig._key' => 'reply_conversation' 
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		
		$phone_filter = $this->request->data ['phone_filter'];
		if ($phone_filter != $currentConfig ['phone_filter']) {
			if (! $this->FBCronConfig->updateAll ( array (
					'FBCronConfig.value' => "'{$phone_filter}'" 
			), array (
					'FBCronConfig.group_id' => $group_id,
					'FBCronConfig._key' => 'phone_filter' 
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		
		$words_blacklist = $this->request->data ['words_blacklist'];
		if ($words_blacklist != $currentConfig ['words_blacklist']) {
			if (! $this->FBCronConfig->updateAll ( array (
					'FBCronConfig.value' => "'{$words_blacklist}'"
			), array (
					'FBCronConfig.group_id' => $group_id,
					'FBCronConfig._key' => 'words_blacklist' 
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		
		//fb_app_id
		$fb_app_id = $this->request->data['fb_app_id'];
		if ($fb_app_id != $currentConfig ['fb_app_id']) {
			if (! $this->FBCronConfig->updateAll ( array (
				'FBCronConfig.value' => "'{$fb_app_id}'"
			), array (
				'FBCronConfig.group_id' => $group_id,
				'FBCronConfig._key' => 'fb_app_id'
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		//fb_app_secret_key
		$fb_app_secret_key = $this->request->data ['fb_app_secret_key'];
		if ($fb_app_secret_key != $currentConfig ['fb_app_secret_key']) {
			if (! $this->FBCronConfig->updateAll ( array (
				'FBCronConfig.value' => "'{$fb_app_secret_key}'"
			), array (
				'FBCronConfig.group_id' => $group_id,
				'FBCronConfig._key' => 'fb_app_secret_key'
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}

		//
		$user_coment_filter = $this->request->data ['user_coment_filter'];
		if ($user_coment_filter != $currentConfig ['user_coment_filter']) {
			if (! $this->FBCronConfig->updateAll ( array (
				'FBCronConfig.value' => "'{$user_coment_filter}'"
			), array (
				'FBCronConfig.group_id' => $group_id,
				'FBCronConfig._key' => 'user_coment_filter'
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		//inbox
		//
		$reply_conversation_has_phone = $this->request->data ['reply_conversation_has_phone'];
		if ($reply_conversation_has_phone != $currentConfig ['reply_conversation_has_phone']) {
			if (! $this->FBCronConfig->updateAll ( array (
				'FBCronConfig.value' => "'{$reply_conversation_has_phone}'"
			), array (
				'FBCronConfig.group_id' => $group_id,
				'FBCronConfig._key' => 'reply_conversation_has_phone'
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}
		//inbox
		//
		$reply_conversation_nophone = $this->request->data ['reply_conversation_nophone'];
		if ($reply_conversation_nophone != $currentConfig ['reply_conversation_nophone']) {
			if (! $this->FBCronConfig->updateAll ( array (
				'FBCronConfig.value' => "'{$reply_conversation_nophone}'"
			), array (
				'FBCronConfig.group_id' => $group_id,
				'FBCronConfig._key' => 'reply_conversation_nophone'
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}

		//reply_by_scripting
		$data = $this->request->data;
		$array = [];
		$array['address']['pattern'] 	= $data['address_pattern'];
		$array['address']['reply'] 		= $data['address_reply'];
		//$array['price']['pattern'] 		= $data['price_pattern'];
		//$array['price']['reply'] 		= $data['price_reply'];
		//$array['product_detail']['pattern'] = $data['product_detail_pattern'];
		//$array['product_detail']['reply'] 	= $data['product_detail_reply'];
		$array['transport']['pattern'] 	= $data['transport_pattern'];
		$array['transport']['reply'] 	= $data['transport_reply'];
		$array['out_of_work_time']['start'] 	= $data['out_of_work_time_start'];
		$array['out_of_work_time']['end'] 	= $data['out_of_work_time_end'];
		$array['out_of_work_time']['reply'] 	= $data['out_of_work_time_reply'];
		//$reply_by_scripting = json_encode($array);
		$reply_by_scripting = serialize($array);
		//var_dump($reply_by_scripting); die;
		if ($reply_by_scripting != $currentConfig ['reply_by_scripting']) {
			if (! $this->FBCronConfig->updateAll ( array (
				'FBCronConfig.value' => "'{$reply_by_scripting}'"
			), array (
				'FBCronConfig.group_id' => $group_id,
				'FBCronConfig._key' => 'reply_by_scripting'
			) )) {
				$configDataSource->rollback ();
				return 0;
			}
		}

		// $chia_donhang = $this->request->data ['chia_donhang'];
		// if ($chia_donhang != $currentConfig['chia_donhang']) {
		// if (!$this->FBCronConfig->saveField('chia_donhang',$chia_donhang)){
		// $configDataSource->rollback();
		// return 0;
		// }
		// }
		$configDataSource->commit ();
		// clear cache
		$cc_api = Configure::read ( 'sysconfig.FB_CORE.CLEAR_CACHE' );
		if ($cc_api)
			file_get_contents ( Configure::read ( 'sysconfig.FB_CORE.CLEAR_CACHE' ) );
		return 1;
	}
	public function removePage() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = $this->_getGroup ();
		$id = intval ( $this->request->query ['id'] );
		if ($this->FBPage->deleteAll ( array (
				'FBPage.id' => $id,
				'FBPage.group_id' => $group_id 
		) )) {
			return 1;
		}
		return 0;
	}
	// unregisterPage
	public function unregisterPage() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = $this->_getGroup ();
		$id = intval ( $this->request->query ['id'] );
		if ($this->FBPage->updateAll ( array (
				'FBPage.status' => 1 
		), array (
				'FBPage.id' => $id,
				'FBPage.group_id' => $group_id 
		) )) {
			return 1;
		}
		return 0;
	}
	// registerPage
	public function registerPage() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = $this->_getGroup ();
		$id = intval ( $this->request->query ['id'] );
		if ($this->FBPage->updateAll ( array (
				'FBPage.status' => 0,
		        'FBPage.last_conversation_time'=>time()
		), array (
				'FBPage.id' => $id,
				'FBPage.group_id' => $group_id 
		) )) {
			return 1;
		}
		return 0;
	}
	public function CheckNotify() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->RequestHandler->respondAs ( 'json' );
		return '{"Count": 0}';
	}
	// GetListFBComment
	public function GetFBPageData() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->RequestHandler->respondAs ( 'json' );
		return json_encode ( json_decode ( '[{"PageID":"1643607829233206","PageName":"Thuốc nam tăng cân hiệu quả-Hoàng Trung Đường"},{"PageID":"1676236829317557","PageName":"Thuốc đông y tăng cân hiệu quả"},{"PageID":"182053188816490","PageName":"Hoàng Trung Đường- thuốc tăng cân gia truyền"},{"PageID":"524432597738703","PageName":"Đông y Hoàng Trung Đường"},{"PageID":"945870525490503","PageName":"Thuôc Nam cho người Việt"}]' ) );
	}
	public function GetListFBComment() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$this->RequestHandler->respondAs ( 'json' );
		return '';
	}
}
