<?php
echo $this->Html->script(array(
    //'/js/jquery.slimscroll.min',
    '/js/chat'
));
echo $this->Html->css(array(
        '/css/chat',
        //'/css/AdminLTE.min'
    )
);
?>

<div
    id="overlay-loading"
    class="well well-lg bs-loading-container"
    style="
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 9999;
    top: 0;
    left: 0;
    opacity: .8;"
    bs-loading-overlay
    bs-loading-overlay-delay="2000"
>
</div>

<section class="content chat-section" ng-controller="ChatController" style="padding: 0;">

    <div id="chat-left" class="chat-left portlet light bordered" style="">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-share font-blue"></i>
                <span class="caption-subject font-blue bold uppercase font-blue">Conversations</span>
            </div>

            <div class="actions" style="margin-left: 10px;">
                <div class="portlet-input input-inline">
                    <div class="btn-group">

                        <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true">
                            Lọc tin nhắn
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <div class="dropdown-menu hold-on-click dropdown-checkboxes" role="menu">
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox"></span></div>
                                <i class="fa fa-comments"></i>
                                Nhận xét
                            </label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox" checked=""></span>
                                </div>
                                <i class="fa fa-comment"></i>
                                Tin nhắn</label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox"></span></div>
                                <i class="fa fa-shopping-cart"></i>
                                Có Đơn hàng
                            </label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox"></span></div>
                                <i class="fa fa-question"></i>
                                Chưa có đơn hàng
                            </label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox" checked=""></span>
                                </div>
                                <i class="fa fa-square-o"></i>
                                Chưa đọc
                            </label>
                            <label>
                                <div class="checker"><span class="checked"><input type="checkbox"></span></div>
                                <i class="fa fa-check-square-o"></i>
                                Đã đọc
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <div class="portlet-input input-inline">
                    <div class="btn-group">
                        <button class="btn btn-lg green dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-expanded="true"> Tìm Tin Nhắn
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-content input-large hold-on-click" role="menu">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="search..."
									   style="height: 32px;">
								<span class="input-group-btn">
                                                                                <button class="btn blue"
																						type="submit"><i
																						class="icon-magnifier"></i></button>
                                                                            </span>
							</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions" style="margin-left: 10px; width: 400px;">
                <div class="portlet-input" style="width: 100%;">
                    <div class="form-group" style="display: inline;">
                        <label class="col-md-2 control-label" style="margin-top: 4px;">Trang:</label>
                        <div class="col-md-10" style="padding-left: 0;">
                            <select class="form-control"
									ng-change="changePage()"
									ng-model="currentPage"
									ng-selected="currentPage"
									ng-options="page.id as page.page_name for page in pages"
							>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row fullHeigh">
            <div class="col-md-4 bg-white " style="padding-right: 0;">

                <!-- =============================================================== -->
                <!-- member list -->
                <ul id="friend-list" class="friend-list" style="padding-right: 10px;">

                    <!--<li class="active bounceInDown">
                        <a href="#" class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">
                            <div class="friend-name">
                                <strong>John Doe</strong>
                            </div>
                            <div class="last-message text-muted">Hello, Are you there?</div>
                            <small class="time text-muted">Just now</small>
                            <small class="chat-alert label label-danger">1</small>
                            <small class="chat-alert has-order label label-success">
                                <i class="fa fa-shopping-cart"></i>
                            </small>
                        </a>
                    </li>-->

					<!--->
                    <li ng-class="{active:currentConversation==conversation, bounceInDown:currentConversation==conversation, unread: conversation.is_read==0}"
						ng-repeat="conversation in conversations.data"
						ng-click="setActiveConversation(conversation)">
                        <a ng-href="#user" title="{{conversation.fb_user_name}}" class="clearfix">
                            <img ng-src="https://graph.facebook.com/{{conversation.fb_user_id}}/picture?type=normal" alt="" class="img-circle">
                            <div class="friend-name">
                                <span

										t

										itle="{{conversation.fb_user_name}}">{{conversation.fb_user_name}}</span>
                            </div>
                            <div class="last-message text-muted">{{conversation.first_content}}</div>
                            <small class="time text-muted">5 mins ago</small>

							<!-- labels -->
							<small ng-if="conversation.has_order" class="chat-alert has-order label label-success">
								<i class="fa fa-shopping-cart"></i>
							</small>
                            <small ng-if="conversation.is_read" class="chat-alert text-muted"
								   style="font-size: 15px;
    								padding: 0;
    								top: 30px;">
								<i class="fa fa-check"></i>
							</small>
							<small ng-if="!conversation.is_read" class="chat-alert label label-danger">1</small>
							<small ng-if="conversation.type==0" class="chat-alert label inbox"><i class="icon-envelope"></i></small>
							<small ng-if="conversation.type==1" class="chat-alert label comment"><i class="fa fa-comments"></i></small>
                        </a>
                    </li>
                </ul>
            </div>

            <!--=========================================================-->
            <!-- selected chat -->
            <div class="col-md-8 bg-white" style="padding-right: 0;">
                <div class="chat-message">

                    <ul class="chat" id="chat-history">

						<span ng-repeat="message in messages.chat">
							<!--Fb user message-->
							<li ng-if="currentConversation.page_id != message.fb_user_id"
								class="left clearfix">
								<span class="chat-img pull-left">
									<img ng-src="https://graph.facebook.com/{{currentConversation.fb_user_id}}/picture?type=normal" alt="User Avatar">
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="primary-font">{{currentConversation.fb_user_name}}</strong>
										<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago
										</small>
									</div>
									<p>
										{{message.content}}
									</p>
								</div>
							</li>

							<!--page message-->
							<li ng-if="currentConversation.page_id == message.fb_user_id"
								class="right clearfix">
								<span class="chat-img pull-right">
									<img ng-src="https://graph.facebook.com/{{currentPage.page_id}}/picture?type=normal" alt="User Avatar">
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="primary-font">{{currentPage.page_name}}</strong>
										<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago
										</small>
									</div>
									<p>
										{{message.content}}
									</p>
								</div>
							</li>
						</span>
                    </ul>

                </div>
                <div class="chat-box bg-white">
                    <div class="actions" style="margin-bottom: 5px;">
                        <a class="btn btn-circle btn-icon-only btn-default tooltips" href="javascript:;"
                           data-container="body"
                           data-placement="bottom"
                           data-original-title="Gửi ảnh">
                            <i class="icon-cloud-upload"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-wrench"></i>
                        </a>
                        <a ng-show="currentConversation.post_id"
                           href="https://fb.com/{{currentConversation.post_id}}"
                           target="_blank"
                           class="btn btn-circle btn-icon-only btn-default tooltips"
                           data-container="body" data-placement="bottom"
                           data-original-title="Xem link bài viết trên facebook">
                            <i class="fa fa-external-link"></i>
                        </a>

                    </div>
                    <div class="input-group">
						<input class="form-control no-shadow no-rounded" placeholder="Type your message here">
                        <span class="input-group-btn">
            			<button class="btn btn-success no-rounded" type="button"><i
                                class="fa fa-send"></i> Send</button>
            		</span>
                    </div><!-- /input-group -->
                </div>
            </div>
        </div>
    </div>
    <div id="chat-right"  class="chat-right portlet light bordered" style="">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="fullHeigh">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="fa fa-shopping-cart font-red"></i>
                            <span class="caption-subject font-red bold uppercase">Đơn hàng</span>
                        </div>
                        <ul class="nav nav-tabs" style="clear: both;">
                            <li class="active">
                                <a href="#portlet_comments_1" data-toggle="tab" aria-expanded="true"> Lịch sử </a>
                            </li>
                            <li class="">
                                <a href="#portlet_comments_2" data-toggle="tab" aria-expanded="false"> Tạo mới </a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <?php echo $this->element('Chat/customer_order'); ?>
                            <?php echo $this->element('Chat/create_order'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {


        $('input[type="file"]#fileMessage').change(function () {

            var conversation_id = $('#listMsg').attr('conv_id');

            var file = $(this).prop('files')[0];

            var formData = new FormData();

            formData.append('file_message', file, file.name);

            formData.append('conversation_id', conversation_id);

            //loading
            $.LoadingOverlay("show");

            $.ajax({
                url: '/Attachment/uploadFile', // point to server-side PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'POST',
                dataType: 'json',

                success: function (response) {
                    $.LoadingOverlay("hide");
                    //console.log(response); // display response from the PHP script, if any

                    if (response.error == 1) {
                        notify('error', 'Có Lỗi !', response.message);
                    }

                    if (response.error == 0) {
                        notify('success', 'Thống Báo', response.message);

                        $('#txtMessage').val(response.data);
                        $("#btnSend").trigger("click");
                    }

                    //clear input control
                    var control = $(this);
                    control.replaceWith(control = control.clone(true));
                }
            });

        });

		//init scroll
		initFriendListScroll();


    });

    function uploadTrigger() {
        var conversation_id = $('#listMsg').attr('conv_id');
        if (typeof conversation_id == 'undefined') {
            console.log('undefined conversation_id');
            return false;
        }

        $("input#fileMessage").trigger("click");
    }

	$(function () {
		//handleScroll();
	});


	//init slimScrollDiv friend List
	function initFriendListScroll() {
		var chat_height = $( window ).height() - 110;
		$("#chat-left").height( chat_height );
		$("#chat-right").height( chat_height );

		$('#friend-list').slimScroll({
			height: chat_height - 50 + 'px',
			railVisible: true,
			alwaysVisible: true,
			allowPageScroll: true
		});

		$('#chat-history').slimScroll({
			height: chat_height - 130 + 'px',
			railVisible: true,
            alwaysVisible: false,
			allowPageScroll: true
		});
	}
</script>

<?php
	echo $this->Html->script(array(
		'/js/chat-app',
	));
?>
