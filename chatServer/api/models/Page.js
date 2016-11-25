/**
 * Page.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
  
  connection: 'someMysqlServer',
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
    
    page_name: {
      type: 'string'
    },
    
    last_conversation_time: {
      type: 'integer'
    },
    
    status: {
      type: 'integer'
    }
    
  }
};

