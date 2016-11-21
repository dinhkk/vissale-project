/**
 * Created by dinhkk on 11/19/16.
 */
console.log("Chat App Started");

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
	        "chat_api": "http://vissale.dev:1337",
        })

        //define chat controller
	    .controller('ChatController', ChatController)

        //define service conversation
        .service('conversation', conversation)

        //define service message
        .service('message', message)

        //define service page
	    .service('page', page)

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
	conversation.$inject = ['config', '$http', '$q', '$rootScope'];
	function conversation(config, $http, $q, $rootScope) {
		console.log('conversation service started');
		
		this.getConversations = function () {
			var deferred = $q.defer();
			var url = '/conversation/getConversations?group_id=' + $rootScope.group_id;
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
	message.$inject = [];
	function message() {
		console.log('message service started');
	}
	
	//message page
	page.$inject = ['config', '$http', '$q', '$rootScope'];
	function page(config, $http, $q, $rootScope) {
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
	ChatController.$inject = ['$q', '$scope', '$http', '$sce', '$timeout', 'bsLoadingOverlayService', 'conversation', 'page'];
	function ChatController($q, $scope, $http, $sce, $timeout, bsLoadingOverlayService, conversation, page) {
		
		function getData() {
			console.log('ChatController.getData()');
			
			var promises = {
				pages: page.getPages(),
				conversations: conversation.getConversations()
			};
			
			return $q.all(promises).then(function (values) {
				return values;
			});
		}
		
		function init() {
			var data = getData();
			
			data.then(function (values) {
				console.log(values);
			})
		}
		
		init();
    }
	
	
})();
