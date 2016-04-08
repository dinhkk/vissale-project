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
			'FBPostComments'
	);
	public $scaffold;
	public function index() {
		$group_id = 1;
		// lay danh sach conversation
		$conversations = $this->Chat->find('all',array(
				'conditions' => array (
						'Chat.group_id' => $group_id
				)
		));
		if ($conversations){
			$this->set('last', $conversations[0]['Chat']['last_conversation_time']);
		}
		else {
			$this->set('last',0);
		}
		$this->set('conversations',$conversations);
	}
	public function loadMsg() {
		$group_id = 1;
		$this->layout = 'ajax';
		$id = intval ( $this->request->data ['conv_id'] );
		$fb_user_id = intval ( $this->request->data ['uid'] );
		$conversation = $this->Chat->find('first',array(
				'conditions' => array (
						'Chat.group_id' => $group_id,
						'Chat.id'=>$id
				),
				'order'=>array('Chat.last_conversation_time'=>'DESC'),
				'fields'=>array('Chat.last_conversation_time')
		));
		if (!$conversation){
			// khong ton tai
			$this->autoRender = false;
			return '';
		}
		$this->set('last_conversation_time',$conversation['Chat']['last_conversation_time']);
		// co su thay doi => load lai
		$messages = $this->FBConversationMessage->find('all',array(
				'conditions' => array (
						'FBConversationMessage.group_id' => $group_id,
						'FBConversationMessage.fb_conversation_id' => $id
				),
				'order'=>array('FBConversationMessage.modified'=>'ASC')
		));
		$this->set('fb_user_id', $fb_user_id);
		$this->set ( 'messages', $messages );
	}
	
	public function refreshMsg(){
		$group_id = 1;
		$this->layout = 'ajax';
		$id = intval ( $this->request->data ['conv_id'] );
		$fb_user_id = intval ( $this->request->data ['uid'] );
		$last_conversation_time = intval ( $this->request->data ['last'] );
		// check co message moi
		$conversation = $this->Chat->find('first',array(
				'conditions' => array (
						'Chat.group_id' => $group_id,
						'Chat.id'=>$id
				),
				'order'=>array('Chat.last_conversation_time'=>'DESC'),
				'fields'=>array('Chat.last_conversation_time')
		));
		if (!$conversation){
			// khong ton tai
			$this->autoRender = false;
			return '0';
		}
		if ($conversation['Chat']['last_conversation_time']<=$last_conversation_time){
			// khong co su thay doi
			$this->autoRender = false;
			return '-1';
		}
		$this->set('last_conversation_time',$conversation['Chat']['last_conversation_time']);
		// co su thay doi => load lai
		$messages = $this->FBConversationMessage->find('all',array(
				'conditions' => array (
						'FBConversationMessage.group_id' => $group_id,
						'FBConversationMessage.fb_conversation_id' => $id
				),
				'order'=>array('FBConversationMessage.modified'=>'ASC')
		));
		$this->set('fb_user_id', $fb_user_id);
		$this->set ( 'messages', $messages );
	}
	public function refreshConversation() {
		$this->layout = 'ajax';
		$group_id = 1;
		// lay danh sach conversation
		$last_conversation_time = intval ( $this->request->data ['last'] );
		$selected_conversation = intval ( $this->request->data ['selected'] );
		if ($selected_conversation=='undefined')
			$selected_conversation = 0;
		$conversations = $this->Chat->find('all',array(
				'conditions' => array (
						'Chat.group_id' => $group_id
				)
		));
		if ($conversations){
			if($conversations[0]['Chat']['last_conversation_time']>$last_conversation_time){
				// co su thay doi
				$this->set('conversations',$conversations);
				$this->set('selected_conversation',$selected_conversation);
			}
			else {
				// khong co thay doi nao
				$this->autoRender = false;
				return '-1';
			}
		}
		else {
			// khong co conversation nao
			$this->autoRender = false;
			return '0';
		}
		
	}
}
