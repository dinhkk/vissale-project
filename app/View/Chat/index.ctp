<?php
	echo $this->Html->script(array(
	    '/js/jquery.slimscroll.min',
	    '/js/chat',
	));
	echo $this->Html->css('/css/chat');
?>
<script>
$(function(){
    $('#slimScrollDiv').slimScroll({
        height: '250px'
    });
});
</script>
<section class="content">
	<div class="row fullHeigh" style="height: 611px;">
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
				style="display: block; height: 611px; background-color: white;">
				<div style="height: 40px">
					<input type="text" class="form-control" id="search" value=""
						placeholder="Số Điện Thoại hoặc Nick Facebook">
				</div>
				<div id="Chat-Select" class=" row list-group"
					style="border-top: 1px solid #ccc;">
					<div class="slimScrollDiv"
						style="position: relative; overflow: hidden; width: auto; height: 577px;">
						<div id="comment" class=""
							style="height: 577px; overflow: hidden; width: auto;">


							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677981442462511"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677981442462511&quot;, this, &quot;comment&quot;, &quot;Quốc Vinh&quot;, &quot;581619035345889&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/581619035345889/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/581619035345889/"
												target="_blank">Quốc Vinh</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0938174493</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">khoảng 9 giờ trước</p>
										<p class="unread">1</p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677941295799859"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677941295799859&quot;, this, &quot;comment&quot;, &quot;Nguyen Luong Bang&quot;, &quot;1032038726868541&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1032038726868541/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1032038726868541/"
												target="_blank">Nguyen Luong Bang</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0934659229</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">khoảng 12 giờ trước</p>
										<p class="unread">1</p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677812665812722"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677812665812722&quot;, this, &quot;comment&quot;, &quot;Ke No Doi&quot;, &quot;575888695903735&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/575888695903735/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/575888695903735/"
												target="_blank">Ke No Doi</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0918648101</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">khoảng 22 giờ trước</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677773069150015"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677773069150015&quot;, this, &quot;comment&quot;, &quot;Han Nguyen&quot;, &quot;1680641535558194&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1680641535558194/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1680641535558194/"
												target="_blank">Han Nguyen</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">Thuoc
											nay bao nhieu 1hop, va xuat xu o dau vay nha thuoc</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677771529150169"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677771529150169&quot;, this, &quot;comment&quot;, &quot;Nguyen Ngoc Tu Nguyen&quot;, &quot;1582367305412179&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1582367305412179/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1582367305412179/"
												target="_blank">Nguyen Ngoc Tu Nguyen</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">Cần
											tư vấn gấp</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677771379150184"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677771379150184&quot;, this, &quot;comment&quot;, &quot;Nguyen Ngoc Tu Nguyen&quot;, &quot;1582367305412179&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1582367305412179/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1582367305412179/"
												target="_blank">Nguyen Ngoc Tu Nguyen</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">01636060412</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677771309150191"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677771309150191&quot;, this, &quot;comment&quot;, &quot;Nguyen Ngoc Tu Nguyen&quot;, &quot;1582367305412179&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1582367305412179/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1582367305412179/"
												target="_blank">Nguyen Ngoc Tu Nguyen</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">01636060413</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677768585817130"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677768585817130&quot;, this, &quot;comment&quot;, &quot;Mai Minh Kiệt&quot;, &quot;997922646947722&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/997922646947722/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/997922646947722/"
												target="_blank">Mai Minh Kiệt</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">.</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677701065823882"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677701065823882&quot;, this, &quot;comment&quot;, &quot;Maria Hồng&quot;, &quot;1679913302267756&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1679913302267756/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1679913302267756/"
												target="_blank">Maria Hồng</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">O936564197</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677674352493220"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677674352493220&quot;, this, &quot;comment&quot;, &quot;Thai Huynh&quot;, &quot;1699482496997878&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1699482496997878/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1699482496997878/"
												target="_blank">Thai Huynh</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">thai
											huynh 01686902464</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677627122497943"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677627122497943&quot;, this, &quot;comment&quot;, &quot;Đỗquang Tỉnh&quot;, &quot;205601693152702&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/205601693152702/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/205601693152702/"
												target="_blank">Đỗquang Tỉnh</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0984108141</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677624945831494"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677624945831494&quot;, this, &quot;comment&quot;, &quot;Hue Vu&quot;, &quot;1743510632535760&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1743510632535760/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1743510632535760/"
												target="_blank">Hue Vu</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0902286854</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677602199167102"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677602199167102&quot;, this, &quot;comment&quot;, &quot;Dương Tuân&quot;, &quot;482107305283439&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/482107305283439/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/482107305283439/"
												target="_blank">Dương Tuân</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">01649760680</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread">1</p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="m_mid.1459905027044:92b3fa174b645c9306" postid="null"
								onclick="commentClick(&quot;m_mid.1459905027044:92b3fa174b645c9306&quot;, this, &quot;inbox&quot;, &quot;Dinh Phan&quot;, &quot;573536732805150&quot;, &quot;null&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/573536732805150/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/573536732805150/"
												target="_blank">Dinh Phan</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">mình
											muốn đặt thuốc</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-envelope"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677600262500629"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677600262500629&quot;, this, &quot;comment&quot;, &quot;Hộp Thư Tri Ân&quot;, &quot;1679592015620542&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1679592015620542/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1679592015620542/"
												target="_blank">Hộp Thư Tri Ân</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0918504239</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread"></p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677580092502646"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677580092502646&quot;, this, &quot;comment&quot;, &quot;Hiền Mai&quot;, &quot;1738004973142281&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1738004973142281/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1738004973142281/"
												target="_blank">Hiền Mai</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">Mai
											Hiền, 0975130733</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread">1</p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677485099178812"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677485099178812&quot;, this, &quot;comment&quot;, &quot;Nguyen Vu&quot;, &quot;826085767537324&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/826085767537324/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/826085767537324/"
												target="_blank">Nguyen Vu</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0915285879</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread">1</p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677479932512662"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677479932512662&quot;, this, &quot;comment&quot;, &quot;Hai Phong&quot;, &quot;1505361833101991&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/1505361833101991/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/1505361833101991/"
												target="_blank">Hai Phong</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0932248333</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread">1</p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677452319182090"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677452319182090&quot;, this, &quot;comment&quot;, &quot;Hong Nguyen&quot;, &quot;169030780146964&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/169030780146964/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/169030780146964/"
												target="_blank">Hong Nguyen</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0987857930</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">hôm qua</p>
										<p class="unread">1</p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>

							<div class="list-group-item comment_item"
								style="border-radius: 0PX;"
								commentid="1674584586135530_1677390459188276"
								postid="1643607829233206_1674584586135530"
								onclick="commentClick(&quot;1674584586135530_1677390459188276&quot;, this, &quot;comment&quot;, &quot;Tinh Xua Vung Dai&quot;, &quot;538598603011098&quot;, &quot;1643607829233206_1674584586135530&quot;,&quot;1643607829233206&quot;)"
								data="'{data}'">
								<div class="row ">
									<div class="col-md-3" style="padding: 5px;">
										<img
											style="border-radius: 50%; width: 60px; height: 60px; margin: 5px 0px; background-color: #ccc;"
											src="http://graph.facebook.com/538598603011098/picture?type=normal">
									</div>
									<div class="col-md-5">
										<p>
											<a
												href="https://www.facebook.com/app_scoped_user_id/538598603011098/"
												target="_blank">Tinh Xua Vung Dai</a>
										</p>
										<p
											style="text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block; overflow: hidden;">0974041938</p>
									</div>
									<div class="col-md-3 pull-right"
										style="text-align: right; margin: 10px 0px;">
										<p style="font-size: 11px;">05/04/16</p>
										<p class="unread">1</p>
										<p class="fa fa-fw fa-comment"></p>

									</div>
								</div>
							</div>
						</div>
						<div class="slimScrollBar"
							style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 203.253px; background: rgb(0, 0, 0);"></div>
						<div class="slimScrollRail"
							style="width: 7px; height: 100%; position: absolute; top: 0px; display: block; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
					</div>

				</div>

			</div>
			<div class="col-md-8 fullHeigh white" id="chatcontainer"
				style="height: 611px;">

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


				<div class="direct-chat direct-chat-primary" id="chatcontent"
					style="height: 380px; background-color: rgb(230, 230, 230);">
					<div class="slimScrollDiv"
						style="position: relative; overflow: hidden; width: auto; height: 380px;">
						<div id="chatbox"
							style="margin-right: 20px; margin-left: 20px; overflow: hidden; width: auto; height: 380px;">

						</div>
						<div class="slimScrollBar"
							style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 380px; background: rgb(0, 0, 0);"></div>
						<div class="slimScrollRail"
							style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
					</div>
				</div>
				<div class="row" id="footer_chat">
					<div class="input-group input-group-lg">
						<span class="input-group-btn">
							<button class="btn btn-info btn-facebook"
								style="border-radius: 0px !important"
								onclick="return ChooseReplyComment();" type="button">Chọn</button>
						</span>
						<div class="holder">
							<div id="popup" class="popup">
								<script>
                                function closeProductSelect() {
                                    $(".holder").hide();
                                }
                            </script>

								<div class="content">

									<div style="width: 100%">
										<script type="text/javascript">

    $(function () {

        $('[data-toggle="tooltip"]').tooltip();
    });

    var btnClose = function () {
        $('.holder').hide();
    };

    function chooseMessage(values) {
        $('#txtMessage').val($(values).text()).focus();
        $('.holder').hide();
    }

    function removeMessage(thiz, values)
    {
        $.ajax({
            type: "POST",
            url: '/FanPage/removeMessageFunction',
            data: {
                messageID: values,
            },
            success: function (data) {
                if (data == "Thành công!")
                {
                    //  MessagePopup.PerformCallback('ChooseListMessagePartial')

                    $(thiz).parent().parent().remove();

                }
                else
                    alert(data);
            }
        });
    }

    function addMessage()
    {

        var message = $("#contentMessage").val();
        if (message == '')
            return;

        $.ajax({
            type: "POST",
            url: '/FanPage/addMessageFunction',
            data: {
                content: message,
            },
            success: function (data) {
                if (data == "Thành công!") {

                    var html = ' <tr>'+
                    ' <td   style="float: left; margin-top: 5px; width: 400px;  overflow: hidden; white-space: nowrap; text-overflow: ellipsis; ">'+
                   '  <a href="#" title="'+message+'" onclick="chooseMessage(this)">'+message+'</a>'+
                   ' </td>'+
                   ' <td style="float: right;">'+
                   '    <input type="button" style="margin: 5px;" value="X" onclick="removeMessage(this,"' + message + '" )" class="btn btn-danger" />' +
                  '  </td>'+
                  '</tr>';

                    $('#idStyleTable').append(html);
                    $("#contentMessage").val('');
                }
                else
                    alert(data);
            }
        });
    }
