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
	public function CheckNotify(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		return '{Count: 0}';
	}
	//GetListFBComment
	public function GetFanPageData(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		return '[{"PageID":"1643607829233206","PageName":"Thuốc nam tăng cân hiệu quả-Hoàng Trung Đường"},{"PageID":"1676236829317557","PageName":"Thuốc đông y tăng cân hiệu quả"},{"PageID":"182053188816490","PageName":"Hoàng Trung Đường- thuốc tăng cân gia truyền"},{"PageID":"524432597738703","PageName":"Đông y Hoàng Trung Đường"},{"PageID":"945870525490503","PageName":"Thuôc Nam cho người Việt"}]';
	}
	public function GetListFBComment(){
		$this->layout = 'ajax';
		$this->autoRender = false;
		return '[{"Unread":0,"FormtedTime":"khoảng 10 giờ trước","ID":"1674584586135530_1677981442462511","FBName":null,"PhoneNumber":"0938174493","Time":"\/Date(1459975957000)\/","Text":"0938174493","OrderID":"000955","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"581619035345889","UserName":"Quốc Vinh","UserLink":"https://www.facebook.com/app_scoped_user_id/581619035345889/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459976000000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":1,"FormtedTime":"khoảng 13 giờ trước","ID":"1674584586135530_1677941295799859","FBName":null,"PhoneNumber":"0934659229","Time":"\/Date(1459964523000)\/","Text":"0934659229","OrderID":"000954","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1032038726868541","UserName":"Nguyen Luong Bang","UserLink":"https://www.facebook.com/app_scoped_user_id/1032038726868541/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":null,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459964553000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"khoảng 23 giờ trước","ID":"1674584586135530_1677812665812722","FBName":null,"PhoneNumber":"0918648101","Time":"\/Date(1459928293000)\/","Text":"0918648101","OrderID":"000953","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"575888695903735","UserName":"Ke No Doi","UserLink":"https://www.facebook.com/app_scoped_user_id/575888695903735/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459932357000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677773069150015","FBName":null,"PhoneNumber":null,"Time":"\/Date(1459920355000)\/","Text":"Thuoc nay bao nhieu 1hop, va xuat xu o dau vay nha thuoc","OrderID":null,"IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1680641535558194","UserName":"Han Nguyen","UserLink":"https://www.facebook.com/app_scoped_user_id/1680641535558194/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459923086000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị  sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677771529150169","FBName":null,"PhoneNumber":null,"Time":"\/Date(1459919908000)\/","Text":"Cần tư vấn gấp","OrderID":null,"IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1582367305412179","UserName":"Nguyen Ngoc Tu Nguyen","UserLink":"https://www.facebook.com/app_scoped_user_id/1582367305412179/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459921895000)\/","ChildText":"Nhà thuốc đã nhận được câu hỏi của bạn. Bạn có thể 【ĐỂ LẠI SỐ ĐIỆN THOẠI】 nhà thuốc sẽ liên hệ tư vấn nhanh hơn và cụ thể cho bạn hơn ạ. Cám ơn!","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677771379150184","FBName":null,"PhoneNumber":"01636060412","Time":"\/Date(1459919880000)\/","Text":"01636060412","OrderID":"000951","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1582367305412179","UserName":"Nguyen Ngoc Tu Nguyen","UserLink":"https://www.facebook.com/app_scoped_user_id/1582367305412179/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459921296000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677771309150191","FBName":null,"PhoneNumber":"01636060413","Time":"\/Date(1459919861000)\/","Text":"01636060413","OrderID":"000950","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1582367305412179","UserName":"Nguyen Ngoc Tu Nguyen","UserLink":"https://www.facebook.com/app_scoped_user_id/1582367305412179/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459921293000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677768585817130","FBName":null,"PhoneNumber":null,"Time":"\/Date(1459919128000)\/","Text":".","OrderID":null,"IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"997922646947722","UserName":"Mai Minh Kiệt","UserLink":"https://www.facebook.com/app_scoped_user_id/997922646947722/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459921331000)\/","ChildText":"Nhà thuốc đã nhận được câu hỏi của bạn. Bạn có thể 【ĐỂ LẠI SỐ ĐIỆN THOẠI】 nhà thuốc sẽ liên hệ tư vấn nhanh hơn và cụ thể cho bạn hơn ạ. Cám ơn!","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677701065823882","FBName":null,"PhoneNumber":"0936564197","Time":"\/Date(1459902916000)\/","Text":"O936564197","OrderID":"000949","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1679913302267756","UserName":"Maria Hồng","UserLink":"https://www.facebook.com/app_scoped_user_id/1679913302267756/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459903015000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677674352493220","FBName":null,"PhoneNumber":"01686902464","Time":"\/Date(1459897146000)\/","Text":"thai huynh 01686902464","OrderID":"000948","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1699482496997878","UserName":"Thai Huynh","UserLink":"https://www.facebook.com/app_scoped_user_id/1699482496997878/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459897189000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677627122497943","FBName":null,"PhoneNumber":"0984108141","Time":"\/Date(1459888117000)\/","Text":"0984108141","OrderID":"000947","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"205601693152702","UserName":"Đỗquang Tỉnh","UserLink":"https://www.facebook.com/app_scoped_user_id/205601693152702/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459888165000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677624945831494","FBName":null,"PhoneNumber":"0902286854","Time":"\/Date(1459887335000)\/","Text":"0902286854","OrderID":"000946","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1743510632535760","UserName":"Hue Vu","UserLink":"https://www.facebook.com/app_scoped_user_id/1743510632535760/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459887398000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":1,"FormtedTime":"hôm qua","ID":"1674584586135530_1677602199167102","FBName":null,"PhoneNumber":"01649760680","Time":"\/Date(1459879836000)\/","Text":"01649760680","OrderID":"000945","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"482107305283439","UserName":"Dương Tuân","UserLink":"https://www.facebook.com/app_scoped_user_id/482107305283439/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":null,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459879887000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"m_mid.1459905027044:92b3fa174b645c9306","FBName":null,"PhoneNumber":null,"Time":"\/Date(1459879827000)\/","Text":"mình muốn đặt thuốc","OrderID":null,"IsReply":false,"ParentID":null,"PostID":null,"UserLike":null,"IsIngore":null,"Note":null,"UserID":"573536732805150","UserName":"Dinh Phan","UserLink":"https://www.facebook.com/app_scoped_user_id/573536732805150/","IsHidden":false,"IsChild":true,"ChildOf":"t_mid.1459905027044:92b3fa174b645c9306","IsRead":true,"TypeOf":"inbox","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459879868000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":0,"FormtedTime":"hôm qua","ID":"1674584586135530_1677600262500629","FBName":null,"PhoneNumber":"0918504239","Time":"\/Date(1459879079000)\/","Text":"0918504239","OrderID":"000943","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1679592015620542","UserName":"Hộp Thư Tri Ân","UserLink":"https://www.facebook.com/app_scoped_user_id/1679592015620542/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":true,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459879129000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":1,"FormtedTime":"hôm qua","ID":"1674584586135530_1677580092502646","FBName":null,"PhoneNumber":"0975130733","Time":"\/Date(1459870875000)\/","Text":"Mai Hiền, 0975130733","OrderID":"000942","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1738004973142281","UserName":"Hiền Mai","UserLink":"https://www.facebook.com/app_scoped_user_id/1738004973142281/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":null,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459871294000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":1,"FormtedTime":"hôm qua","ID":"1674584586135530_1677485099178812","FBName":null,"PhoneNumber":"0915285879","Time":"\/Date(1459845106000)\/","Text":"0915285879","OrderID":"000941","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"826085767537324","UserName":"Nguyen Vu","UserLink":"https://www.facebook.com/app_scoped_user_id/826085767537324/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":null,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459845162000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":1,"FormtedTime":"hôm qua","ID":"1674584586135530_1677479932512662","FBName":null,"PhoneNumber":"0932248333","Time":"\/Date(1459844332000)\/","Text":"0932248333","OrderID":"000940","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"1505361833101991","UserName":"Hai Phong","UserLink":"https://www.facebook.com/app_scoped_user_id/1505361833101991/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":null,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459844380000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null},{"Unread":1,"FormtedTime":"hôm qua","ID":"1674584586135530_1677452319182090","FBName":null,"PhoneNumber":"0987857930","Time":"\/Date(1459839984000)\/","Text":"0987857930","OrderID":"000938","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"169030780146964","UserName":"Hong Nguyen","UserLink":"https://www.facebook.com/app_scoped_user_id/169030780146964/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":null,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459840016000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị  sớm nhất ạ.","FBNameSearch":null},{"Unread":1,"FormtedTime":"05/04/16","ID":"1674584586135530_1677390459188276","FBName":null,"PhoneNumber":"0974041938","Time":"\/Date(1459826248000)\/","Text":"0974041938","OrderID":"000937","IsReply":true,"ParentID":"1643607829233206_1674584586135530","PostID":"1643607829233206_1674584586135530","UserLike":true,"IsIngore":null,"Note":null,"UserID":"538598603011098","UserName":"Tinh Xua Vung Dai","UserLink":"https://www.facebook.com/app_scoped_user_id/538598603011098/","IsHidden":true,"IsChild":null,"ChildOf":null,"IsRead":null,"TypeOf":"comment","Tag":null,"PageID":"1643607829233206","UrlWeb":null,"LastUpdateTime":"\/Date(1459826294000)\/","ChildText":"Cảm ơn Anh/Chị. Nhà thuốc đã nhận được thông tin của Anh/Chị và sẽ liên hệ để tư vấn \u0026 chăm sóc Anh/Chị sớm nhất ạ.","FBNameSearch":null}]';
	}
}
