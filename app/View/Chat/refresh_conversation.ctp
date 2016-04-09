<div id="comment" cselected="" last="<?php echo $last_conversation_time; ?>">
	<?php if(is_array($conversations)) foreach($conversations as $conv) { ?>
	<div class="list-group-item comment_item" uid="<?php echo $conv['Chat']['fb_user_id']; ?>" conv_id="<?php echo $conv['Chat']['id']; ?>" style="border-radius: 0px;">
		<div class="row" style="padding: 15px;">
			<div class="col-md-3">
				<img
					style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
					src="http://graph.facebook.com/<?php echo $conv['Chat']['fb_user_id']; ?>/picture?type=normal">
			</div>
			<div class="col-md-5">
				<p>
					<a href="<?php echo "http://facebook.com/{$conv['Chat']['fb_user_id']}"; ?>"
						target="_blank"><?php echo $conv['Chat']['fb_user_id']; ?></a>
				</p>
				<p
					style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;"><?php echo h($conv['Chat']['first_content']); ?></p>
			</div>
			<div class="col-md-3 pull-right"
				style="text-align: right;">
				<p style="font-size: 11px;"><?php echo $conv['Chat']['modified']; ?></p>
				<p class="unread"><?php if(!$conv['Chat']['is_read']) echo 1; ?></p>
				<p class="fa fa-fw fa-comment"></p>
	
			</div>
		</div>
	</div>
	<?php } ?>
</div>