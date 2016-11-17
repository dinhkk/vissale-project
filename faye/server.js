/**
 * Created by dinhkk on 11/16/16.
 */

var faye = require('faye'),
    redis = require('faye-redis'),
    http = require('http');

var server = http.createServer();

var bayeux = new faye.NodeAdapter({
    mount: '/faye',
    timeout: 25,
    engine: {
        type: redis,
        host: 'localhost'
        // more options
    }
});

bayeux.attach(server);
server.listen(8000);