/**
 * Message.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
  
  //connection: 'someMysqlServer',
  tableName: 'fb_conversation_messages',
  
  attributes: {
    id: {
      type: 'integer',
      primaryKey: true,
      unique: true
    },
    
    fb_conversation_id: {
      type: 'integer'
    },
    
    group_id: {
      type: 'integer'
    },
    
    fb_customer_id: {
      type: 'integer'
    },
    
    fb_user_id: {
      type: 'string'
    },
    
    fb_page_id: {
      type: 'integer'
    },
    
    message_id: {
      type: 'string'
    },
    
    content: {
      type: 'text'
    },
    
    status: {
      type: 'integer'
    },
    
    user_created: {
      type: 'integer'
    },
    
    created: {
      type: 'datetime'
    },
    
    modified: {
      type: 'datetime'
    },
    
    reply_type: {
      type: 'integer'
    }
    
  }
};

