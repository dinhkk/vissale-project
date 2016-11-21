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
    console.log(req.params.all());
    return res.json(200, req.params.all());
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
