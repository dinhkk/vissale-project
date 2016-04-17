<div class="box box-warning direct-chat direct-chat-warning"
	style="margin-bottom: 2px">
	<div class="box-header with-border">
		<h3 class="box-title" id="chattitle"><?php echo $customer_name; ?></h3>

		<div class="box-tools pull-right">
			<span data-toggle="tooltip" class="badge bg-yellow" id="totalMessage"></span>
			<a data-toggle="tooltip" class="badge bg-green" onclick="reloadCommentChat()"> Refresh</a>
		</div>
	</div>
	<!-- /.box-header -->
	<div class="box-body" id ="box-body-chat">
		<!-- Conversations are loaded here -->
		<div class="direct-chat-messages" id="listChatMessage" conv_id="<?php echo $fb_conversation_id; ?>" last="<?php echo $last; ?>">
			<?php foreach($messages as $msg) { $is_customer = $msg['FBPostComments']['fb_user_id']==$fb_user_id; ?>
				<div class="direct-chat-msg <?php if(!$is_customer) echo 'right'; ?>">
					<div class="direct-chat-info clearfix">
						<span class="direct-chat-name pull-left"><?php echo $is_customer? $customer_name : $page_name; ?></span><span
							class="direct-chat-timestamp pull-right"><?php echo $msg['FBPostComments']['user_created']; ?></span>
					</div>
					<img class="direct-chat-img" src="<?php echo "http://graph.facebook.com/{$msg['FBPostComments']['fb_user_id']}/picture?type=normal"; ?>">
					<div class="direct-chat-text"><?php h($msg['FBPostComments']['content']) ?></div>
				</div>
			<?php } ?>
		</div>
		<!--/.direct-chat-messages-->

	</div>
	<!-- /.box-body -->
	<div class="box-footer">

		<div class="input-group">
			<input type="text" name="message" id="txtMessage" style="height: 27px;"
				placeholder="Nhập tin Nhắn" class="form-control"> <span
				class="input-group-btn"> <input type="button" id="btnSendMessage"
				style="margin-top: 0px" class="btn btn-warning btn-flat" value="Send">

			</span>
		</div>

	</div>
	<!-- /.box-footer-->
</div>