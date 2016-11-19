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
        //.controller('ChatController', ChatController)

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


//Chat Controller
    angular
        .module('vissale')
        .controller('ChatController', function ($scope, $http, $sce, $timeout, bsLoadingOverlayService) {

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


            $timeout(function () {
                $http.get('http://hipsterjesus.com/api/')
                    .success(function (data) {
                        $scope.result = $sce.trustAsHtml(data.text);
                    })
                    .error(function () {
                        $scope.result = $sce.trustAsHtml('Can not get the article');
                    });
            }, 1000);

            $http.get('http://hipsterjesus.com/api/')
                .success(function (data) {
                    $scope.result = $sce.trustAsHtml(data.text);
                })
                .error(function () {
                    $scope.result = $sce.trustAsHtml('Can not get the article');
                });
        });

    //conversation service
    function conversation() {
        console.log('conversation service started');
    }

    //message service
    function message() {
        console.log('message service started');
    }
})();