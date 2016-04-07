var lstComment = [];
var currentComment = "";
var currentPost = "";
var currentUserID = "";
var curType = "";
var paging = 1;

$(document).ajaxStart(function () {
    $('#comment').addClass("loading");
});
$(document).ajaxStop(function () {
    $('#comment').removeClass("loading");
});


//refresh list comment
function RefreshList() {
    var page = $('#ddbPageSelect').find('.dropdown-toggle')[0].getAttribute('data-id');
    var type = $('#ddbType').find('.dropdown-toggle')[0].getAttribute('data-id');
    var status = $('#ddbStatus').find('.dropdown-toggle')[0].getAttribute('data-id');
    var order = $('#ddbOrder').find('.dropdown-toggle')[0].getAttribute('data-id');
    var search = $('#search').val();
    //$(this).attr('commentid')) })

    var post = { pageid: page, type: type, status: status, order: order, paging: paging, lstCurrent: lstComment, search: search };

    $.ajax({
        contentType: 'application/json; charset=utf-8',
        type: "POST",
        url: '/FanPage/GetListFBCommentRefresh',
        data: JSON.stringify(post),
        success: function (data) {
            //  alert(JSON.stringify(data));
            if (data.addnew != null) {
                var temp = "";
                for (var i in data.addnew) {
                    temp += loadComment(data.addnew[i]);
                    var check = $('#comment').find('div[commentid="' + data.addnew[i].ID + '"]');
                    if (check != undefined) {
                        check.remove();
                    } else {
                        $('#comment >:last-child').remove();
                    }
                }

                $("#comment").prepend(temp);

                lstComment = data.cur;
            }

        }
    });
}

$(document).ready(function () {
    //Load data cho dropdownbox page
    loadPageData();
    getListComment();
    //setInterval(function () {
    //    if (currentComment == "")
    //        return;
    //    getChatList(currentComment);
    //}, 30000);

    setInterval(function () {
        $.ajax({
            type: "POST",
            url: '/FanPage/CheckNotify',
            success: function (data) {
                if (data.Count > 0) {
                    paging = 1;
                    // lstComment = [];
                    //$("#comment").html("");
                    //getListComment();
                    RefreshList();
                    if (currentComment == "")
                        return;
                    getChatListRefresh(currentComment, curType);
                }
            }
        });
    }, 10000);

    resizeLayout();
    $("#comment").scroll(function () {
        //alert('ss');
        if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight - 100) {
            paging++;
            getListComment();
        }


    });


    $('#search').keypress(function (e) {
      
        if (e.which == 13) {
            $("#comment").html("");
            getListComment();
            paging = 1;
            console.log("searhc");
        }
    });
});



function getChatListRefresh(id, type) {
    currentComment = id;
    curType = type;
    for (var i in lstComment) {
        if (lstComment[i].ID == id) {
            currentPost = lstComment[i];
            $("#userName").html(lstComment[i].UserName);
            $("#userName").attr("href", "http://facebook.com/" + currentPost.UserID);
            $("#userImage").attr("src", 'http://graph.facebook.com/' + lstComment[i].UserID + '/picture?type=normal');
        }
    }

    $.ajax({
        type: "POST",
        url: '/FanPage/GetListChat',
        data: { id: id, type: type },
        success: function (data) {
            loadChatList(data);
            $('#chatbox').scrollTop($('#chatbox').prop("scrollHeight"));
        }
    });
}


function SendClick(e) {
    if (e.keyCode == 13) {
        ReplyComment();
        e.preventDefault();
    }
}

function loadPageData() {
    $.ajax({
        type: "POST",
        url: '/FanPage/GetFanPageData',
        success: function (data) {
            loadDataDropDown(data);
            //ajax xong moi gan su kien
            //gan su kien cho cac dropdownbox
            $(".dropdown-menu li a").click(function () {
                var selText = $(this).text();
                var dataid = $(this).context.getAttribute('data-id')
                $(this).parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
                $(this).parents('.btn-group').find('.dropdown-toggle')[0].setAttribute('data-id', dataid)
                paging = 1;
                lstComment = [];
                var str = ' <div class="modal" style="position:absolute"></div>'
                $("#comment").html("");
                $("#comment").append(str);
                getListComment();
            });

        }
    });
}
function loadDataDropDown(lstPage) {
    $('#ddbPageSelect').find('.dropdown-menu').append('<li><a href="#" data-id="null"> Tất Cả </a></li>');
    $.each(lstPage, function (index, value) {
        var row = '<li><a href="#" data-id=' + value.PageID + '>' + value.PageName + '</a></li>';
        $('#ddbPageSelect').find('.dropdown-menu').append(row);
    });

}

