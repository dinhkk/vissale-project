<?php
echo $this->Html->script(array(
    //'/js/jquery.slimscroll.min',
    //'/js/chat'
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
    bs-loading-overlay-delay="1000">
</div>

<section class="content chat-section" ng-controller="ChatController" style="padding: 0;">

    <div id="chat-left" class="chat-left portlet light bordered" style="visibility: hidden;">
        <div class="portlet-title">
			<div class="actions" style="margin-left: 0;width: 233px; float:left;">
				<div class="portlet-input input-inline">
					<div class="input-group">
						<input ng-keypress="enterSearchConversation($event)"
							   tooltip-placement="top-left" uib-tooltip="Gõ ít nhất 3 ký tự để tìm kiếm"
							   tooltip-append-to-body="true"
							   ng-model="search" type="text" class="form-control" placeholder="Tìm sđt hoặc tên fb"
							   style="height: 34px;">
						<span class="input-group-btn">
							<button class="btn blue" type="button" ng-click="searchConversation()">
								<i class="icon-magnifier"></i>
							</button>
						</span>
					</div>
				</div>
			</div>

            <div class="actions" style="margin-left: 10px; width: 400px; float:left;">
                <div class="portlet-input" style="width: 100%;">
                    <div class="form-group" style="display: inline;">
                        <label class="col-md-2 control-label" style="margin-top: 4px;">Trang:</label>
                        <div class="col-md-10" style="padding-left: 0;">
                            <select class="form-control"
									ng-change="changePage()"
									ng-model="currentPageId"
									ng-selected="currentPageId"
									ng-options="page.id as page.page_name for page in pages"
							>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

			<div class="actions" style="margin-left: 10px; float:left;">
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

        </div>

        <div class="row fullHeigh">
            <div class="col-md-4 bg-white " style="padding-right: 0;">
				<div
						id="overlay-loading-refresh-conversations"
						class="well well-lg bs-loading-container"
						style="
						position: absolute;
						width: 100%;
						height: 100%;
						z-index: 9999;
						top: 0;
						left: 0;
						opacity: .8;"
						bs-loading-overlay
						bs-loading-overlay-reference-id="refresh-conversations-spinner"
						bs-loading-overlay-delay="1000">
				</div>
                <!-- =============================================================== -->
                <!-- member list -->
                <ul id="friend-list" class="friend-list" style="padding-right: 10px;">

					<!--->
                    <li ng-class="{active:currentConversation==conversation, bounceInDown:currentConversation==conversation, unread: conversation.is_read==0}"
						ng-repeat="conversation in conversations.data | orderBy:'-last_conversation_time'"
						ng-click="setActiveConversation(conversation)"
						ng-if="filterByCurrentPage(conversation)"
					>
                        <a ng-href="#user" class="clearfix">
                            <img class="avatar"
									ng-src="https://graph.facebook.com/{{conversation.fb_user_id}}/picture?type=normal" alt="" class="img-circle">
                            <div class="friend-name">
                                <span title="{{conversation.fb_user_name}}">{{conversation.fb_user_name}}</span>
                            </div>
                            <div uib-popover="{{trustHtml(conversation.first_content)}}"
                                 popover-append-to-body = "true"
                                 popover-placement="top"
                                 popover-trigger="'mouseenter'"
                                 class="last-message text-muted">
								{{trustHtml(conversation.first_content)}}
                            </div>

                            <small class="time text-muted">{{unixToTimeAgo(conversation.last_conversation_time)}}</small>

							<!-- labels -->
							<small tooltip-placement="top-left" uib-tooltip="Có đơn hàng" tooltip-append-to-body="true"
									ng-if="conversation.has_order" class="chat-alert has-order label label-success">
								<i class="fa fa-shopping-cart"></i>
							</small>
                            <small tooltip-placement="top-left" uib-tooltip="Đã đọc" tooltip-append-to-body="true"
									ng-if="conversation.is_read" class="chat-alert text-muted"
								   style="font-size: 15px;
    								padding: 0;
    								top: 30px;">
								<i class="fa fa-check"></i>
							</small>
							<small tooltip-placement="top-left" uib-tooltip="Chưa đọc" tooltip-append-to-body="true"
								   ng-if="!conversation.is_read" class="chat-alert label label-danger">1</small>
							<small tooltip-placement="top-left" uib-tooltip="Inbox" tooltip-append-to-body="true"
								   ng-if="conversation.type==0" class="chat-alert label inbox"><i class="icon-envelope"></i></small>
							<small tooltip-placement="top-left" uib-tooltip="Comment" tooltip-append-to-body="true"
									ng-if="conversation.type==1" class="chat-alert label comment"><i class="fa fa-comments"></i></small>
                        </a>
                    </li>
                </ul>
            </div>

            <!--=========================================================-->
            <!-- selected chat -->
            <div class="col-md-8 bg-white" style="padding-right: 0;">
                <div class="chat-message">

					<div
							id="overlay-loading-refresh-messages"
							class="well well-lg bs-loading-container"
							style="
						position: absolute;
						width: 100%;
						height: 100%;
						z-index: 9999;
						top: 0;
						left: 0;
						opacity: .8;"
							bs-loading-overlay
							bs-loading-overlay-reference-id="refresh-messages-spinner"
							bs-loading-overlay-delay="1000">
					</div>

                    <ul class="chat" id="chat-history">
						<span ng-if="filterByCurrentPage(currentConversation)"
								ng-repeat="message in messages | orderBy:'user_created'" style="display: block">
							<!--Fb user message-->
							<li ng-if="currentConversation.page_id != message.fb_user_id"
								class="left clearfix">
								<span class="chat-img pull-left">
									<a target="_blank" ng-href="https://fb.com/{{message.fb_user_id}}"><img class="avatar"
											ng-src="https://graph.facebook.com/{{message.fb_user_id}}/picture?type=normal" alt="User Avatar"></a>
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="">{{currentConversation.fb_user_name}}</strong>
										<small class="pull-right text-muted "><i class="fa fa-clock-o"></i>
											{{dateStringToTimeAgo(message.created)}}
										</small>
									</div>
									<p ng-bind-html="trustHtml(filterMessage(message.content))"></p>
								</div>
							</li>

							<!--page message-->
							<li ng-if="currentConversation.page_id == message.fb_user_id"
								class="right clearfix">
								<span class="chat-img pull-right">
									<img class="avatar"
										 ng-src="{{getPageAvatar(activeConversationPage)}}" alt="User Avatar">
								</span>
								<div class="chat-body bg-blue-sharp font-white clearfix">
									<div class="header">
										<strong class="font-white">{{activeConversationPage.page_name}}</strong>

										<small class="pull-right font-white text-muted">
											<i class="fa fa-clock-o"></i>
											{{dateStringToTimeAgo(message.created)}}
										</small>

										<small class="pull-right text-muted" ng-if="message.is_sending==true">
											<span class="sending-msg"></span>
											<span class="font-blue">đang gửi...</span>
										</small>

										<small class="pull-right text-muted" ng-if="message.is_sending==2">
											<i class="fa fa-unlink font-red-mint"></i>
											<span class="font-red-sunglo">Lỗi ...(Hãy liên hệ vissale để được hỗ trợ)</span>
										</small>

									</div>
									<p ng-bind-html="trustHtml(filterMessage(message.content))"></p>
								</div>
							</li>
						</span>
                    </ul>

                </div>
                <div class="chat-box bg-white">
                    <div class="actions" style="margin-bottom: 5px;">
                        <a class="btn btn-circle btn-icon-only btn-default tooltips bg-blue" href="javascript:;"
                           data-container="body"
                           data-placement="bottom"
                           data-original-title="Gửi ảnh"
						   ngf-select="upload($file)"
						   ngf-pattern="'image/*'"
						   ngf-accept="'image/*'"
						>
                            <i class="icon-cloud-upload bg-font-blue"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-wrench"></i>
                        </a>
                        <a ng-show="currentConversation.post_id"
                           href="https://fb.com/{{currentConversation.post_id}}"
                           target="_blank"
                           class="btn btn-circle btn-icon-only btn-default tooltips bg-grey"
                           data-container="body" data-placement="bottom"
                           data-original-title="Xem link bài viết trên facebook">
                            <i class="fa fa-external-link bg-font-grey"></i>
                        </a>
                    </div>
                    <div class="input-group">
						<input ng-keypress="enterKeyToSendMessage($event)"
							   ng-model="messageContent"
							   class="form-control no-shadow no-rounded"
							   placeholder="Type your message here">
                        <span class="input-group-btn">
            			<button ng-click="sendMessage()"
								class="btn btn-success no-rounded" type="button"><i
                                class="fa fa-send"></i> Send <i ng-if="sendingMessage" class="fa fa-refresh fa-spin fa-1x fa-fw"></i></button>
            		</span>
                    </div><!-- /input-group -->
                </div>
            </div>
        </div>
    </div>
    <div id="chat-right"  class="chat-right portlet light bordered" style="visibility: hidden;">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="fullHeigh">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="fa fa-shopping-cart font-red"></i>
                            <span class="caption-subject font-red bold uppercase">Thao tác</span>
                        </div>
                        <ul class="nav nav-tabs" style="clear: both;">
							<li class="active">
								<a href="#portlet_comments_1" data-toggle="tab" aria-expanded="true">Thông tin</a>
							</li>
							<li class="">
                                <a href="#portlet_comments_2" data-toggle="tab" aria-expanded="false"> Lịch sử </a>
                            </li>
                            <li class="">
                                <a href="#portlet_comments_3" data-toggle="tab" aria-expanded="false"> Tạo mới </a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <?php echo $this->element('Chat/page_post'); ?>
                            <?php echo $this->element('Chat/customer_order'); ?>
                            <?php echo $this->element('Chat/create_order'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="/js/line-breaks-convert-br-new-v2.js"></script>

<script>


    $(document).ready(function () {

		//init scroll
		initFriendListScroll();

		initPagePostPanel();
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

    function scrollToPositionChatHistory(height) {
        console.log(height);
        var chat_height = $(window).height() - 110;
        $('#chat-history').slimScroll({
            height: chat_height - 130 + 'px',
            railVisible: true,
            alwaysVisible: false,
            allowPageScroll: true,
            start: "bottom",
            scrollTo: height + 'px'
        });
        return false;
    }

    function initPagePostPanel() {
		var chat_height = $(window).height() - 110;
		$('#page_post_information').slimScroll({
			height: chat_height - 60 + 'px',
			railVisible: true,
			alwaysVisible: false,
			allowPageScroll: true,
			start: "bottom"
			//scrollTo: chat_height - 130 + 'px'
		});
		return false;
	}

</script>
