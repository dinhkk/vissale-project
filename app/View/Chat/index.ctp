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
							<div class="btn-group " id="ddbPageSelect">
								<a class="btn btn-default btn-flat dropdown-toggle btn-select2"
									data-toggle="dropdown" href="#" data-id="null">Tất Cả <span
									class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#" data-id="null"> Tất Cả </a></li>
									<li><a href="#" data-id="1643607829233206">Thuốc nam
											tăng cân hiệu quả-Hoàng Trung Đường</a></li>
									<li><a href="#" data-id="1676236829317557">Thuốc đông
											y tăng cân hiệu quả</a></li>
									<li><a href="#" data-id="182053188816490">Hoàng Trung
											Đường- thuốc tăng cân gia truyền</a></li>
									<li><a href="#" data-id="524432597738703">Đông y Hoàng
											Trung Đường</a></li>
									<li><a href="#" data-id="945870525490503">Thuôc Nam
											cho người Việt</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="input-group input-group">
							<div class="btn-group">
								<span class="btn btn-success btn-flat">Comment/Inbox</span>
							</div>
							<div class="btn-group" id="ddbType">
								<a class="btn btn-default btn-flat  dropdown-toggle btn-select2"
									data-toggle="dropdown" href="#" data-id="null">Tất Cả<span
									class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a data-id="null">Tất Cả</a></li>
									<li><a data-id="comment">Comment</a></li>
									<li><a data-id="inbox">Inbox</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="input-group input-group">
							<div class="btn-group">
								<span class="btn btn-danger btn-flat">Đọc/Chưa Đọc</span>
							</div>
							<div class="btn-group" id="ddbStatus">
								<a class="btn btn-default btn-flat dropdown-toggle btn-select2"
									data-toggle="dropdown" href="#" data-id="null">Tất Cả<span
									class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a data-id="null">Tất Cả</a></li>
									<li><a data-id="0">Đọc</a></li>
									<li><a data-id="1">Chưa Đọc</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="input-group input-group">
							<div class="btn-group">
								<span class="btn btn-warning btn-flat">Đơn Hàng</span>
							</div>
							<div class="btn-group" id="ddbOrder">
								<a class="btn btn-default btn-flat dropdown-toggle btn-select2"
									data-toggle="dropdown" href="#" data-id="null">Tất Cả<span
									class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a data-id="null">Tất Cả</a></li>
									<li><a data-id="isNotOrder">Chưa Có Đơn Hàng</a></li>
									<li><a data-id="isOrder">Có Đơn Hàng</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 fullHeigh"
				style="display: block; background-color: white;">
				<div style="height: 40px">
					<input type="text" class="form-control" id="search" value=""
						placeholder="Số Điện Thoại hoặc Nick Facebook">
				</div>
				<div id="Chat-Select" last="<?php echo isset($last)?intval($last):0; ?>" class=" row list-group" style="border-top: 1px solid #ccc;">
					<div class="slimScrollDiv">
						<div id="comment" cselected="">
							<?php foreach($conversations as $conv) { ?>
							<div class="list-group-item comment_item" last_time="<?php echo $conv['Chat']['last_conversation_time']; ?>" uid="<?php echo $conv['Chat']['fb_user_id']; ?>" conv_id="<?php echo $conv['Chat']['id']; ?>" style="border-radius: 0px;">
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
										<p class="unread">1</p>
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
					<div style="float: left; width: 550px">
						<div style="float: left; margin-right: 20px; margin-left: 20px">
							<img
								style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
								id="userImage">
						</div>
						<div style="margin-left: 20px">
							<table>
								<tbody>
									<tr>
										<td colspan="2"><a id="userName"></a></td>
									</tr>
									<tr>
										<td><label> Họ Tên:</label></td>
										<td><span id="customerName"> </span></td>
									</tr>
									<tr>
										<td><label>SĐT:</label></td>
										<td><span id="customerPhone"> </span></td>
									</tr>
									<tr>
										<td><label>Đơn Hàng:&nbsp;</label></td>
										<td><span id="customerOrder"> </span></td>
									</tr>
									<tr>
										<td><label> Địa Chỉ:</label></td>
										<td><span id="customerAddress"> </span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div style="float: right; margin-right: 20px">
						<a id="postLink" target="_blank" style="cursor: pointer"> <img
							style="width: 95px; height: 95px; margin: 5px 0px; background-color: #ccc;"
							id="postImage" alt="" title="">
						</a>
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