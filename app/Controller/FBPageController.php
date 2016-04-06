<?php
App::uses ( 'AppController', 'Controller' );
class FBPageController extends AppController {
	
	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $scaffold;
	public $uses = array (
			'FBPage',
			'FBCronConfig' 
	);
	public function index() {
		$group_id = 1;
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
		$this->set('fblogin_url', Configure::read ( 'sysconfig.FBPage.FB_LOGIN' ) . "?group_id={$group_id}");
	}
	public function updateConfig() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = 1;
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
		// $chia_donhang = $this->request->data ['chia_donhang'];
		// if ($chia_donhang != $currentConfig['chia_donhang']) {
		// if (!$this->FBCronConfig->saveField('chia_donhang',$chia_donhang)){
		// $configDataSource->rollback();
		// return 0;
		// }
		// }
		$configDataSource->commit ();
		return 1;
	}
	public function removePage() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = 1;
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
		$group_id = 1;
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
	//registerPage
	public function registerPage() {
		$this->layout = 'ajax';
		$this->autoRender = false;
		$group_id = 1;
		$id = intval ( $this->request->query ['id'] );
		if ($this->FBPage->updateAll ( array (
				'FBPage.status' => 0
		), array (
				'FBPage.id' => $id,
				'FBPage.group_id' => $group_id
		) )) {
			return 1;
		}
		return 0;
	}
}
