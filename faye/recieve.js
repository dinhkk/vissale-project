/**
 * Created by dinhkk on 11/16/16.
 */
var faye = require('faye');
var client = new faye.Client('http://localhost:8000/faye');
var subscription = client.subscribe('/foo', function (message) {
    // handle message
    console.log(message);
});