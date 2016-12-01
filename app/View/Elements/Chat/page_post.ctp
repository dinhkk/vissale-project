<div class="tab-pane active" id="portlet_comments_1">

	<div style="width: 100%;height: 100%;" id="page_post_information">
		<div
				id="overlay-loading-fbpost"
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
				bs-loading-overlay-reference-id="refresh-fbpost-spinner"
				bs-loading-overlay-delay="1000">
		</div>

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
						<span class="mt-comment-author" style="margin-left: 5px; margin-bottom: 2px">...</span>
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
		<div ng-if="postData" id="fb_post_content" ng-bind-html="trustHtml(filterMessage(postData))">

		</div>
	</div>
</div>