</script>
										<form action="/FanPage/ChooseListMessagePartial" method="post"
											novalidate="novalidate">
											<input name="__RequestVerificationToken" type="hidden"
												value="qJwE70H9D851AkPrzfJfcNInQX2h77Gu_fr1ltLPeqXgLAP9SaXBtSEENe7vzMPTAeAkXZBTufjZeP-NFhyARXlwORXo2uIBdAID0TfvsIU1">
											<div class="slimScrollDiv"
												style="position: relative; overflow: hidden; width: auto; height: 330px;">
												<div id="chooseMessage"
													style="overflow: hidden; height: 330px; width: auto;">

													<table class="styleTable" id="idStyleTable"
														style="width: 98%">
													</table>
												</div>
												<div class="slimScrollBar"
													style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div>
												<div class="slimScrollRail"
													style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
											</div>
											<div class="form-horizontal">
												<table class="styleTable" style="margin-top: 10px;">
													<tbody>
														<tr>
															<td>Nội dung: &nbsp;&nbsp;</td>
															<td><input type="text" name="contentMessage"
																id="contentMessage" style="width: 265px"></td>
															<td><input type="button" value="Thêm"
																onclick="addMessage()" class="btn btn-primary"
																style="margin-left: 5px;"> <input type="button"
																value="Đóng" onclick="closeProductSelect()"
																class="btn btn-danger" style="margin-left: 5px;">
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<input placeholder="Nội dung tin nhắn..." id="txtMessage"
							name="txtMessage" onkeyup="return tableInputKeyPress(event)"
							onkeydown="SendClick(event)" type="text" class="form-control">
						<input type="file" accept="image/*" id="photoupload"
							onchange="loadFile(event)" style="display: none"> <span
							class="input-group-btn">
							<button id="imgpr" class="btn btn-info btn-flat btn-facebook "
								style="border-radius: 0px !important" onclick="ClickUpLoad();"
								type="button">
								<i class="fa fa-fw fa-image"></i>
							</button>
							<button class="btn btn-info btn-flat btn-facebook"
								style="border-radius: 0px !important"
								onclick="return ReplyComment();" type="button">Gửi</button>
						</span> <input type="file" accept="image/*" id="photoupload"
							onchange="loadFile(event)" style="display: none">

						<script>
                        var loadFile = function (event) {
                            var output = document.getElementById('imgpr');
                            output.src = URL.createObjectURL(event.target.files[0]);
                        };
                        function ChooseReplyComment() {
                            $('.holder').show();
                        }
                        function ClickUpLoad() {
                            $("#photoupload").click();
                        }
                    </script>
					</div>
					<script>
                    var loadFile = function (event) {
                        var output = document.getElementById('imgpr');
                        output.src = URL.createObjectURL(event.target.files[0]);
                    };
                </script>
				</div>
			</div>
		</div>
	</div>
</section>