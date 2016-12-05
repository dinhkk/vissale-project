/**
 * Created by dinhkk on 12/4/16.
 */

module.exports = {
  tools: function(){
    // fancy code that sends an email
    console.log("Service Helper");
  },
  
  getConversationIDList : function(arrayList) {
    var result = [];
    for (var i = 0, len = arrayList.length; i < len; i++) {
      result.push(arrayList[i].fb_conversation_id);
    }
    
    return result;
  },
  
  setConversationQueryOptions : function(request){
    var options = {};
    options.group_id  = request.param('group_id', null);
    options.page      = request.param('page', null);
    options.limit     = request.param('limit', null);
    
    if (!options.page) {
      options.page = 1;
    }
    
    if (!options.limit) {
      options.limit = sails.config.constant.limit;
    }
    
    return options;
  },
  
  isSearchStringValid : function(search) {
    return search != null && String(search).length > 3;
  }
  
};
