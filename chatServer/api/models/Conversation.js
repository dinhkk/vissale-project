/**
 * Conversation.js
 *
 * @description :: TODO: You might write a short summary of how this model works and what it represents here.
 * @docs        :: http://sailsjs.org/documentation/concepts/models-and-orm/models
 */

module.exports = {
  //connection: 'someMysqlServer',
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
  
  /**
   * Get conversations
   * */
  
  
  
  /*
   * Get one conversation detail
   * */
  getChat: function (req, conversation) {
    
    console.log("getting message for conversation");
    
    var page = req.param('page', null);
    if (!page) {
      page = 1;
    }
  
    var limit = req.param('limit', null);
    var group_id = req.param('group_id', null);
    if (!limit) {
      limit = sails.config.constant.limit;
    }
    console.log(conversation);
    if (conversation.type == 0) {
      sails.log.debug('getting message Message');
  
      return Message.find({
        where: {fb_conversation_id: conversation.id, group_id: group_id},
        sort: 'user_created DESC'
      })
        .paginate({page: page, limit: limit})
    
        .then(function (messages) {
          //console.log(messages);
          return messages;
        })
        .catch(function (error) {
          console.log(error);
          return [];
        });
      
    }
    
    if (conversation.type == 1) {
      sails.log.debug('getting Comment messages');
      
      return Comment.find({
        where: {fb_conversation_id: conversation.id, group_id: group_id},
        sort: 'user_created ASC'
      })
        .paginate({page: page, limit: limit})
    
        .then(function (comments) {
          //console.log(comments);
          return comments;
      })
        .catch(function () {
          return [];
        });
    }
  },
  
  /**
   * get conversations by ids
   * */
  
  getConversationsByIds : function(request, idsArray) {
    var Promise = require("bluebird");
    
    var group_id = request.param('group_id', null);
    if (!group_id || idsArray.length ==0) {
      return new Promise(function(resolve) {
        resolve([]);
      });
    }
    
    return this.find({
      where: {group_id: group_id, id : idsArray},
      sort: 'last_conversation_time DESC'
    })
      .then(function (conversations) {
        return conversations;
      })
      .catch(function (error) {
        console.log("Error ", error);
        return [];
      });
    
  }
};

