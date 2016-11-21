/**
 * LogController
 *
 * @description :: Server-side logic for managing logs
 * @help        :: See http://sailsjs.org/#!/documentation/concepts/Controllers
 */

module.exports = {
  
  chat: function (req, res) {
    
    /*if( ! req.isSocket) {
     return res.badRequest();
     }*/
    
    var group_id = req.body.group_id;
    
    console.log(req.body);
    
    sails.sockets.broadcast('log', 'group_id_' + group_id, {id: 123, 'message': 'abc - 1212 - group' + group_id});
    sails.sockets.join(req.socket, 'log');
    
    return res.ok();
  }
  
};

