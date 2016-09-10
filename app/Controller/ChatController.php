<?php
App::uses ( 'AppController', 'Controller' );
class ChatController extends AppController {
	
	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $uses = array (
			'Chat',
			'FBConversationMessage',
			'FBPostComments',
			'FBPage',
			'FBCustomers' 
	);
	public $scaffold;
	private $fields = array (
			'Chat.id',
			'Chat.is_read',
			'Chat.fb_user_id',
			'Chat.fb_user_name',
			'Chat.last_conversation_time',
			'Chat.first_content',
			'Chat.first_content',
			'Chat.modified',
			'Chat.created' 
	);
	private $conv_limit = 50;
	private $msg_limit = 50;
	private $orders = array (
			'Chat.last_conversation_time' => 'DESC',
			//'Chat.is_read' => 'ASC' 
	);
	public function index() {
		$group_id = $this->_getGroup ();
		// lay danh sach conversation
		$conversations = $this->Chat->find ( 'all', array (
				'conditions' => array (
						'Chat.group_id' => $group_id 
				),
				'fields' => $this->fields,
				'order' => $this->orders,
		        'limit'=>$this->conv_limit
		) );
		if ($conversations) {
			$end = end($conversations);
			$this->set ( 'last', $end ['Chat'] ['last_conversation_time'] );
		} else {
			$this->set ( 'last', 0 );
		}
		$this->set ( 'conversations', $conversations );
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
	}
	public function loadMsg() {
		$group_id = $this->_getGroup ();
		$this->layout = 'ajax';
		$id = isset ( $this->request->data ['conv_id'] ) ? intval ( $this->request->data ['conv_id'] ) : 0;
		if (! $id) {
			$this->autoRender = false;
			return '0';
		}
		$conversation = $this->Chat->find ( 'first', array (
				'conditions' => array (
						'Chat.group_id' => $group_id,
						'Chat.id' => $id 
				),
				'fields' => array (
						'Chat.last_conversation_time',
						'Chat.page_id',
						'Chat.fb_user_id',
						'Chat.is_read',
						'Chat.type' 
				),
		        'limit'=>$this->conv_limit
		) );
		if (! $conversation) {
			// khong ton tai
			$this->autoRender = false;
			return '0';
		}
		if (! $conversation ['Chat'] ['is_read']) {
			$this->_setRead ( $id );
		}
		$this->set ( 'last_conversation_time', $conversation ['Chat'] ['last_conversation_time'] );
		// co su thay doi => load lai
		switch ($conversation ['Chat'] ['type']) {
			case 0 :
				$messages = $this->FBConversationMessage->find ( 'all', array (
						'conditions' => array (
								'FBConversationMessage.group_id' => $group_id,
								'FBConversationMessage.fb_conversation_id' => $id 
						),
						'order' => array (
								'FBConversationMessage.user_created' => 'ASC' 
						),
						'fields' => array (
								'FBConversationMessage.fb_user_id',
								'FBConversationMessage.content',
								'FBConversationMessage.created'
						),
						'limit'=>$this->msg_limit
				) );
				break;
			case 1 :
				$messages = $this->FBPostComments->find ( 'all', array (
						'conditions' => array (
								'FBPostComments.group_id' => $group_id,
								'FBPostComments.fb_conversation_id' => $id 
						),
						'order' => array (
								'FBPostComments.user_created' => 'ASC' 
						),
						'fields' => array (
								'FBPostComments.fb_user_id',
								'FBPostComments.content',
								'FBPostComments.created'
						),
						'limit'=>$this->msg_limit
				) );
				break;
			
			default :
				$this->autoRender = false;
				return '0';
		}
		$this->set ( 'page_id', $conversation ['Chat'] ['page_id'] );
		$this->set ( 'type', $conversation ['Chat'] ['type'] == 1 ? 'FBPostComments' : 'FBConversationMessage' );
		$this->set ( 'fb_user_id', $conversation ['Chat'] ['fb_user_id'] );
		$this->set ( 'id', $id );
		$this->set ( 'messages', $messages );
	}
	public function refreshMsg() {
		$group_id = $this->_getGroup ();
		$this->layout = 'ajax';
		$id = isset ( $this->request->data ['conv_id'] ) ? intval ( $this->request->data ['conv_id'] ) : 0;
		if (! $id) {
			$this->autoRender = false;
			return '0';
		}
		$last_conversation_time = isset ( $this->request->data ['last'] ) ? intval ( $this->request->data ['last'] ) : 0;
		// goi api dong bo noi dung chat qua fb api????
// 		$sync_api = Configure::read ( 'sysconfig.FBChat.SYNC_MSG_API' ) . '?' . http_build_query ( array (
// 				'group_chat_id' => $id 
// 		) );
// 		// goi api sync tu fb api ??? co nen ko??? vi se gay cham, timeout
// 		$rs = file_get_contents ( $sync_api );
// 		// $rs = 'SUCCESS';
// 		if ($rs != 'SUCCESS') {
// 			$this->autoRender = false;
// 			return '-1';
// 		}

		// check co message moi
		$conversation = $this->Chat->find ( 'first', array (
				'conditions' => array (
						'Chat.group_id' => $group_id,
						'Chat.id' => $id 
				),
				'fields' => array (
						'Chat.last_conversation_time',
						'Chat.page_id',
						'Chat.fb_user_id',
						'Chat.is_read',
						'Chat.type' 
				),
		        'limit'=>$this->conv_limit
		) );
		if (! $conversation) {
			// khong ton tai
			$this->autoRender = false;
			return '0';
		}
		if ($conversation ['Chat'] ['last_conversation_time'] <= $last_conversation_time) {
			// khong co su thay doi
			$this->autoRender = false;
			return '-1';
		}
		$this->set ( 'last_conversation_time', $conversation ['Chat'] ['last_conversation_time'] );
		// co su thay doi => load lai
		switch ($conversation ['Chat'] ['type']) {
			case 0 :
				$messages = $this->FBConversationMessage->find ( 'all', array (
						'conditions' => array (
								'FBConversationMessage.group_id' => $group_id,
								'FBConversationMessage.fb_conversation_id' => $id 
						),
						'order' => array (
								'FBConversationMessage.user_created' => 'ASC' 
						),
						'fields' => array (
								'FBConversationMessage.fb_user_id',
								'FBConversationMessage.content',
								'FBConversationMessage.created',
						),
						'limit'=>$this->msg_limit
				) );
				break;
			case 1 :
				$messages = $this->FBPostComments->find ( 'all', array (
						'conditions' => array (
								'FBPostComments.group_id' => $group_id,
								'FBPostComments.fb_conversation_id' => $id 
						),
						'order' => array (
								'FBPostComments.user_created' => 'ASC' 
						),
						'fields' => array (
								'FBPostComments.fb_user_id',
								'FBPostComments.content',
								'FBPostComments.created'
						),
						'limit'=>$this->msg_limit
				) );
				break;
			
			default :
				$this->autoRender = false;
				return '0';
		}
		$this->set ( 'page_id', $conversation ['Chat'] ['page_id'] );
		$this->set ( 'type', $conversation ['Chat'] ['type'] == 1 ? 'FBPostComments' : 'FBConversationMessage' );
		$this->set ( 'fb_user_id', $conversation ['Chat'] ['fb_user_id'] );
		$this->set ( 'id', $id );
		$this->set ( 'messages', $messages );
	}
	public function refreshConversation() {
		$this->layout = 'ajax';
		$group_id = $this->_getGroup ();
		// lay danh sach conversation
		// data: {last:last,selected:selected,page_id:page_id,type:type,is_read:is_read,has_order:has_order},
		$fb_page_id = isset ( $this->request->data ['page_id'] ) ? $this->request->data ['page_id'] : 0;
		$type = isset ( $this->request->data ['type'] ) ? $this->request->data ['type'] : - 1;
		$is_read = isset ( $this->request->data ['is_read'] ) ? $this->request->data ['is_read'] : - 1;
		$has_order = isset ( $this->request->data ['has_order'] ) ? $this->request->data ['has_order'] : - 1;
		$selected_conversation = isset ( $this->request->data ['selected'] ) ? intval ( $this->request->data ['selected'] ) : 0;
		$last_time = isset ( $this->request->data ['last'] ) ? intval ( $this->request->data ['last'] ) : 0;
		$conditions = array (
				'Chat.group_id' => $group_id 
		);
		if ($fb_page_id != 'all') {
			$conditions ['Chat.fb_page_id'] = intval ( $fb_page_id );
		}
		if ($type != 'all') {
			$conditions ['Chat.type'] = intval ( $type );
		}
		if ($is_read != 'all') {
			$conditions ['Chat.is_read'] = intval ( $is_read );
		}
		if ($has_order != 'all') {
			$conditions ['Chat.has_order'] = intval ( $has_order );
		}
		$conversations = $this->Chat->find ( 'all', array (
				'conditions' => $conditions,
				'order' => $this->orders,
				'fields' => $this->fields,
		        'limit'=>$this->conv_limit
		) );
		if ($conversations) {
			$conv_last_time = strtotime ( $conversations [0] ['Chat'] ['last_conversation_time'] );
			if (!$last_time || $conv_last_time > $last_time) {
				// co su thay doi
				$this->set ( 'last_time', $conv_last_time );
				$this->set ( 'conversations', $conversations );
				$this->set ( 'selected_conversation', $selected_conversation );
			} else {
				// khong co thay doi nao
				$this->autoRender = false;
				return '-1';
			}
		} else {
			// khong co conversation nao
			$this->autoRender = false;
			return '0';
		}
	}
	public function sendMsg() {
		$group_id = $this->_getGroup ();
		$this->layout = 'ajax';
		$send_api = Configure::read ( 'sysconfig.FBChat.SEND_MSG_API' );
		// lay danh sach conversation
		$message = isset ( $this->request->data ['message'] ) ? trim ( $this->request->data ['message'] ) : '';
		if (! $message) {
			$this->autoRender = false;
			return '-1';
		}
		$group_chat_id = isset ( $this->request->data ['conv_id'] ) ? $this->request->data ['conv_id'] : 0;
		if (! $group_chat_id) {
			$this->autoRender = false;
			return '-1';
		}
		$conversation = $this->Chat->find ( 'first', array (
				'conditions' => array (
						'Chat.group_id' => $group_id,
						'Chat.id' => $group_chat_id 
				),
				'fields' => array (
						'Chat.last_conversation_time',
						'Chat.page_id',
						'Chat.fb_user_id',
						'Chat.is_read',
						'Chat.type' 
				),
		        'limit'=>$this->conv_limit
		) );
		if (! $conversation) {
			// khong ton tai
			$this->autoRender = false;
			return '-1';
		}
		$send_api .= '?' . http_build_query ( array (
				'message' => $message,
				'group_chat_id' => $group_chat_id 
		) );
		// goi fb api send message
		$rs = file_get_contents ( $send_api );
		// $rs = 'SUCCESS';
		if ($rs == 'SUCCESS') {
			// $this->loadMsg ();

            //save last time
            $this->Chat->read(null, $group_chat_id);
            $this->Chat->set('last_conversation_time', time ());
            $this->Chat->save();

			$this->set ( 'page_id', $conversation ['Chat'] ['page_id'] );
			$this->set ( 'message', $message );



		} else {
			$this->autoRender = false;
			return '-1';
		}
	}
	private function _setRead($id) {
		$this->Chat->id = $id;
		if ($this->Chat->saveField ( 'is_read', 1 )) {
			return true;
		}
		return false;
	}
	public function customerInfo() {
		$this->layout = 'ajax';
		$fb_user_id = isset ( $this->request->data ['fb_user_id'] ) ? $this->request->data ['fb_user_id'] : 0;
		if (! $fb_user_id) {
			$this->autoRender = false;
			return '0';
		}
		$customer = $this->FBCustomers->find ( 'first', array (
				'conditions' => array (
						'FBCustomers.fb_id' => $fb_user_id 
				) 
		) );
		if ($customer) {
			$this->set ( 'customer', $customer );
		} else {
			// khong ton tai
			$this->autoRender = false;
			return '0';
		}
	}
}