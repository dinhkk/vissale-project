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
		type: data.type
	}
}

function ObjectMessage(data) {
    return {
        comment_id: null,
        content: data.message,
        fb_unix_time: data.fb_unix_time,
        fb_conversation_id: data.conversation_id,
        fb_customer_id: null,
        fb_page_id: null,
        fb_post_id: data.post_id || 0,
        fb_user_id: data.fb_user_id,
        group_id: data.group_id,
        id: null,
        modified: null,
        page_id: data.fb_page_id,
        parent_comment_id: null,
        post_id: data.post_id || 0,
        reply_type: null,
        status: null,
        user_created: null
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
			'ui.bootstrap']
		)

		//define constant
		.constant("config", {
			"push_server": "https://vissale.com:8001/faye",
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
			return bsLoadingOverlayHttpInterceptorFactoryFactory();
		})

		.config(function ($httpProvider) {
			$httpProvider.interceptors.push('allHttpInterceptor');

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
	conversationService.$inject = ['config', '$http', '$q', '$rootScope', '$httpParamSerializer'];
	function conversationService(config, $http, $q, $rootScope, $httpParamSerializer) {
		console.log('conversation service started');

		this.getConversations = function (options) {
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
			$http.get(config.chat_api + url)
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
			$http.get(config.chat_api + url)
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
	pageService.$inject = ['config', '$http', '$q', '$rootScope'];
	function pageService(config, $http, $q, $rootScope) {
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
	}


	//Chat Controller
	ChatController.$inject = [
		'$q', '$scope',
		'$http', '$sce',
		'$timeout', 'bsLoadingOverlayService',
		'conversationService',
		'pageService', 'messageService'];

	function ChatController($q, $scope, $http, $sce, $timeout, bsLoadingOverlayService,
							conversationService, pageService, messageService) {

		$scope.conversations = [];
		$scope.messages = [];
		$scope.pages = [];
		$scope.currentConversation = null;
		$scope.currentPage = null;
		
		var conversationOptions = {limit: 20, page: 1};
		var messageOptions = {};

		function setDefaultMessageOptions() {
			messageOptions = {limit: 25, page: 1, hasNext : true};
		}
		
		function getData() {
			console.log('ChatController.getData()');

			var promises = {
				pages: pageService.getPages(),
				conversations: conversationService.getConversations(conversationOptions)
			};

			return $q.all(promises).then(function (values) {
				return values;
			});
		}

		function setData(values) {
			$scope.conversations = values.conversations;
			$scope.pages = values.pages.data;

			console.log('setting data');

			//slimScrollDiv works only after data is ready
			handleScrollConversationList(getMoreConversation);
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
				console.log(values);

				setData(values);

			})
		}

		init();


		/*
		 * Handle events
		 * */

		//set active conversation
		$scope.setActiveConversation = function (conversation) {
			if ($scope.currentConversation && $scope.currentConversation.id == conversation.id) {
				return false;
			}
			setDefaultMessageOptions();
			$scope.messages = [];
			$scope.currentConversation = conversation;
			getConversationMessages(conversation);
			setCurrentPage(conversation);

            //scroll to BOTTOM
            $timeout(function () {
                scrollToPositionChatHistory(__calculateHeightScrollTo());
            }, 1000);
		};

		$scope.changePage = function () {
			console.log($scope.currentPage);
		};

		//get message for active conversation
		function getConversationMessages(currentConversation) {
			
			if (!messageOptions.hasNext) {
				return false;
			}
			
			var result = messageService.getConversationMessages(currentConversation, messageOptions);

			result.then(function (result) {
				console.info(result);
				//$scope.messages = result.data;
				if (result.data.chat.length == 0 || result.data.chat.length < messageOptions.limit) {
					messageOptions.hasNext = false;
				}
				
				angular.forEach(result.data.chat, function (value, key) {
					$scope.messages.push(value);
				});
				
				console.info($scope.messages);
				
				setIsReadConversation(currentConversation);

			});
		}

		//set current page
		function setCurrentPage(conversation) {
			angular.forEach($scope.pages, function (value, key) {
                if (conversation.page_id == value.page_id) {
					$scope.currentPage = value;
                    return value;
				}
			});
		}

		//init faye listening
		function listenToFaye() {
			var client = new Faye.Client('https://vissale.com:8001/faye');
			var subscription = client.subscribe('/channel_group_' + window.group_id + '', function (message) {
				// handle message
				handleMessage(message);
			});
		}

		//handle socket message
		function handleMessage(message) {
			console.log('angularjs', message);

			//not-existed in conversations array
			if ( !isExistedConversation(message) && message.is_parent == 1) {
                var conv = new ObjConversation(message);
				$scope.conversations.data.unshift(conv);

                $scope.$apply();
                return true;
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
                message.conversation_id == $scope.currentConversation.id) {

                console.log("we will update MESSAGES arrayList");
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
		function getMoreConversation(pos) {
			if (pos != 'bottom') {
				console.info('scrolling', '...');
				return false;
			}

			conversationOptions.page += 1;
			var result = conversationService.getConversations(conversationOptions);

			result
				.then(function (result) {
					var tmpConversations = result.data;
					//console.log(tmpConversations);
					angular.forEach(tmpConversations, function (value, key) {
						$scope.conversations.data.push(value);
					});

					return result;
			})
				.then(function () {
					initFriendListScroll();
					activePopover();
			});

		}
		
		//get more messages
		function getMoreMessages(pos) {
			if (pos != 'top') {
				console.info('scrolling chat', '...');
				return false;
			}

			messageOptions.page += 1;
			getConversationMessages($scope.currentConversation);

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

		function isExistedConversation(message) {
            var isExisted = false;

            angular.forEach($scope.conversations.data, function (value, key) {
                if (message.conversation_id == value.id || message.conversation_id == value.conversation_id) {
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

            angular.forEach($scope.conversations.data, function (value, index) {
                if (socketMessage.conversation_id == value.id || socketMessage.conversation_id == value.conversation_id) {

                    console.info('updating existed conversation in arrayList', socketMessage.conversation_id);

                    //if has order, update status
                    if (socketMessage.has_order == 1) {
                        $scope.conversations.data[index].has_order = 1;
                    }
                    $scope.conversations.data[index].is_read = socketMessage.is_read;
                    $scope.conversations.data[index].first_content = socketMessage.message;
                    $scope.$apply();
                }
            });
        }

        function __calculateHeightScrollTo() {
            return $scope.messages.length * 60;
        }

        $scope.trustHtml = function (value) {
            return $sce.trustAsHtml(value);
        };

        $scope.replaceQuotes = function (html) {
            var str = String(html);
            return str.replace(/\\/g, "");
        };

	} // end chat controller


})(); // end scope
