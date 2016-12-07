/**
 * Created by dinhkk on 12/6/16.
 */
module.exports = {
  
  set : function(key, stringValue) {
    sails.redisClient.set(key, stringValue);
    sails.redisClient.expire(key, 2592000); //expire in one month
    return true;
  },
  
  get : function(key) {
    return sails.redisClient.getAsync(key).then(function(response) {
      return response;
    });
  },
  
  delete : function(key) {
    sails.redisClient.del(key)
      .then(function (reply) {
        "use strict";
        sails.log.info(reply);
      })
      .catch(function (error) {
        "use strict";
        sails.log.error(error);
      })
  },
  
  clear : function() {
    return sails.redisClient.flushdb( function (err, succeeded) {
      console.log(succeeded); // will be true if successfull
    });
  }
};
