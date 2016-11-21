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
    //console.log(req.params.all());
  
    Conversation.find({group_id: 457}).limit(10).exec(function (err, conversations) {
      if (err) {
        return res.serverError(err);
      }
      sails.log('Wow, there are %d users named Finn.  Check it out:', conversations.length, conversations);
      return res.json(conversations);
    });
  },
  
  
  /*
   * get one-conversation  by conversation id
   *
   */
  getConversation: function (req, res) {
    var _conversation = null;
    var content = {success: false, message: 'Failed', data: null};
  
    var id = req.param('conversation_id', null);
    var ip = req.ip;
  
    sails.log.info(id, ip);
  
    if (!id) {
      content.message = 'Conversation id is not valid';
      return res.json(content)
    }
  
    Conversation.findOne({id: id}).exec(function (err, conversation) {
    
      if (err || conversation == undefined) {
        return res.json(content);
      }
      sails.log.info(err, conversation);
  
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
