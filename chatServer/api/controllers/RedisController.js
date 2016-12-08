/**
 * RedisController
 *
 * @description :: Server-side logic for managing redis
 * @help        :: See http://sailsjs.org/#!/documentation/concepts/Controllers
 */

module.exports = {
	clear : function(request, response) {
    return sails.redisClient.flushdb( function (err, succeeded) {
      console.log(succeeded); // will be true if successfull
      return response.ok();
    });
  },
  
  delete : function(request, response) {
    var key = request.body.key;
    return sails.redisClient.del(key)
      .then(function (reply) {
        "use strict";
        sails.log.info(reply);
        return response.ok();
      })
      .catch(function (error) {
        "use strict";
        sails.log.error(error);
      })
  },
  
  test : function(request, response) {
    var stringValue = {"success":true,"message":"GOT POST DATA","data":{"attachments":{"data":[{"media":{"image":{"height":480,"src":"https://scontent.xx.fbcdn.net/v/t1.0-0/q84/p480x480/14705837_1205400416188164_1038210609696795474_n.jpg?oh=8514a24e7781c9ea54cdc818a45fdb25&oe=58AF9E92","width":720}},"target":{"id":"1205400416188164","url":"https://www.facebook.com/giaydepda.vn/photos/a.592919370769608.1073741828.590423717685840/1205400416188164/?type=3"},"title":"Timeline Photos","type":"photo","url":"https://www.facebook.com/giaydepda.vn/photos/a.592919370769608.1073741828.590423717685840/1205400416188164/?type=3"}]},"type":"photo","id":"590423717685840_1205400416188164"}};
    
    var conversation = Conversation.findOne({id : 577585})
      .then(function (data) {
        "use strict";
        //console.log(data);
        
        sails.redisClient.set("cache_conv", JSON.stringify(data));
      })
      .catch(function (error) {
        "use strict";
        console.log(error);
      });
    
    
    //console.log(stringValue.success, stringValue.message);
    //console.log( (typeof stringValue) );
    //console.log( stringValue.length );
    //console.log( (typeof ["a", "b"]) );
    //console.log( ["a", "b"].length );
    //console.log( (typeof "sssssss") );
    //console.log( (typeof null) );
    
    
    // console.log( Redis.isObject( ["a", "b"]) );
    // console.log( Redis.isObject(stringValue) );
    // console.log( Redis.isObject("sssssss") );
    // console.log( Redis.isObject(null) );
    // console.log( "\n" );
    
    //sails.redisClient.HMSET("hosts", JSON.stringify(stringValue));
    //sails.redisClient.set("array_aaa", JSON.stringify(["aaa", "bbb", "ccc"]) );
    
    sails.redisClient.set("array_aaa", "aaaaaaaaaaaa" );
    
    // return sails.redisClient.get("array_aaa", function (err, obj) {
    //   //console.dir(obj);
    //
    //   console.log( obj );
    //   console.log( Redis.isJsonString(obj) );
    //
    //
    //   return response.ok();
    // });
  
     Redis.get("cache_conv")
       .then(function (data) {
         "use strict";
         console.log(data);
       })
       .catch(function (error) {
         "use strict";
         console.log(error);
       });
    
    Redis.get("array_aaa")
      .then(function (data) {
        "use strict";
        console.log(data);
      })
      .catch(function (error) {
        "use strict";
        console.log(error);
      });
    
    return response.ok();
  }
};

