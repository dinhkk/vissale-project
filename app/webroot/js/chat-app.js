/**
 * Created by dinhkk on 11/19/16.
 */
console.log("Chat App Started");

function ObjConversation(data) {
	"use strict";
	return {
		id: data.conversation_id,
		conversation_id: data.conversation_id,
		fb_page_id: data.fb_page_id,
		page_id: data.fb_page_id,
		post_id: data.post_id || 0,
		fb_unix_time: data.fb_unix_time,
		fb_user_id: data.fb_user_id,
		fb_user_name: data.fb_user_name,
		group_id: data.group_id,
		first_content: data.message,
		content: data.message,
		is_read: 0,
        has_order: data.has_order,
		type: data.type,
		last_conversation_time : data.fb_unix_time
	}
}

function ObjectMessage(data) {
    return {
        comment_id: data.comment_id || (new Date).getTime(),
        message_id: data.message_id || (new Date).getTime(),
        content: data.message,
        attachments: data.attachments ? data.attachments : null,
        attachment: data.attachment ? data.attachment : null,
        fb_unix_time: data.fb_unix_time || null,
        fb_conversation_id: data.conversation_id,
        fb_customer_id: null,
        fb_page_id: null,
        fb_post_id: data.post_id || 0,
        fb_user_id: data.fb_user_id,
        group_id: data.group_id,
        id: data.id || null,
        modified: null,
        page_id: data.fb_page_id,
        parent_comment_id: null,
        post_id: data.post_id || 0,
        reply_type: null,
        status: null,
        created: data.created || 0,
	    is_sending: data.is_sending || false
    }
}
// chat-app.js
(function () {
	'use strict';

	angular
		.module('vissale', [
			'bsLoadingOverlay',
			'bsLoadingOverlaySpinJs',
			'bsLoadingOverlayHttpInterceptor',
			'ui.bootstrap', 'ngFileUpload',
			'ngAnimate', 'toastr'
			]
		)

		//define constant
		.constant("config", {
			"push_server": "https://vissale.com:8001",
			"chat_api": chat_api
		})
			
		//define service conversation
		.service('conversationService', conversationService)

		//define service message
		.service('messageService', messageService)

		//define service page
		.service('pageService', pageService)

		.factory('allHttpInterceptor', function (bsLoadingOverlayHttpInterceptorFactoryFactory) {
			return bsLoadingOverlayHttpInterceptorFactoryFactory({
				/*referenceId: 'first-conversations-spinner',
				requestsMatcher: function (requestConfig) {
					if (requestConfig.name != 'get_first_data') {
						return false;
					}
					return true;
				}*/
				requestsMatcher: function (requestConfig) {
					if ( ['refresh_conversations', 'refresh_messages', 'get_fb_post', 'get_page_avatar']
							.indexOf(requestConfig.name) >=0 ) {
						return false;
					}
					
					return requestConfig.url.indexOf('/conversation/sendMessage?') === -1;
				}
			});
		})
		
		.factory('refreshConversationsHttpInterceptor', function (bsLoadingOverlayHttpInterceptorFactoryFactory) {
			return bsLoadingOverlayHttpInterceptorFactoryFactory({
				referenceId: 'refresh-conversations-spinner',
				requestsMatcher: function (requestConfig) {
					return requestConfig.name == "refresh_conversations";
				}
			});
		})
		
		.factory('refreshMessagesHttpInterceptor', function (bsLoadingOverlayHttpInterceptorFactoryFactory) {
			return bsLoadingOverlayHttpInterceptorFactoryFactory({
				referenceId: 'refresh-messages-spinner',
				requestsMatcher: function (requestConfig) {
					return requestConfig.name == "refresh_messages";
				}
			});
		})
		
		.factory('getPostHttpInterceptor', function (bsLoadingOverlayHttpInterceptorFactoryFactory) {
			return bsLoadingOverlayHttpInterceptorFactoryFactory({
				referenceId: 'refresh-fbpost-spinner',
				requestsMatcher: function (requestConfig) {
					return requestConfig.name == "get_fb_post";
				}
			});
		})

		.config(function ($httpProvider, toastrConfig) {
			$httpProvider.interceptors.push('allHttpInterceptor');
			$httpProvider.interceptors.push('refreshConversationsHttpInterceptor');
			$httpProvider.interceptors.push('refreshMessagesHttpInterceptor');
			$httpProvider.interceptors.push('getPostHttpInterceptor');
			
			angular.extend(toastrConfig, {
				autoDismiss: true,
				target: 'body',
				closeButton: true,
				timeOut: 5000
			});
		})

		.run(function ($http, bsLoadingOverlayService, $rootScope) {
			bsLoadingOverlayService.setGlobalConfig({
				delay: 0,
				activeClass: 'active-overlay',
				templateOptions: undefined,
				templateUrl: 'bsLoadingOverlaySpinJs'
				//templateUrl: undefined
			});

			$rootScope.group_id = window.group_id;
		})
	;//end
	

	//conversation service
	conversationService.$inject = ['config', '$http', '$q', '$rootScope', '$httpParamSerializer', 'bsLoadingOverlayService'];
	function conversationService(config, $http, $q, $rootScope, $httpParamSerializer, bsLoadingOverlayService) {
		console.log('conversation service started');

		this.getConversations = function (options, requestName) {
			var deferred = $q.defer();
			var params = [];
			params['group_id'] = $rootScope.group_id;

			if (angular.isNumber(options.limit)) {
				params['limit'] = options.limit;
			}
			if (angular.isNumber(options.page)) {
				params['page'] = options.page;
			}

			var queryString = $httpParamSerializer(params);

			var url = '/conversation/getConversations?' + queryString;
			
			var requestConfig = {name : 'get_first_data'};
			
			if (requestName) {
				requestConfig.name = requestName;
			}
			
			$http.get(config.chat_api + url, requestConfig)
				.success(function (response) {
					deferred.resolve(response);
				})
				.error(function (error) {
					deferred.reject(error);
				});
			return deferred.promise;
		};
		
		this.replyConversation = function(params) {
			var deferred = $q.defer();
			
			var queryString = $httpParamSerializer(params);
			var chat_url = 	'/conversation/sendMessage?' + queryString;
			
			$http.get(config.chat_api + chat_url)
				.success(function (response) {
					deferred.resolve(response);
				})
				.error(function (error) {
					deferred.reject(error);
				});
			return deferred.promise;
		};
		
		this.searchConversations = function(options) {
			var deferred = $q.defer();
			var params = [];
			params['group_id'] = $rootScope.group_id;
			params['search'] = options.search;
			if (angular.isNumber(options.limit)) {
				params['limit'] = options.limit;
			}
			if (angular.isNumber(options.page)) {
				params['page'] = options.page;
			}
			
			var queryString = $httpParamSerializer(params);
			
			var url = '/conversation/searchConversations?' + queryString;
			
			var requestConfig = {name : 'refresh_conversations'};
			
			$http.get(config.chat_api + url, requestConfig)
				.success(function (response) {
					deferred.resolve(response);
				})
				.error(function (error) {
					deferred.reject(error);
				});
			return deferred.promise;
		};
	}


	//message service
	messageService.$inject = ['config', '$q', '$rootScope', '$http', '$httpParamSerializer'];
	function messageService(config, $q, $rootScope, $http, $httpParamSerializer) {
		console.log('message service started');

		this.getConversationMessages = function (conversation, options) {
			var deferred = $q.defer();
			var params = [];
			params['group_id'] = $rootScope.group_id;
			params['conversation_id'] = conversation.id;

			if (angular.isNumber(options.limit)) {
				params['limit'] = options.limit;
			}
			if (angular.isNumber(options.page)) {
				params['page'] = options.page;
			}

			var queryString = $httpParamSerializer(params);

			var url = '/conversation/getConversation?' + queryString;
			
			var requestConfig = {name : "refresh_messages"};
			
			$http.get(config.chat_api + url, requestConfig)
				.success(function (response) {
					deferred.resolve(response);
				})
				.error(function (error) {
					deferred.reject(error);
				});

			return deferred.promise;
		};
	}

	//page service
	pageService.$inject = ['config', '$http', '$q', '$rootScope', '$httpParamSerializer'];
	function pageService(config, $http, $q, $rootScope, $httpParamSerializer) {
		console.log('page service started');

		this.getPages = function () {
			var deferred = $q.defer();
			var url = '/page/getPages?group_id=' + $rootScope.group_id;
			$http.get(config.chat_api + url)
				.success(function (response) {
					deferred.resolve(response);
				})
				.error(function (error) {
					deferred.reject(error);
				});
			return deferred.promise;
		};
		
		//get fb - post data
		this.getPost = function (options){
			var _that = this;
			var deferred = $q.defer();
			var url = "https://graph.facebook.com/" + options.post_id + "?fields=attachments,message,type";
			var requestConfig = {name : "get_fb_post"};
			
			return $http.get(url, requestConfig)
				.then(function (response) {
					
					if (response.status == 400) {
						console.log("continue getting post via api");
						return _that.getPostViaApi(options);
					}
					
					deferred.resolve(response.data);
					return deferred.promise;
				})
				.catch(function (error) {
					
					console.log("error", error);
					
					deferred.reject(error);
					return deferred.promise;
				});
			
		};
		
		this.getPostViaApi = function(options) {
			var deferred = $q.defer();
			var params = [];
			params['group_id'] = $rootScope.group_id;
			params['post_id'] = options.post_id;
			params['page_id'] = options.page_id;
			
			var queryString = $httpParamSerializer(params);
			var url = '/post/get?' + queryString;
			var requestConfig = {name : "get_fb_post"};
			
			$http.get(config.chat_api + url, requestConfig)
				.success(function (response) {
					deferred.resolve(response.data);
				})
				.error(function (error) {
					deferred.reject(error);
				});
			
			return deferred.promise;
		};
		
		this.postData = function(options) {
			
			//console.log(options);
			
			var data = this.getPost(options);
			
			return data
				.then(function(data) {
					
					console.log("Post Data", data);
					
					return modifyPostContent(data);
				})
				.catch(function(error) {
					console.error(error);
				})
		};
		
		function modifyPostContent(data) {
			var html = $("<div id='post-message'></div>");
			console.log(data);
			if ( typeof data.attachments.data != 'undefined' &&
				typeof data.attachments.data[0].subattachments != 'undefined') {
				console.log("getting subattachments");
				
				var imageData = data.attachments.data[0].subattachments.data;
				getPhotos(imageData);
			}
			
			if (data.type == "link") {
				var media = data.attachments.data[0].media;
				getSinglePhoto(media);
			}
			
			if (data.type == "photo" && typeof data.attachments.data[0].media != 'undefined') {
				var photo = data.attachments.data[0].media;
				getSinglePhoto(photo);
			}
			
			if (data.type == "video" && typeof data.attachments.data[0].media != 'undefined') {
				var video = data.attachments.data[0].media;
				getSinglePhoto(video);
			}
			
			function getPhotos(imageData) {
				var imageContainer = $("<div id='img-container'></div>");
				
				$.each(imageData, function (index, value) {
					
					var img = "<a target='_blank' href='" + value.media.image.src + "'><img src ='" + value.media.image.src + "'></a>";
					imageContainer.append(img);
				});
				html.append(imageContainer);
			}
			
			function getSinglePhoto(media) {
				var imageContainer = $("<div id='img-container'></div>");
				var img = "<a target='_blank' href='" + media.image.src + "'><img src ='" + media.image.src + "'></a>";
				imageContainer.append(img);
				html.append(imageContainer);
			}
			
			//var link = "<div id='link-container'><a target='_blank' href='https://fb.com/" + data.id + "'>Facebook Post</a></div>";
			//html.append(link);
			if (typeof data.message != 'undefined') {
				html.append( convertText(data.message) );
				/*getPhotos(data);*/
			}
			
			return html.html();
			
		};
		
	}
	

})(); // end scope
