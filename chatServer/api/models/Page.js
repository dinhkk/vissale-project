/**
 * Page.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
  
  //connection: 'someMysqlServer',
  tableName: 'fb_pages',
  
  attributes: {
    
    id: {
      type: 'integer',
      primaryKey: true,
      unique: true
    },
    
    group_id: {
      type: 'integer'
    },
    
    page_id: {
      type: 'string'
    },
  
    token: {
      type: 'string'
    },
    
    page_name: {
      type: 'string'
    },
    
    last_conversation_time: {
      type: 'integer'
    },
    
    status: {
      type: 'integer'
    }
    
  },
  
  getPageByPageId : function(request) {
    var group_id = request.param("group_id", null);
    var page_id = request.param("page_id", null);
    return this.findOne({page_id : page_id, group_id : group_id})
      
      .then(function (pageData) {
        return pageData;
      })
      .catch(function(error) {
        sails.log.error(error);
        return false;
      })
  },
  
  getPageToken : function(request) {
    var _that = this;
    var group_id = request.param("group_id", null);
    var page_id = request.param("page_id", null);
    var key = sails.md5("token", page_id, group_id); //key string
    var getPageToken = sails.async(function() {
      var pageToken = sails.await( Redis.get(key) );
      if (pageToken) {
        return pageToken;
      }
      
      page = sails.await( _that.getPageByPageId(request) );
      Redis.set(key, page.token);
      return page.token;
    });
  
    return getPageToken()
      .then(function (data) {
        "use strict";
        console.log("getPageToken", data);
        return data;
      })
      .catch(function (error) {
        "use strict";
        sails.log.error(error);
        return false;
      })
  },
  
  getPicture : function(request) {
    var _that = this;
    var group_id = request.param("group_id", null);
    var page_id = request.param("page_id", null);
    var key = sails.md5(["avatar",page_id]);
  
    var pageAvatar = sails.async(function() {
      var avatarUrl = sails.await( Redis.get(key) );
      if (avatarUrl) {
        return avatarUrl;
      }
      
      pageToken = sails.await( _that.getPageToken(request) );
      console.log(pageToken );
      //set option to query picture object
      var requestOption = {
        method: 'GET',
        uri : 'https://graph.facebook.com/'+page_id+'/picture?access_token='+pageToken+'&type=normal&redirect=0',
        json : true
      };
  
      return sails.requestPromise(requestOption)
        .then(function (body) {
          "use strict";
          console.log("rq-promise", body.data.url);
          Redis.set(key, body.data.url);
          return body.data.url;
      })
        .catch(function (error) {
          "use strict";
          console.log("Error", error);
          return false;
        });
      
    });
    
    return pageAvatar()
      .then(function (data) {
        "use strict";
        console.log("page-avatar", data);
        return data;
      })
      .catch(function (error) {
        "use strict";
        console.log(error);
        return false;
      });
  }
  
};

