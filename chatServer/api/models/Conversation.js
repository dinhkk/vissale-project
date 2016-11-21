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
  
    //conversation_id from messenger facebook platform
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
  
    //0-inbox, 1-comment post
    type: {
      type: 'integer'
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
  
  },
  
  getChat: function (req, conversation, callback) {
    
    console.log(conversation);
    var page = req.param('page', null);
    if (!page) {
      page = 1;
    }
  
    var limit = req.param('limit', null);
    if (!limit) {
      limit = sails.config.constant.limit;
    }
    
    if (conversation.type == 0) {
      sails.log.debug('getting message Message');
  
      conversation.chat = Message.find({
        where: {fb_conversation_id: conversation.id},
        sort: 'user_created ASC'
      })
        .paginate({page: page, limit: limit})
    
        .exec(function (err, messages) {
          
        if (err) {
          sails.log.debug(err);
          return callback(false);
        }
        
        conversation.chat = messages;
        return callback(conversation);
      });
    }
    
    if (conversation.type == 1) {
      sails.log.debug('getting Comment messages');
      Comment.find({
        where: {fb_conversation_id: conversation.id},
        sort: 'user_created ASC'
      })
        .paginate({page: page, limit: limit})
    
        .exec(function (err, messages) {
        if (err) {
          return callback(false);
        }
        
        conversation.chat = messages;
        return callback(conversation);
      });
    }
  }
};

