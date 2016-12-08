/**
 * PostController
 *
 * @description :: Server-side logic for managing posts
 * @help        :: See http://sailsjs.org/#!/documentation/concepts/Controllers
 */

module.exports = {
  
	get : function(request, response) {
    console.time("get-post-data->");
    
    var content = {success: false, message: 'Failed', data: null};
    var group_id = request.param("group_id", null);
    var page_id = request.param("page_id", null);
    var post_id = request.param("post_id", null);
    
    if (!page_id || !group_id || !post_id) {
      return response.json(content);
    }
    var key = sails.md5(["post", group_id, page_id, post_id]);
    
    //get post data
    var postData = sails.async(function () {
      
      var post = sails.await(Redis.get(key));
      if (post) {
        return post;
      }
      
      var pageToken = sails.await( Page.getPageToken(request) );
      console.log(pageToken );
      
      var requestOption = {
        method: 'GET',
        url: 'https://graph.facebook.com/' + post_id + '?access_token=' + pageToken + '&fields=attachments,message,type',
        json: true
      };
      
      return sails.requestPromise(requestOption)
        .then(function (body) {
          "use strict";
          console.log("rq-promise", body);
          Redis.set(key, body);
          return body;
        })
        .catch(function (error) {
          "use strict";
          console.log("Error", error);
          return false;
        });
      
    });
    
    //return response after getting data
    return postData()
      .then(function (data) {
        "use strict";
        console.log("post-data", data);
  
        content.success = true;
        content.message = "GOT FB-POST";
        content.data = data;
        console.timeEnd("get-post-data->");
        return response.json(content);
      })
      .catch(function (error) {
        "use strict";
        console.log(error);
        return response.json(content);
      });
    
  }
  
};

