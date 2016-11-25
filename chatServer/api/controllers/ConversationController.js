/**
 * ConversationController
 *
 * @description :: Server-side logic for managing conversations
 * @help        :: See http://sailsjs.org/#!/documentation/concepts/Controllers
 */

module.exports = {
  
  /**
   * get multi-conversation  by group id
   */
  
  getConversations: function (req, res) {
    var group_id = req.param('group_id', null);
    if (!group_id) {
      return res.notFound();
    }

      var content = {success: false, message: null, data: [], page: 1};
  
    Group.findOne({
      where: {id: group_id}
    })
  
      .then(function (group) {
    
        "use strict";
    
        if (!group || group == undefined) {
          content.message = "Group not found";
          return res.json(content);
        }
    
        var page = req.param('page', null);
        if (!page) {
          page = 1;
        }
        content.page = page;
        var limit = req.param('limit', null);
        if (!limit) {
          limit = sails.config.constant.limit;
        }
    
        return Conversation.find({
          where: {group_id: group_id},
          sort: 'last_conversation_time DESC'
        })
          .paginate({page: page, limit: limit})
          .exec(function (err, conversations) {
            if (err) {
              return res.serverError(err);
            }
            sails.log.info('Wow, there are %d conversations.  Check it out:', conversations.length, conversations);
        
            content.success = true;
            content.message = "OK";
            content.data = conversations;
            return res.json(content);
          });
      
    })
      .catch(function (err) {
        "use strict";
        return res.serverError(err);
      });
  },
  
  
  /*
   * get one-conversation  by conversation id
   *
   */
  getConversation: function (req, res) {
    var _conversation = null;
      var content = {success: false, message: 'Failed', data: [], page: 1};
  
    var id = req.param('conversation_id', null);
      var group_id = req.param('group_id', null);
    var ip = req.ip;
  
    sails.log.info(id, ip);
  
    if (!id) {
      content.message = 'Conversation id is not valid';
      return res.json(content)
    }
  
    var page = req.param('page', null);
    if (!page) {
      page = 1;
    }
    content.page = page;
      Conversation.findOne({id: id, group_id: group_id}).exec(function (err, conversation) {
    
      if (err || conversation == undefined) {
        return res.json(content);
      }
      sails.log.info(err, conversation);
      conversation.is_read = 1;
      conversation.save(
        function(err){
          console.log('update failed', err, conversation);
        });
        
      return Conversation.getChat(req, conversation, function (response) {
      
        if (!response) {
          return res.json(content);
        }
      
        content.success = true;
        content.data = conversation;
        content.message = "OK";
      
      
        return res.json(content);
      });
    
    });
  }
  
};
