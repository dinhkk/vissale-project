/**
 * Created by dinhkk on 11/19/16.
 */
console.log("Chat App Started");

// chat-app.js
(function () {
    'use strict';

    angular
        .module('vissale', [])


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

    ;//end


    //Chat Controller
    function ChatController() {
        console.log('ChatController started');
    }

    //conversation service
    function conversation() {
        console.log('conversation service started');
    }

    //message service
    function message() {
        console.log('message service started');
    }
})();