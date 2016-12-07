/**
 * PageController
 *
 * @description :: Server-side logic for managing pages
 * @help        :: See http://sailsjs.org/#!/documentation/concepts/Controllers
 */

module.exports = {
  
  /**
   * Get page by group_id
   * */
  getPages: function (req, res) {
    
    var group_id = req.param('group_id', null);
    if (!group_id) {
      return res.notFound();
    }
    
    Group.findOne({
      where: {id: group_id}
    })
      .then(function (group) {
        
        "use strict";
        var content = {success: false, message: null, data: null};
        if (!group || group == undefined) {
          content.message = "Group not found";
          return res.json(content);
        }
        
        return Page.find({
          where: {group_id: group_id},
          sort: 'id DESC'
        })
          .exec(function (err, pages) {
            if (err) {
              return res.serverError(err);
            }
            //sails.log.info('Wow, there are %d pages.  Check it out:', pages.length, pages);
            
            content.success = true;
            content.message = "OK";
            content.data = pages;
            return res.json(content);
          });
        
      })
      .catch(function (err) {
        "use strict";
        return res.serverError(err);
      });
  },
  
  getAvatar : function(request, response) {
    console.time("get-page-avatar->");
    var content = {success: false, message: 'Failed', data: null};
    var group_id = request.param("group_id", null);
    var page_id = request.param("page_id", null);
    
    if (!page_id || !group_id) {
      return response.json(content);
    }
    
    var pageAvatar = Page.getPicture(request);
  
    return pageAvatar
      .then(function (data) {
        sails.log.info("page-avatar=>", data);
        console.timeEnd("get-page-avatar->");
  
        response.writeHead(301,
          {Location: data}
        );
        
        return response.end();
        })
      .catch(function (error) {
        sails.log.error(error);
        return response.json(content);
      });
  }
};

