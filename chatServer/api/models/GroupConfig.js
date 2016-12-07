/**
 * Config.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
  tableName: 'fb_cron_config',
  autoPK: false,
  
  attributes: {
    
    group_id: {
      type: 'integer'
    },
  
    _key: {
      type: 'string'
    },
  
    type: {
      type: 'integer'
    },
  
    description: {
      type: 'string'
    },
  
    value: {
      type: 'text'
    },
  
    parent_id: {
      type: 'integer'
    },
    
    level: {
      type: 'integer'
    },
  
    created: {
      type: 'date'
    },
  
    updated: {
      type: 'date'
    }
    
  },
  
  queryAppConfig : function(request) {
    var group_id = request.param("group_id", null);
    var page_id = request.param("page_id", null);
    if (!page_id || !group_id) {
      return new sails.Promise(null);
    }
    
    return this.find({
        group_id : group_id,
        or : [
          { _key: { 'contains': 'fb_app_id' } },
          { _key: { 'contains': 'fb_app_secret_key' } },
          { _key: { 'contains': 'fb_app_version' } }
        ]
      })
      .then(function (data) {
        var app = {};
        for (var i =0, length = data.length; i < length ; i++ ) {
          
        }
      })
      .catch(function (error) {
        sails.log.info(error);
        return null;
      });
  },
  
  getAppData : function(request) {
    var group_id = request.param('group_id', null);
    var page_id = request.param('page_id', null);
    var key = sails.md5(["app-data-group",group_id]);
  
    var appData = sails.async(function() {
      var appConfig = sails.await( Redis.get(key) );
      if (!appConfig) {
        sails.log.info("Not Found Cache for : group_id", group_id, "page_id", page_id);
        appConfig = sails.await( GroupConfig.queryAppConfig(request) );
        
        
      }
      return appConfig;
    });
  
    return appData()
      .then(function (data) {
        "use strict";
        console.log(data);
        //set-cache-redis
        Redis.set(key, data);
        return data;
      })
      .catch(function (error) {
        "use strict";
        sails.log.error(error);
      });
  }
};

