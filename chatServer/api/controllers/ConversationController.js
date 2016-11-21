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
    console.log(req.body);
    return res.ok();
  }
  
};
