/**
 * Comment.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
  
  connection: 'someMysqlServer',
  tableName: 'fb_post_comments',
  
  attributes: {
    
    id: {
      type: 'integer',
      primaryKey: true,
      unique: true
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
    
    page_id: {
      type: 'string'
    },
    
    fb_post_id: {
      type: 'string'
    },
    
    post_id: {
      type: 'string'
    },
    
    comment_id: {
      type: 'string'
    },
    
    content: {
      type: 'text'
    },
    
    parent_comment_id: {
      type: 'string'
    },
    
    fb_conversation_id: {
      type: 'integer'
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

