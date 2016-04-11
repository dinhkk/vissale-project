<div id="listMsg" conv_id="<?php echo $id; ?>" style="margin-right: 20px; margin-left: 20px; overflow: hidden; width: auto;" last="<?php echo $last_conversation_time; ?>">
	<?php if(is_array($messages)) { foreach($messages as $msg) { $right = $fb_user_id!=$msg[$type]['fb_user_id']?true:false; ?>
	<div class="direct-chat-msg <?php if($right) echo 'right'; ?>">
	    <img class="direct-chat-img" style="border: 1px solid #ccc;" src="http://graph.facebook.com/<?php echo $msg[$type]['fb_user_id']; ?>/picture?type=normal" alt="message user image">
	    <div class="direct-chat-text" style="width: auto;float: <?php echo $right?'right':'left'; ?>; margin-right: 23px;">
	        <?php echo h($msg[$type]['content']) ?>
	    </div>
	</div>
	<?php } } ?>
</div>