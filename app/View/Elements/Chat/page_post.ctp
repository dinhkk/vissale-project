<div class="tab-pane active" id="portlet_comments_1">
	<!-- BEGIN: Comments -->
	<div class="mt-comments" ng-if="activeConversationPage">
		<div class="mt-comment" style="margin-bottom: 0;" ng-if="currentConversation">

			<div class="mt-comment-img">
				<a target="_blank" ng-href="https://fb.com/{{currentConversation.fb_user_id}}">
					<img ng-src="https://graph.facebook.com/{{currentConversation.fb_user_id}}/picture?type=normal"
						 class="avatar"
						 alt="User Avatar" style="cursor: pointer">
				</a>
			</div>
			<div class="mt-comment-body" style="padding-left: 5px;">
				<div class="mt-comment-info">
					<span class="mt-comment-date" style="float: left;">Khách: </span>
					<span class="mt-comment-author" style="margin-left: 5px; margin-bottom: 2px">
						<a target="_blank" ng-href="https://fb.com/{{currentConversation.fb_user_id}}">{{currentConversation.fb_user_name}}</a>
					</span>
					<span class="mt-comment-date" style="float: left; clear: both">SDT: </span>
					<span class="mt-comment-author" style="margin-left: 5px; margin-bottom: 2px">0923 323 332</span>
				</div>
			</div>
		</div>

		<div class="mt-comment">

			<div class="mt-comment-img">
				<img ng-src="https://graph.facebook.com/{{activeConversationPage.page_id}}/picture?type=normal">
			</div>
			<div class="mt-comment-body" style="padding-left: 5px;">
				<div class="mt-comment-info">
					<span class="mt-comment-date" style="float: left;">Trang: </span>
					<span class="mt-comment-author" style="margin-left: 5px;">{{activeConversationPage.page_name}}</span>
				</div>
			</div>
		</div>

	</div>
	<!-- END: Comments -->
	<div id="fb_post_content" ng-bind-html="trustHtml(filterMessage(postData))">

	</div>
</div>
