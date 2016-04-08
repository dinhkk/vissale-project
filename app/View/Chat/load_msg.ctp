<div id="listMsg" style="margin-right: 20px; margin-left: 20px; overflow: hidden; width: auto;" last="<?php echo $last_conversation_time; ?>">
	<?php if(is_array($messages)) { $i=true; foreach($messages as $msg) { ?>
	<div class="direct-chat-msg <?php if($i==true) { echo 'right'; $i=false; } else { $i=true; } ?>">
	    <img class="direct-chat-img" style="border: 1px solid #ccc;" src="http://graph.facebook.com/<?php echo $msg['FBConversationMessage']['fb_user_id']; ?>/picture?type=normal" alt="message user image">
	    <div class="direct-chat-text" style="    width: auto;float: <?php echo $i?'left':'right'; ?>; margin-right: 23px;">
	        <?php echo h($msg['FBConversationMessage']['content']) ?>"
	    </div>
	</div>
	<?php } } ?>
</div>