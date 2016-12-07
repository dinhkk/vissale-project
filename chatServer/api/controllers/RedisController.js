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
  }
};

