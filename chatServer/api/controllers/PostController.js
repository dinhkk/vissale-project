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
    
    var pageToken = Page.getPageToken(request);
    
    return pageToken
      .then(function (token) {
        sails.log.info("page-token=>", token);
        
        var requestOption = {
          method: 'GET',
          url : 'https://graph.facebook.com/'+post_id+'?access_token='+token+'&fields=attachments,message,type',
          json : true
        };
        return sails.request(requestOption, function (error, result, body) {
          if (!error && result.statusCode == 200) {
            //sails.log.info("response body =>>>", body); // Show the HTML for the Google homepage.
            content.success = true;
            content.message = "GOT POST DATA";
            content.data = body;
          }
  
          console.timeEnd("get-post-data->");
          return response.json(content);
        });
        
      })
      .catch(function (error) {
        
        sails.log.error(error);
        return response.json(content);
      });
  }
  
};

