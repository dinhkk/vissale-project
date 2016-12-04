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
  }
};
