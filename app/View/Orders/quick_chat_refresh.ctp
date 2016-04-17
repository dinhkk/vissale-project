<!-- Conversations are loaded here -->
<div class="direct-chat-messages" id="listChatMessage"  conv_id="<?php echo $fb_conversation_id; ?>" last="<?php echo $last; ?>">
	<?php foreach($messages as $user_id => $msg) { $is_customer = $user_id==$fb_user_id; ?>
		<div class="direct-chat-msg <?php if(!$is_customer) echo 'right'; ?>">
			<div class="direct-chat-info clearfix">
				<span class="direct-chat-name pull-left"><?php echo $is_customer? $customer_name : $page_name; ?></span><span
					class="direct-chat-timestamp pull-right">$msg['user_created']</span>
			</div>
			<img class="direct-chat-img" src="<?php echo "http://graph.facebook.com/{$user_id}/picture?type=normal"; ?>">
			<div class="direct-chat-text">h($msg['content'])</div>
		</div>
	<?php } ?>
</div>
<!--/.direct-chat-messages-->