/**
 * Conversation.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
  connection: 'someMysqlServer',
  tableName: 'fb_conversation',
  
  attributes: {
    id: {
      type: 'integer',
      primaryKey: true,
      unique: true
    },
    
    conversation_id: {
      type: 'string'
    },
    
    comment_id: {
      type: 'string'
    },
    
    fb_post_id: {
      type: 'string'
    },
    
    post_id: {
      type: 'string'
    },
    
    fb_customer_id: {
      type: 'integer'
    },
    
    fb_user_id: {
      type: 'string'
    },
    
    fb_user_name: {
      type: 'string'
    },
    
    page_id: {
      type: 'string'
    },
    
    fb_page_id: {
      type: 'integer'
    },
    
    group_id: {
      type: 'integer'
    },
    
    last_conversation_time: {
      type: 'integer'
    },
    
    //0-inbox,1-comment post
    type: {
      type: 'boolean'
    },
    
    is_read: {
      type: 'boolean'
    },
    
    has_order: {
      type: 'boolean'
    },
    
    first_content: {
      type: 'text'
    },
    
    link: {
      type: 'boolean'
    },
    
    status: {
      type: 'integer'
    },
    
    created: {
      type: 'date'
    },
    
    modified: {
      type: 'date'
    }
    
  }
};

