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
			'Chat.last_conversation_time',
			'Chat.first_content',
			'Chat.first_content',
			'Chat.modified' 
	);
	public function index() {
		$group_id = 1;
		// lay danh sach conversation
		$conversations = $this->Chat->find ( 'all', array (
				'conditions' => array (
						'Chat.group_id' => $group_id 
				),
				'fields' => $this->fields,
				'order' => array (
						'Chat.last_conversation_time' => 'DESC' 
				) 
		) );
		if ($conversations) {
			$this->set ( 'last', $conversations [0] ['Chat'] ['last_conversation_time'] );
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
		$group_id = 1;
		$this->layout = 'ajax';
		$id = intval ( $this->request->data ['conv_id'] );
		// $fb_user_id = intval ( $this->request->data ['uid'] );
		$conversation = $this->Chat->find ( 'first', array (
				'conditions' => array (
						'Chat.group_id' => $group_id,
						'Chat.id' => $id 
				),
				'order' => array (
						'Chat.last_conversation_time' => 'DESC' 
				),
				'fields' => $this->fields 
		) );
		if (! $conversation) {
			// khong ton tai
			$this->autoRender = false;
			return '';
		}
		if (! $conversation ['Chat'] ['is_read']) {
			$this->_setRead ( $id );
		}
		$this->set ( 'last_conversation_time', $conversation ['Chat'] ['last_conversation_time'] );
		// co su thay doi => load lai
		$messages = $this->FBConversationMessage->find ( 'all', array (
				'conditions' => array (
						'FBConversationMessage.group_id' => $group_id,
						'FBConversationMessage.fb_conversation_id' => $id 
				),
				'order' => array (
						'FBConversationMessage.modified' => 'DESC' 
				),
				'fileds' => array (
						'FBConversationMessage.fb_user_id',
						'FBConversationMessage.content' 
				) 
		) );
		// $this->set ( 'fb_user_id', $fb_user_id );
		$this->set ( 'messages', $messages );
	}
	public function refreshMsg() {
		$group_id = 1;
		$this->layout = 'ajax';
		$id = intval ( $this->request->data ['conv_id'] );
		$fb_user_id = intval ( $this->request->data ['uid'] );
		$last_conversation_time = intval ( $this->request->data ['last'] );
		$sync_api = Configure::read ( 'sysconfig.FBChat.SYNC_MSG_API' ) . '?' . http_build_query ( array (
				'group_chat_id' => $id,
				'type' => 'inbox' 
		) );
		;
		// goi api sync tu fb api
		if (file_get_contents ( $sync_api ) != 'SUCCESS') {
			$this->autoRender = false;
			return '-1';
		}
		// check co message moi
		$conversation = $this->Chat->find ( 'first', array (
				'conditions' => array (
						'Chat.group_id' => $group_id,
						'Chat.id' => $id 
				),
				'order' => array (
						'Chat.last_conversation_time' => 'DESC' 
				),
				'fields' => array (
						'Chat.last_conversation_time' 
				) 
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
		$messages = $this->FBConversationMessage->find ( 'all', array (
				'conditions' => array (
						'FBConversationMessage.group_id' => $group_id,
						'FBConversationMessage.fb_conversation_id' => $id 
				),
				'order' => array (
						'FBConversationMessage.modified' => 'DESC' 
				),
				'fileds' => array (
						'FBConversationMessage.fb_user_id',
						'FBConversationMessage.content' 
				) 
		) );
		$this->set ( 'fb_user_id', $fb_user_id );
		$this->set ( 'messages', $messages );
	}
	public function refreshConversation() {
		$this->layout = 'ajax';
		$group_id = 1;
		// lay danh sach conversation
		// data: {last:last,selected:selected,page_id:page_id,type:type,is_read:is_read,has_order:has_order},
		$fb_page_id = $this->request->data ['page_id'];
		$type = $this->request->data ['type'];
		$is_read = $this->request->data ['is_read'];
		$has_order = $this->request->data ['has_order'];
		$selected_conversation = intval ( isset ( $this->request->data ['selected'] ) ? $this->request->data ['selected'] : 0 );
		$last_conversation_time = intval ( isset ( $this->request->data ['last'] ) ? $this->request->data ['last'] : 0 );
		if ($selected_conversation == 'undefined')
			$selected_conversation = 0;
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
				'order' => array (
						'Chat.last_conversation_time' => 'DESC' 
				),
				'fields' => $this->fields 
		) );
		if ($conversations) {
			if ($conversations [0] ['Chat'] ['last_conversation_time'] > $last_conversation_time) {
				// co su thay doi
				$this->set ( 'last_conversation_time', $conversations [0] ['Chat'] ['last_conversation_time'] );
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
		$this->layout = 'ajax';
		$send_api = Configure::read ( 'sysconfig.FBChat.SEND_MSG_API' );
		// lay danh sach conversation
		$message = $this->request->data ['message'];
		$group_chat_id = $this->request->data ['conv_id'];
		$type = 'inbox';
		// $ch = curl_init ();
		
		// curl_setopt ( $ch, CURLOPT_URL, $send_api );
		// curl_setopt ( $ch, CURLOPT_POST, 1 );
		// curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( array (
		// 'message' => $message,
		// 'group_chat_id' => $group_chat_id,
		// 'type' => $type
		// ) ) );
		// // receive server response ...
		// curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		// $response = curl_exec ( $ch );
		// curl_close ( $ch );
		// return $response;
		$send_api .= '?' . http_build_query ( array (
				'message' => $message,
				'group_chat_id' => $group_chat_id,
				'type' => $type 
		) );
		$rs = file_get_contents ( $send_api );
		if ($rs == 'SUCCESS') {
			$this->loadMsg ();
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
		$fb_user_id = $this->request->data ['fb_user_id'];
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