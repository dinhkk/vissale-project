/**
 * Created by dinhkk on 12/6/16.
 */
module.exports = {
  
  set : function(key, variable) {
    sails.redisClient.expire(key, 2592000); //expire in one month
    
    //if variable is an object
    if (this.isObject(variable)) {
      return sails.redisClient.set(key, JSON.stringify(variable));
    }
    
    //if not an object
    if (! this.isObject(variable) ) {
      return sails.redisClient.set(key, variable);
    }
  },
  
  get : function(key) {
    
    var _this = this;
    
    return sails.redisClient.getAsync(key).then(function(cacheResponse) {
      
      if ( _this.isJsonString(cacheResponse) ) {
        return JSON.parse(cacheResponse);
      }
      
      return cacheResponse;
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
  },
  
  isJsonString : function(string) {
    try {
      JSON.parse(string);
    } catch (e) {
      return false;
    }
    return true;
  },
  
  isObject : function(variable) {
    return (variable instanceof Object) || (variable instanceof Array);
  }
  
};
