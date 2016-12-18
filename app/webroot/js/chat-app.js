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

		//define chat controller
		.controller('ChatController', ChatController)

		//define service conversation
		.service('conversationService', conversationService)

		//define service message
		.service('messageService', messageService)

		//define service page
		.service('pageService', pageService)

		.factory('allHttpInterceptor', function (bsLoadingOverlayHttpInterceptorFactoryFactory) {
			return bsLoadingOverlayHttpInterceptorFactoryFactory({
				referenceId: 'first-conversations-spinner',
				requestsMatcher: function (requestConfig) {
					if (requestConfig.name != 'get_first_data') {
						return false;
					}
					return true;
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
			
			console.log(options);
			
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


	//Chat Controller
	ChatController.$inject = ['config',
		'$q', '$scope',
		'$http', '$sce',
		'$timeout', 'bsLoadingOverlayService',
		'conversationService',
		'pageService', 'messageService', 'Upload', '$rootScope', '$httpParamSerializer', 'toastr'];

	function ChatController(config, $q, $scope, $http, $sce, $timeout, bsLoadingOverlayService,
							conversationService, pageService, messageService, Upload, $rootScope, $httpParamSerializer, toastr) {
		moment.locale('vi');
		
		
		$scope.conversations = [];
		$scope.messages = [];
		$scope.pages = [];
		$scope.currentConversation = null;
		$scope.currentPageId = null;
		$scope.currentPage = null;
		$scope.sendingMessage = false;
		$scope.search = null;
		$rootScope.messageContentPrivate = null;
		
		var conversationOptions = {limit: 30, page: 1};
		var messageOptions = {};
		var timeOutScroll = null;
		var getConversationsTimeout = null;

		function setDefaultMessageOptions() {
			messageOptions = {limit: 25, page: 1, hasNext : true};
		}
		function setDefaultConversationOptions() {
			conversationOptions = {limit: 30, page: 1};
		}
		
		function getData() {
			console.log('ChatController.getData()');

			var promises = {
				pages: pageService.getPages(),
				conversations: conversationService.getConversations(conversationOptions, "get_first_data")
			};

			return $q.all(promises).then(function (values) {
				return values;
			});
		}

		function setData(values) {
			
			//console.log(values);
			
			$scope.conversations = values.conversations;
			$scope.pages = values.pages.data;

			console.log('setting data');
			
			$("#chat-left").css("visibility", "visible");
			$("#chat-right").css("visibility", "visible");
			//slimScrollDiv works only after data is ready
			handleScrollConversationList(getMoreConversations);
			handleScrollMessageList(getMoreMessages);

        }

		/*
		 * initial data for frontend
		 * */
		function init() {
			setDefaultMessageOptions();
			listenToFaye();

			var data = getData();
			data.then(function (values) {
				//console.log(values);

				setData(values);

			})
		}

		init();
		
		//get message for active conversation
		function getConversationMessages(currentConversation) {
			
			if (!messageOptions.hasNext) {
				return false;
			}
			
			var result = messageService.getConversationMessages(currentConversation, messageOptions);

			result.then(function (result) {
				//console.log(result);
				
				if (result.data.chat.length == 0 || result.data.chat.length < messageOptions.limit) {
					messageOptions.hasNext = false;
				}
				
				angular.forEach(result.data.chat, function (value, key) {
					$scope.messages.push(value);
				});
				
				//console.log($scope.messages);
				
				setIsReadConversation(currentConversation);

			});
		}

		//set current page
		function setCurrentPage() {
			$scope.currentConversation = null;
			$scope.messages = [];
			angular.forEach($scope.pages, function (value, key) {
                if ($scope.currentPageId == value.id) {
					$scope.currentPage = value.page_id;
	                $scope.activeConversationPage = value;
				}
			});
			
		}
		
		//set current page by conversation
		function setCurrentPageByConversation(conversation) {
			angular.forEach($scope.pages, function (value, key) {
				if (conversation.page_id == value.page_id ) {
					$scope.activeConversationPage = value;
				}
			});
			
		}

		//init faye listening
		function listenToFaye() {
			var client = new Faye.Client(config.push_server);
			var subscription = client.subscribe('/channel_group_' + window.group_id + '', function (message) {
				// handle message
				handleMessage(message);
			});
		}

		//handle socket message
		function handleMessage(message) {
			console.log(message);

			//not-existed in conversations array and message is parent conversation
			if ( !isExistedConversation(message) && message.is_parent == 1) {
				var conv = new ObjConversation(message);
				$scope.conversations.data.unshift(conv);

                $scope.$apply();
                return true;
			}
			
			//not existed in array and not parent conversations
			if (!isExistedConversation(message) && message.is_parent == 0) {
				refreshConversations();
			}

            //if existed conversation
            var isExisted = isExistedConversation(message);
            if (isExisted) {
                console.log("existed conversation, we will update its status");
                updateConversationStatus(message);
            }
			
            if (isExisted &&
                $scope.currentConversation &&
                message.is_parent == 0 &&
                parseInt(message.conversation_id) == $scope.currentConversation.id &&
		        !isExistedMessage(message)
            ) {

                console.log("we will update MESSAGES arrayList");
	            
	            message.created = unixToISOString(message.fb_unix_time);
	            var newMessage = new ObjectMessage(message);

                $scope.messages.push(newMessage);

                $scope.$apply();

                //scroll to BOTTOM
                scrollToPositionChatHistory(__calculateHeightScrollTo());
                return true;
			}

            //
		}

		//get more conversations
		function getMoreConversations(pos) {
			if (pos != 'bottom') {
				
				console.log('scrolling', '...');
				
				return false;
			}
			
			if (getConversationsTimeout == true) {
				return false;
			}
			
			getConversationsTimeout = true;
			conversationOptions.page += 1;
			var result = null;
			
			if ( isSearchStringValid($scope.search) ) {
				 result = conversationService.searchConversations(conversationOptions);
			}
			
			if ( !isSearchStringValid($scope.search) ) {
				result = conversationService.getConversations(conversationOptions, 'refresh_conversations');
			}
			
			console.log("getting more conversations");
			
			result
				.then(function (result) {
					var tmpConversations = result.data;
					//console.log(tmpConversations);
					angular.forEach(tmpConversations, function (value, key) {
						$scope.conversations.data.push(value);
					});
					
					return result;
				})
				.then(function (result) {
					initFriendListScroll();
					$timeout(function(){
						getConversationsTimeout = false;
					}, 1000);
				});
		}
		
		//refresh conversations
		function refreshConversations(){
			console.log('refresh conversations');
			setDefaultConversationOptions();
			$scope.search = null;
			
			var result = conversationService.getConversations(conversationOptions, 'refresh_conversations');
			
			result
				.then(function (result) {
					var tmpConversations = result.data;
					$scope.conversations.data = [];
					angular.forEach(tmpConversations, function (value, key) {
						$scope.conversations.data.push(value);
					});
					
					return result;
				})
				.then(function (result) {
					initFriendListScroll();
				});
		}
		
		//get more messages
		function getMoreMessages(pos) {
			if (pos != 'top') {
				
				console.log('scrolling chat', '...');
				
				return false;
			}
			
			messageOptions.page += 1;
			getConversationMessages($scope.currentConversation);
			
			if (timeOutScroll != null) {
				$timeout.cancel( timeOutScroll );
				timeOutScroll = null;
			}
			
			timeOutScroll = $timeout(function(){
				scrollToPositionChatHistory(__calculateHeightScrollTo());
			}, 200);
			
            //scroll to TOP

        }

		//this function will integrate with angularjs
		function handleScrollConversationList(callback) {
			$('#friend-list').slimScroll().bind('slimscroll', function (e, pos) {
				
				console.log("Reached " + pos);

				callback(pos);
			});
		}
		
		//this function will integrate with angularjs
		function handleScrollMessageList(callback) {
			$('#chat-history').slimScroll().bind('slimscroll', function (e, pos) {
				
				console.log("Reached " + pos);

				callback(pos);
			});
		}
		
		//check existed conversation in array
		function isExistedConversation(message) {
            var isExisted = false;

            angular.forEach($scope.conversations.data, function (value, key) {
                if (message.conversation_id == value.id || message.conversation_id == value.conversation_id) {
                    isExisted = true;
				}
			});

            return isExisted;
		}
		
		//check existed message in array
		function isExistedMessage(socketMessage) {
			var isExisted = false;
			
			angular.forEach($scope.messages, function (value, key) {
				
				if ($scope.currentConversation.type==0 && socketMessage.message_id === value.message_id) {
					isExisted = true;
				}
				
				if ($scope.currentConversation.type==1 && socketMessage.comment_id === value.comment_id) {
					isExisted = true;
				}
				
			});
			
			return isExisted;
		}
		
		function setIsReadConversation(currentConversation) {
			angular.forEach($scope.conversations.data, function (value, index) {
                if (currentConversation.id == value.id) {
					$scope.conversations.data[index].is_read = 1;
				}
			});
		}

        function updateConversationStatus(socketMessage) {
	        if (socketMessage.fb_page_id == socketMessage.fb_user_id || socketMessage.page_id == socketMessage.fb_user_id) {
		        return false;
	        }
	        console.log('updating existed conversation in arrayList', socketMessage.conversation_id);
	        
            angular.forEach($scope.conversations.data, function (value, index) {
	            
                if (socketMessage.conversation_id == value.id || socketMessage.conversation_id == value.conversation_id) {
	
	                $scope.conversations.data[index].last_conversation_time = socketMessage.fb_unix_time;
	                
                    //if has order, update status
                    if (socketMessage.has_order == 1) {
                        $scope.conversations.data[index].has_order = 1;
                    }
	                $scope.conversations.data[index].last_conversation_time = socketMessage.fb_unix_time;
                    $scope.conversations.data[index].is_read = socketMessage.is_read;
                    $scope.conversations.data[index].first_content = socketMessage.message;
                    $scope.$apply();
                }
            });
        }

        function __calculateHeightScrollTo() {
            return $scope.messages.length * (63 + 30);
	        /*var elements = $("#chat-history > span");
	        var height = 0;
	        angular.forEach(elements, function (value, index) {
	        	
		        height += jQuery(value).height() + 30;
	        });
	        
	        return height;*/
        }
        
        
        function beforeSendMessage() {
	        $scope.sendingMessage = true;
        }
        
        function afterSendMessage(response, messageId) {
	        console.log('do after sending message');
	        is_private = false;
	        
	        scrollToPositionChatHistory(__calculateHeightScrollTo());
	        changeMessageIsSendingStatus(response, messageId, response.success);
	        
	        console.log(response.message);
	        $scope.sendingMessage = false;
        }
        
        function changeMessageIsSendingStatus(response, messageId, status) {
        	console.log(messageId, $scope.messages);
	
	        if (! status) {
		        toastr.error(response.message, 'Error');
	        }
	        
	        
	        angular.forEach($scope.messages, function (value, index) {
		        if (value.id == messageId && status) {
			        $scope.messages[index].is_sending = false;
			        $scope.messages[index].id = response.data.id;
			        $scope.messages[index].message_id = response.data.message_id;
		        }
		        if (value.id == messageId && !status) {
			        $scope.messages[index].is_sending = 2;
		        }
	        });
        }
        
        function timeToISOString() {
			return moment().utc().toISOString();
        }
		
        function unixToISOString(unixTimestamp) {
	        var momentObj = moment(unixTimestamp * 1000);
	        return momentObj.utc().toISOString()
        }
		
		/*
		 * Handle events
		 * */
		
		//set active conversation
		$scope.setActiveConversation = function (conversation) {
			
			if ($scope.currentConversation && $scope.currentConversation.id == conversation.id) {
				return false;
			}
			$scope.currentConversation = null;
			$scope.postData = null;
			setCurrentPageByConversation(conversation);
			
			setDefaultMessageOptions();
			$scope.messages = [];
			$scope.currentConversation = conversation;
			getConversationMessages(conversation);
			
			//scroll to BOTTOM
			$timeout(function () {
				scrollToPositionChatHistory(__calculateHeightScrollTo());
			}, 1000);
			
			
			if (conversation.post_id) {
				var queryPostOptions = {
					post_id : conversation.post_id,
					page_id : conversation.page_id
				};
				var postData = pageService.postData(queryPostOptions);
				
				postData.then(function(data) {
					$scope.postData = data;
					return data;
				}).then(function(data) {
					initPagePostPanel();
				});
			}
		};
        
		$scope.changePage = function () {
			
			setCurrentPage();
		};

		//bool , if current page selected, filter by current page
		$scope.filterByCurrentPage = function(conversation) {
			if ($scope.currentPage == null) {
				return true;
			}
			
			return  $scope.currentPage && conversation.page_id == $scope.currentPage;
			
		};
		
        $scope.trustHtml = function (value) {
            return $sce.trustAsHtml(value);
        };

        $scope.replaceQuotes = function (html) {
            var str = String(html);
            return str.replace(/\\/g, "").replace(/\n/, "<br/>");
        };
		
		$scope.filterMessage = function (content) {
			var filePattern = /file\.php\?path=/gi;
			
			if (! String(content).match(filePattern) ) {
				return content;
			}
			
			var pattern = /https:(.*)\.(?:jpe?g|png|gif)/i;
			var str = String(content);
			var res = str.replace(filePattern, "files/");
			
			return res.replace(pattern, '<img width="200" src="'+res+'">');
		};
		
        $scope.sendMessage = function() {
	        if (!$scope.currentConversation) {
	            return false;
	        }
			console.log('sending message...');
	        beforeSendMessage();
	        
	        var params = {
	        	message : $scope.messageContent,
	        	//conversation_id : $scope.currentConversation.id,
	        	conversation_id : $scope.currentConversation.id,
		        group_id : window.group_id
	        };
	        var messageId = (new Date()).getTime();
	        var msgObject = {
			        message: $scope.messageContent,
			        fb_unix_time: null,
			        fb_conversation_id: $scope.currentConversation.id,
			        fb_customer_id: null,
			        fb_page_id: null,
			        fb_post_id: $scope.currentConversation.fb_post_id || 0,
			        fb_user_id: $scope.currentConversation.page_id,
			        group_id: $scope.currentConversation.group_id,
			        id: messageId,
			        modified: null,
			        page_id: $scope.currentConversation.page_id,
			        parent_comment_id: null,
			        post_id: $scope.currentConversation.post_id || 0,
			        reply_type: null,
			        created: timeToISOString(),
			        is_sending: true
	        };
	
	        if (! is_private) {
		        $scope.messages.push(new ObjectMessage(msgObject));
	        }
	
	        if (is_private) {
		        params.is_private = 1;
	        }
	        
	        var result = conversationService.replyConversation(params);
	        $scope.messageContent = null;
	        result
		        .then(function(result) {
			        
		        afterSendMessage(result, messageId);
	        })
		        .catch(function(err) {
			        console.log(result)
		        });
	        
        };
		
		$scope.enterKeyToSendMessage = function ($event) {
			if ($event.keyCode == 13) {
				$scope.sendMessage();
			}
		};
		
		// upload on file select or drop
		$scope.upload = function (file) {
			if (!$scope.currentConversation) {
				return false;
			}
			
			Upload.upload({
				url: '/Attachment/uploadFile',
				data: {file_message: file, conversation_id: $scope.currentConversation.id}
			}).then(function (response) {
				
				if (response.data.error == 0) {
					$scope.messageContent = response.data.data;
					
					$scope.sendMessage();
				}
				
			}, function (error) {
				console.log('Error status: ' + error.status);
			}, function (evt) {
				//var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
				//console.log('progress: ' + progressPercentage + '% ' + evt);
			});
		};
		
		//moment helper
		$scope.dateStringToTimeAgo = function(dateString) {
			//var time = "2016-11-27T23:48:49.000Z";
			var momentObj = moment(dateString, moment.ISO_8601);
			
			return momentObj.from( moment() );
		};
		
		//moment helper
		$scope.unixToTimeAgo = function(unixTimestamp) {
			
			var momentObj = moment(unixTimestamp * 1000);
			
			return momentObj.from( moment() );
		};
		
		//search conversation by search comments / messages, fb_user_name
		$scope.searchConversation = function() {
			
			if ($scope.search == null ||  String($scope.search).length < 3) {
				refreshConversations();
				return false;
			}
			setDefaultConversationOptions();
			conversationOptions.search = $scope.search;
			
			var searchConv = conversationService.searchConversations(conversationOptions);
			searchConv
				.then(function(data) {
					$scope.conversations.data = [];
					$scope.conversations.data = data.data;
				})
				.catch(function(error) {
					console.log(error);
				});
			console.log($scope.search);
			return;
		};
		
		$scope.enterSearchConversation = function ($event) {
			if ($event.keyCode == 13) {
				$scope.searchConversation();
			}
		};
		
		$scope.getPageAvatar = function(conversation){
			var params = [];
			params['group_id'] = $rootScope.group_id;
			params['page_id'] = conversation.page_id;
			
			var queryString = $httpParamSerializer(params);
			var url = '/page/getAvatar?' + queryString;
			return chat_api + url;
		};

		
		//send private message from comment
		var vm = this;
		vm.messageContentPrivate = null;
		var is_private = false;
		$scope.sendPrivateMessage = function ($event) {
			if ($event.keyCode == 13) {
				console.log(vm.messageContentPrivate);
				$scope.messageContent = angular.copy(vm.messageContentPrivate);
				
				vm.messageContentPrivate = null;
				is_private = true;
				
				$scope.sendMessage();
			}
		};
        //
	} // end chat controller


})(); // end scope