function resizeLayout() {

    var h = $('html').outerHeight() - 30;
    h = h - $('.main-footer').innerHeight() - $('.navbar-static-top').innerHeight() - 10;
    $('.content').find('.fullHeigh').css('height', h);
    $('#comment').css('height', h - $('#comment_filter').height());
    //$("#chatbox").parents().css('height', h-100);
    // $("#chatbox").css('height', h - $('#header_chat').height() - $('#footer_chat').height() - 20);
    $('#chatcontent').css('height', $('#chatcontainer').height() - $('#footer_chat').height() - $('#header_chat').height() - 80);
    $('#comment').slimScroll({
        height: 'auto',
        alwaysVisible: true,
        railVisible: true
    });
    $('#chatbox').slimScroll({
        //   start: 'bottom',
        height: 'auto'
        // alwaysVisible: true,
        // railVisible: true
    });

    $('#chooseMessage').slimScroll({
        //   start: 'bottom',
        height: '330px'
        // alwaysVisible: true,
        // railVisible: true
    });

}
function getListComment() {
    var page = $('#ddbPageSelect').find('.dropdown-toggle')[0].getAttribute('data-id');
    var type = $('#ddbType').find('.dropdown-toggle')[0].getAttribute('data-id');
    var status = $('#ddbStatus').find('.dropdown-toggle')[0].getAttribute('data-id');
    var order = $('#ddbOrder').find('.dropdown-toggle')[0].getAttribute('data-id');
    var search = $('#search').val();
    //$(this).attr('commentid')) })

    var post = { pageid: page, type: type, status: status, order: order, paging: paging,search:search };

    $.ajax({
        contentType: 'application/json; charset=utf-8',
        type: "POST",
        url: '/FanPage/GetListFBComment',
        data: JSON.stringify(post),
        success: function (data) {
            lstComment = lstComment.concat(data);
            loadListComment(data);
        }
    });

    return false;
}

function loadListComment(data) {
    var temp = "";
    for (var i in data) {
        temp += loadComment(data[i]);        
    }
    $("#comment").html($("#comment").html() + temp);

}


function loadComment(item) {

    var temp = $("#comment_templete").html();
    temp = temp.replace("{postid}", item.PostID);
    temp = temp.replace("{postid}", item.PostID);
    temp = temp.replace("{pageid}",item.PageID);
    temp = temp.replace("{commentid}", item.ID);
    temp = temp.replace("{commentid}", item.ID);
    temp = temp.replace("{typeof}", item.TypeOf);
    temp = temp.replace("{UserName}", item.UserName);
    temp = temp.replace("{UserName}", item.UserName);
    if (item.Unread == 0)
        temp = temp.replace("{Unread}", "");
    else
        temp = temp.replace("{Unread}", item.Unread);
    temp = temp.replace("{Text}", item.Text);
    temp = temp.replace("{UserLink}", item.UserLink);
    temp = temp.replace("{UserLink}", item.UserLink);
    temp = temp.replace("{UserID}", item.UserID);
    temp = temp.replace("{UserID}", item.UserID);
    temp = temp.replace("{Time}", item.FormtedTime);
    if (item.TypeOf == "comment") {
        temp = temp.replace("{typeof}", "fa fa-fw fa-comment");
    }
    else {
        temp = temp.replace("{typeof}", "fa fa-fw fa-envelope");
    }

    return temp;
}
function commentClick(id, e, type, username, userid,postid,pageid) {
    $(e).find('.unread').html("");
    $('.comment_item').removeClass('seleted_comment');
    $(e).addClass('seleted_comment');
    getChatList(id, type, username, userid,postid);
    $('#txtMessage').focus();
    $('#curPage').val(pageid);
    $('#curPost').val(postid);
}

