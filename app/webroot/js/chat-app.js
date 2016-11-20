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
        })

        //define chat controller
	    .controller('ChatController', ChatController)

        //define service conversation
        .service('conversation', conversation)

        //define service message
        .service('message', message)

        .factory('allHttpInterceptor', function (bsLoadingOverlayHttpInterceptorFactoryFactory) {
            return bsLoadingOverlayHttpInterceptorFactoryFactory();
        })

        .config(function ($httpProvider) {
            $httpProvider.interceptors.push('allHttpInterceptor');
        })

        .run(function (bsLoadingOverlayService) {
            bsLoadingOverlayService.setGlobalConfig({
                delay: 0,
                activeClass: 'active-overlay',
                templateOptions: undefined,
                templateUrl: 'bsLoadingOverlaySpinJs'
                //templateUrl: undefined
            });
        })
    ;//end
	
	
	//conversation service
	conversation.$inject = ['$q', '$http'];
	function conversation($q, $http) {
		console.log('conversation service started');
		
		this.getResources = function () {
			console.log('conversation.getResources()');
			
			var promises = {
				alpha: promiseAlpha(),
				beta: promiseBeta(),
				gamma: promiseGamma()
			};
			
			return $q.all(promises).then(function (values) {
				return values;
			});
		};
		
		function promiseAlpha() {
			var deferred = $q.defer();
			
			$http.get('http://hipsterjesus.com/api/')
				.success(function (response) {
					deferred.resolve(response);
				})
				.error(function (error) {
					deferred.reject(error);
				});
			return deferred.promise;
		}
		
		function promiseBeta() {
			var deferred = $q.defer();
			
			$http.get('http://hipsterjesus.com/api/')
				.success(function (response) {
					deferred.resolve(response);
				})
				.error(function (error) {
					deferred.reject(error);
				});
			return deferred.promise;
		}
		
		function promiseGamma() {
			var deferred = $q.defer();
			
			$http.get('http://hipsterjesus.com/api/')
				.success(function (response) {
					deferred.resolve(response);
				})
				.error(function (error) {
					deferred.reject(error);
				});
			return deferred.promise;
		}
	}
	
	
	//message service
	message.$inject = [];
	function message() {
		console.log('message service started');
	}

//Chat Controller
	ChatController.$inject = ['$scope', '$http', '$sce', '$timeout', 'bsLoadingOverlayService', 'conversation'];
	function ChatController($scope, $http, $sce, $timeout, bsLoadingOverlayService, conversation) {

            $scope.showOverlay = function () {
                console.log('call ChatController.showOverlay()');
                $('#overlay-loading').show();
                bsLoadingOverlayService.start();


                $timeout(function () {
                    $scope.hideOverlay();
                }, 1000);
            };

            $scope.hideOverlay = function () {
                $('#overlay-loading').hide();
                bsLoadingOverlayService.stop();

                console.log('call ChatController.hideOverlay()');
            };

            $http.get('http://hipsterjesus.com/api/')
                .success(function (data) {
                    $scope.result = $sce.trustAsHtml(data.text);
                })
                .error(function () {
                    $scope.result = $sce.trustAsHtml('Can not get the article');
                });
		
		var test = conversation.getResources();
		console.log(test);
    }
	
	
})();
