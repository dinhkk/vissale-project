/**
 * PushController
 *
 * @description :: Server-side logic for managing pushes
 * @help        :: See http://sailsjs.org/#!/documentation/concepts/Controllers
 */

module.exports = {
  
  publish: function (req, res) {
    
    
    // sails.sockets.broadcast(roomNames, eventName, data);
    //sails.sockets.join(socket, roomName);
    
    sails.sockets.broadcast('feed', 'new_entry', {'message': 'aaaaa'}); //
    sails.sockets.join(req, 'feed');
    
    return res.ok();
  }
  
};
