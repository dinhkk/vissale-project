<?php
	echo $this->Html->script(array(
	    '/js/jquery.slimscroll.min',
	    '/js/chat'
	));
	echo $this->Html->css(array('/css/chat','/css/AdminLTE.min'));
?>
<section class="content">
	<div class="row fullHeigh">
		<div class="col-md-12">
			<div class="col-md-12 "
				style="background-color: white; display: block;">
				<div class="row ontop" id="comment_filter">

					<div class="col-md-3">
						<div class="input-group input-group">
							<div class="btn-group">
								<span class="btn btn-info btn-flat">Page</span>
							</div>
							<div class="btn-group">
								<a class="btn btn-default btn-flat dropdown-toggle btn-select2" data-toggle="dropdown" href="#" id="selected_page" data-id="all">Tất Cả <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#" class="select_page" data-id="all"> Tất Cả </a></li>
									<?php foreach($pages as $page) { ?>
									<li><a class="select_page" href="#" data-id="<?php echo $page['FBPage']['id']; ?>"><?php echo $page['FBPage']['page_name']; ?></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="input-group input-group">
							<div class="btn-group">
								<span class="btn btn-success btn-flat">Comment/Inbox</span>
							</div>
							<div class="btn-group">
								<a class="btn btn-default btn-flat  dropdown-toggle btn-select2"
									data-toggle="dropdown" href="#" data-id="all" id="selected_type" >Tất Cả<span
									class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a class="select_type" data-id="all">Tất Cả</a></li>
									<li><a class="select_type" data-id="1">Comment</a></li>
									<li><a class="select_type" data-id="0">Inbox</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="input-group input-group">
							<div class="btn-group">
								<span class="btn btn-danger btn-flat">Đọc/Chưa Đọc</span>
							</div>
							<div class="btn-group">
								<a class="btn btn-default btn-flat dropdown-toggle btn-select2"
									data-toggle="dropdown" href="#" data-id="all" id="selected_read">Tất Cả<span
									class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a class="select_read" data-id="all">Tất Cả</a></li>
									<li><a class="select_read" data-id="1">Đọc</a></li>
									<li><a class="select_read" data-id="0">Chưa Đọc</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="input-group input-group">
							<div class="btn-group">
								<span class="btn btn-warning btn-flat">Đơn Hàng</span>
							</div>
							<div class="btn-group">
								<a class="btn btn-default btn-flat dropdown-toggle btn-select2"
									data-toggle="dropdown" href="#" data-id="all" id="selected_order">Tất Cả<span
									class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a class="select_order" data-id="all">Tất Cả</a></li>
									<li><a class="select_order" data-id="0">Chưa Có Đơn Hàng</a></li>
									<li><a class="select_order" data-id="1">Có Đơn Hàng</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 fullHeigh"
				style="display: block; background-color: white;">
				<div style="height: 40px">
					<input type="text" class="form-control" id="txtSearch" value=""
						placeholder="Số Điện Thoại hoặc FacebookID">
				</div>
				<div id="Chat-Select" class="row list-group" style="border-top: 1px solid #ccc;">
					<div id="listConversation" class="slimScrollDiv">
						<div id="comment" cselected="" last="<?php echo isset($last)?intval($last):0; ?>">
							<?php foreach($conversations as $conv) { ?>
							<div class="list-group-item comment_item" uid="<?php echo $conv['Chat']['fb_user_id']; ?>" conv_id="<?php echo $conv['Chat']['id']; ?>" style="border-radius: 0px;">
								<div class="row" style="padding: 15px;">
									<div class="col-md-3">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/<?php echo $conv['Chat']['fb_user_id']; ?>/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a class="chatName" href="<?php echo "http://facebook.com/{$conv['Chat']['fb_user_id']}"; ?>"
												target="_blank"><?php echo !empty($conv['Chat']['fb_user_name'])?$conv['Chat']['fb_user_name']:$conv['Chat']['fb_user_id']; ?></a>
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
					</div>

				</div>

			</div>
			<div class="col-md-8 fullHeigh white" id="chatcontainer">

				<div class="row ontop" id="header_chat"
					style="border-bottom: 1px solid gray; font-size: 11.5px">
					<div style="float: left; width: 550px" id="customerInfo">
						<div style="float: left; margin-right: 20px; margin-left: 20px">
							<img id="customerImg" style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;" src="" />
						</div>
						<div style="margin-left: 20px">
							<table>
								<tbody>
									<tr>
										<td colspan="2"><a></a></td>
									</tr>
									<tr>
										<td><label> Họ Tên:</label></td>
										<td><span id="customerName"></span></td>
									</tr>
									<tr>
										<td><label>SĐT:</label></td>
										<td><span id="customerPhone"></span></td>
									</tr>
									<tr>
										<td><label> Địa Chỉ:</label></td>
										<td><span  id="customerAddr"></span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div style="float: right; margin-right: 20px">
						<!-- <a id="postLink" target="_blank" style="cursor: pointer"> <img
							style="width: 95px; height: 95px; margin: 5px 0px; background-color: #ccc;"
							id="postImage" alt="" title="">
						</a> -->
					</div>
				</div>
				<div class="direct-chat direct-chat-primary" id="chatContent" style="background-color: rgb(230, 230, 230);">
					<div class="slimScrollDiv" id="chatbox">
						
					</div>
				</div>
				<div class="row" id="footer_chat">
					<div class="input-group input-group-lg">
						<input placeholder="Nội dung tin nhắn..." id="txtMessage"
							name="txtMessage" class="form-control">
							<span class="input-group-btn">
							<button class="btn btn-info btn-flat btn-facebook"
								style="border-radius: 0px !important" id="btnSend" type="button">Gửi</button>
							</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
$(function(){
    $('#Chat-Select').slimScroll({
        height: '500px',
        railVisible: true,
	    alwaysVisible: true,
		allowPageScroll: false,
    });
    $('#chatContent').slimScroll({
        height: '400px',
        railVisible: true,
	    alwaysVisible: true,
		allowPageScroll: false,
    });
});
</script>