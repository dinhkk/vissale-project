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
    
    console.log(process.env.NODE_ENV);
    console.time("Start_getting_conversations");
    
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
            
        
            content.success = true;
            content.message = "OK";
            content.data = conversations;
  
            console.timeEnd("Start_getting_conversations");
            
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
    console.time("getting_conversation_message");
  
    var content = {success: false, message: 'Failed', data: [], page: 1};
  
    var id = req.param('conversation_id', null);
    var group_id = req.param('group_id', null);
    
    var ip =  req.headers['x-forwarded-for'] || req.connection.remoteAddress;
  
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
    
    var result = sails.async(function () {
      var conversation = Conversation.findOne({id: id, group_id: group_id})
        .then(function (conversation) {
          if (conversation == undefined) {
            return false;
          }
          conversation.is_read = 1;
          conversation.save(
            function(err){
              if (err) { console.log('updated failed', err); }
              console.log('updated data', "is_read = 1 now");
            });
          
          return conversation;
          })
        .catch(function error(error){
            console.log("Error:", error);
            return false;
        });
      
      var result = sails.await(conversation);
      result.chat = sails.await( Conversation.getChat (req, result) );
      
      return {conversation : result};
    });
    
    result()
      .then (function (data) {
        
        if (!data.conversation) {
          return res.json(content);
        }
        //console.log(data);
        content.data = data.conversation;
        content.success = true;
        content.message = "OK OK";
        
        console.timeEnd("getting_conversation_message");
        return res.json(content);
      })
      .catch(function (err) {
        console.log('Something went wrong: ' + err);
        return res.json(content);
      });
  },
  
  /*
   * send message via api
   *
   */
  
  sendMessage : function (req, res) {
    var content = {success: false, message: 'Failed', data: [], page: 1};
    
    var conversation_id = req.param('conversation_id', null);
    var group_id = req.param('group_id', null);
    var message = req.param('message', null);
    var attachment_url = req.param('attachment_url', null);
    var is_private = req.param('is_private', null);
    
    //we must valid request source
    
    //if not valid data
    if (!group_id || !conversation_id) {
       return res.json(content);
    }
    var sendMessageApi = limit = sails.config.constant.send_msg_api;
    var queryString = sails.querystring.stringify({ message: message, group_chat_id: conversation_id, is_private:is_private });
    var url = sendMessageApi + '?' + queryString;
    
    //send request to chat-api
    sails.request.get({url:url, json:true}, function (error, response, body) {
      if (error) {
        return res.json(content);
      }
      console.log("request url", url);
      console.log('Send message successfully! Server responded with:', body.data, body);
      console.log('Body data is success ?:', body.success);
  
      if (body.success == true) {
        content.success = true;
        content.message = "OK";
        content.data = body.data;
      }
      
      res.json(content);
    });
  },
  
  
  /**
   * Search conversations
   * **/
  
  searchConversations : function(request, response) {
    var options = Helper.setConversationQueryOptions(request);
    var content = {success: false, message: 'Failed', data: [], page: options.page};
    
    var searchWords = request.param("search", null);
    var group_id = request.param('group_id', null);
    
    if (!group_id || !Helper.isSearchStringValid(searchWords) ) {
      content.message = "Group id not valid or search characters number is smaller than 3";
      return response.json(content);
    }
    
    sails.log.info("searching for", searchWords);
    
    console.time("searchConversation->");
    console.log("searching->", searchWords);
    
    //find content, fb_user_name of message and comment
    var conversations = sails.async(function() {
        var messages = sails.await(Message.findMessages(request));
        var comments = sails.await(Comment.findComments(request));
        var listConvMsg = Helper.getConversationIDList(messages);
        var listConvCom = Helper.getConversationIDList(comments);
        
        return listConvMsg.concat(listConvCom);
      
    });
  
    //get conversations from array id
    return conversations()
      .then(function success(data) {
        
        var getConversationsByIds = Conversation.getConversationsByIds(request, data);
        
        getConversationsByIds
          .then(function (conversations) {
            //console.log(conversations);
  
            content.message = "OK OK";
            content.success = true;
            content.data = conversations;
            
            console.timeEnd("searchConversation->");
            return response.json(content);
          })
          .catch(function (error) {
            sails.log.debug(error);
            console.timeEnd("searchConversation->");
            return response.json(content);
          });
      })
      .catch(function error(error) {
        console.log(error);
        console.timeEnd("searchConversation");
        return response.ok();
      });
  }
  
};
