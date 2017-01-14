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
<script src="/js/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
<link href="/css/featherlight.min.css" type="text/css" rel="stylesheet" />
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
    bs-loading-overlay-delay="2000">
</div>

<section class="content chat-section" ng-controller="ChatController as chat" style="padding: 0;display:block; margin: 0 auto;">

    <div id="chat-left" class="chat-left portlet light bordered" style="visibility: hidden;">
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
                        ng-show="filterByCurrentPage(conversation) && filterConversation(conversation)"
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
									<a target="_blank" ng-href="https://fb.com/{{message.fb_user_id}}">
										<img class="avatar"
                                             ng-src="https://graph.facebook.com/{{message.fb_user_id}}/picture?type=normal"
                                             alt="User Avatar"></a>
								</span>
								<div class="chat-body clearfix">
									<div class="header">
										<strong class="">{{currentConversation.fb_user_name}}</strong>
										<small class="pull-right text-muted "><i class="fa fa-clock-o"></i>
											{{dateStringToTimeAgo(message.created)}}
										</small>
									</div>
									<p ng-bind-html="trustHtml(filterMessage(message.content))"></p>
									<span ng-if="message.attachments"
                                          class="message-history-images"
                                          ng-bind-html="filterAttachments(message.attachments)"></span>
									<span ng-if="message.attachment"
                                          class="message-history-images"
                                          ng-bind-html="filterAttachments(message.attachment)"></span>
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
									<span ng-if="message.attachments"
                                          class="message-history-images"
                                          ng-bind-html="filterAttachments(message.attachments)"></span>
									<span ng-if="message.attachment"
                                          class="message-history-images"
                                          ng-bind-html="filterAttachments(message.attachment)"></span>
								</div>
							</li>
						</span>
                    </ul>

                    <!--popover image-->

                </div>

                <div class="chat-box bg-white">
                    <div class="actions" style="margin-bottom: 5px;">
                        <a class="btn btn-circle btn-icon-only btn-default tooltips bg-blue" href="javascript:;"
                           data-container="body"
                           data-placement="bottom"
                           data-original-title="Gửi ảnh"
                           ngf-select="upload($file)"
                           ngf-max-size="5MB"
                           ngf-pattern="'image/*'"
                           ngf-accept="'image/*'"
                        >
                            <i class="icon-cloud-upload bg-font-blue"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-wrench"></i>
                        </a>
                        <a ng-show="currentConversation.post_id"
                           href="https://www.facebook.com/{{currentConversation.post_id}}"
                           target="_blank"
                           class="btn btn-circle btn-icon-only btn-default tooltips bg-grey"
                           data-container="body" data-placement="bottom"
                           data-original-title="Xem link bài viết trên facebook">
                            <i class="fa fa-external-link bg-font-grey"></i>
                        </a>

                        <!--private message-->
                        <a uib-popover-template="'sendPrivateMessage.html'"
                           popover-title="Sending private message"
                           popover-append-to-body="true"
                           popover-placement="top"
                           popover-trigger = "'click : outsideClick'"
                           ng-show="currentConversation.post_id && !currentConversation.private_reply"
                           href="#_blank"
                           class="btn btn-circle btn-icon-only btn-default tooltips bg-grey"
                           data-container="body" data-placement="bottom"
                           data-original-title="Private Message">
                            <i class="fa fa-comments-o"></i>
                        </a>

                        <a style="height: 32px; width: 32px; display: inline;"
                           href="javascript:;"
                           ng-if="stateFileUploading"
                           class="btn btn-circle btn-icon-only btn-default tooltips bg-grey"
                           data-container="body" data-placement="bottom"
                           data-original-title="Uploading">
                            <img style="height: 35px; width: 35px; border-radius: 50% 50%;vertical-align: middle"
                                 src="/img/Preloader_10.gif">
                        </a>

                        <script ng-if="currentConversation.post_id && !currentConversation.private_reply"
                                type="text/ng-template" id="sendPrivateMessage.html">
                            <div class="form-group">
                                <label>@{{currentConversation.fb_user_name}}:</label>
                                <input style="width: 250px;" type="text"
                                       ng-model="chat.messageContentPrivate"
                                       ng-keypress="sendPrivateMessage($event)" class="form-control">
                            </div>
                        </script>
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