function getChatList(id, type, username, userid,postid) {
    currentComment = id;
    curType = type;

    $("#userName").html(username);
    $("#userName").attr("href", "http://facebook.com/" + userid);
    $("#userImage").attr("src", 'http://graph.facebook.com/' + userid + '/picture?type=normal');

    $("#customerName").html("Loading...");
    $("#customerPhone").html("Loading...");
    $("#customerOrder").html("Loading...");
    $("#customerAddress").html("Loading...");

    openWaitingDiv($('#Chat-Select'), 'holdon-overlay-div', 'custom', '');
    $('#chatbox').html('');
    $.ajax({
        type: "POST",
        url: '/FanPage/GetListChat',
        data: { id: id, type: type },
        success: function (data) {
            loadChatList(data);
            $('#chatbox').scrollTop($('#chatbox').prop("scrollHeight"));
            closeWaitingDiv('holdon-overlay-div');
        }
    });

    $.ajax({
        type: "POST",
        url: '/FanPage/GetUserInfo',
        data: { userID: userid },
        success: function (data) {
            $("#customerName").html(data.Name);
            $("#customerPhone").html(data.PhoneList);
            $("#customerOrder").html(data.Order);
            $("#customerAddress").html(data.Address);
        }
    });
    $("#postLink").attr("href", 'http://facebook.com/' + postid);
    $.ajax({
        type: "POST",
        url: '/FanPage/GetPostInfo',
        data: { pageID: postid.split('_')[0], postID: postid },
        success: function (data) {
           
            if (data.Code == 1) {

                $("#postImage").attr("src", data.Image);
                $("#postImage").attr("title", "Ngày Tạo: " + data.CreateTime);
             

            }
            else {
                $("#postImage").attr("title", "");
                $("#postImage").attr("src", '');
             
            }
        }
    });
}
function loadChatList(data) {
    var temp = "";
    for (var i in data) {
        temp += loadChat(data[i]);
    }
    $("#chatbox").html(temp);

    //  $('#chatbox').scrollTop($('#chatbox').prop("scrollHeight"));
}
function loadChat(item) {
    var temp = $("#chat_templete").html();
    if (item.IsMe == 1) {
        temp = temp.replace("{right}", "");
        temp = temp.replace("{chatFloat}", "left");
    }
    else {
        temp = temp.replace("{right}", "right");
        temp = temp.replace("{chatFloat}", "right");
    }
    temp = temp.replace("{user_image}", 'http://graph.facebook.com/' + item.UserID + '/picture?type=normal');
    if (item.Note != undefined) {
        var img = "<br><img src=" + item.Note + " style='width:100px;height:100px;'>";
        temp = temp.replace("{Message}", item.Message + img);
    }
    else {
        temp = temp.replace("{Message}", item.Message);
    }

    return temp;
}

function ReplyComment() {
    var message = $("#txtMessage").val();
    var totalFiles = document.getElementById("photoupload").files.length;
    if (totalFiles > 0) {
        ReplyCommentWithPhoto();
        return;
    }
    var item = { Message: message, UserID: currentPost.PageID, IsMe: 0 };
    var temp = loadChat(item);
    $("#txtMessage").val("");
    $("#chatbox").html($("#chatbox").html() + temp);
    $('#chatbox').scrollTop($('#chatbox').prop("scrollHeight"));
    debugger;
    $.ajax({
        type: "POST",
        url: '/FanPage/ReplyComment',
        data: { pageID: $("#curPage").val(), commentID: currentComment, message: message, type: curType },
        success: function (data) {
            if (data.Code == 4)
                alert(data.Message);
            else {

            }
        }
    });
}

function ReplyCommentWithPhoto() {
    var message = $("#txtMessage").val();
    var formData = new FormData();
    var totalFiles = document.getElementById("photoupload").files.length;
    for (var i = 0; i < totalFiles; i++) {
        var file = document.getElementById("photoupload").files[i];
        formData.append("photoupload", file);
    }
    formData.append("pageID", $("#curPage").val());
    formData.append("commentID", currentComment);
    formData.append("message", message);

    $('#photoupload').replaceWith($('#photoupload').clone());

    $('#photoupload').val('');
    var img = document.getElementById('imgpr');
    //  img.src = "http://findicons.com/files/icons/1226/agua_extras_vol_1/128/pictures_2.png";
    var item = { Message: message, UserID: $("#curPage").val(), IsMe: 0, Note: img.src };
    var temp = loadChat(item);
    $("#txtMessage").val("");
    $("#chatbox").html($("#chatbox").html() + temp);

    $.ajax({
        type: "POST",
        url: '/FanPage/ReplyCommentWithPhoto',
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.Code == 4)
                alert(data.Message);
            else {


            }
        }
    });
}



