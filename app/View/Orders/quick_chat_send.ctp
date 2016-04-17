<div class="direct-chat-msg">
	<div class="direct-chat-info clearfix">
		<span class="direct-chat-name pull-left"><?php echo $page_name; ?></span><span
			class="direct-chat-timestamp pull-right">Just now</span>
	</div>
	<img class="direct-chat-img" src="<?php echo "http://graph.facebook.com/{$page_id}/picture?type=normal"; ?>">
	<div class="direct-chat-text"><?php h($message); ?></div>
</div>