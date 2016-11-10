$(function() {
	var parent_url = base_url;
	/**
	 * Thuc hien refresh noi dung chat cua 1 conversation
	 */
	var i_msg;
	function refreshMsg(){
		var listMsg = $('#listMsg');
		if(listMsg.length==0){
			return false;
		}
		var conv_id = listMsg.attr('conv_id');
		if((conv_id == 'undefined') || (conv_id == '')) {
			return false;
		}
		var last = listMsg.attr('last');
		if(last=='undefined') {
			return false;
		}
		var i = setInterval(function () {
	        $.ajax({
	            type: "POST",
	            data: {last:last,conv_id:conv_id},
	            url: parent_url + 'Chat/refreshMsg',
	            success: function (response) {
	            	// fill data
					if(response=='-1'){
						// khong co thay doi
					}
					else if(response=='0'){
						// khong co data => xoa data
						$('#chatbox').html('');
					}
					// co thay doi => load lai
					else $('#chatbox').html(response);
	            }
	        });
	    }, 3000);
		return i;
		
	}
	// lay danh sach message chat khi click vao 1 conversation
	$(document).on('click','.comment_item',function() {
		var selected = $('.seleted_comment:first');
		if(this==selected) {
			// select cai dang duoc select
			return false;
		}
		selected.removeClass('seleted_comment');
		$(this).addClass('seleted_comment');
		var conv_id = $(this).attr('conv_id');
		var fb_user_id = $(this).attr('uid');
		var post_id = $(this).attr('post_id');

		getFacebookPost(post_id);

		// set da doc roi; unread
		$(this).find('.unread:first').text('');
		var targeturl = parent_url + 'Chat/loadMsg';

		//display loading
		$.LoadingOverlay("show");

		$.ajax({
			type : 'post',
			url : targeturl,
			data : {conv_id:conv_id},
			success : function(response) {
				// fill data
				if(response=='-1'){
					// khong co thay doi
				}
				else if(response=='0'){
					// khong co data => xoa data
					$('#chatbox').html('');
				}
				// co thay doi => load lai
				else $('#chatbox').html(response);
				
				// start interval refresh msg
				resetIntervalMsg();


				$.LoadingOverlay("hide");
			},
			error : function(e) {

				$.LoadingOverlay("hide");
			}
		});
		customerInfo(fb_user_id);
	});

	function getFacebookPost(post_id) {
		var container = $('#display_post_conent');
		console.log(post_id);
		container.hide();

		if (!post_id) {
			return false;
		}

		var url = "https://graph.facebook.com/" + post_id + "?fields=attachments,message, type";
		//var url = "https://graph.facebook.com/1760242010858488_1817462271803128?fields=attachments,message";

		$.get(url, function () {
			console.log("success");
		})
			.done(function (data) {
				console.log("load data", data);

				modifyPostContent(data);
			})
			.fail(function (error) {
				console.log("error");
			});


		function modifyPostContent(data) {
			var html = $("<div id='post-message'></div>");

			if (typeof data.message != 'undefined') {
				html.append(data.message);
				/*getPhotos(data);*/
			}

			if (typeof data.attachments.data[0].subattachments != 'undefined') {
				var imageData = data.attachments.data[0].subattachments.data;
				getPhotos(imageData);
			}

			if (data.type == "link") {
				var media = data.attachments.data[0].media;
				getSinglePhoto(media);
			}

			if (data.type == "photo" && typeof data.attachments.data[0].media != 'undefined') {
				var photo = data.attachments.data[0].media;
				getSinglePhoto(photo);
			}

			function getPhotos(imageData) {
				var imageContainer = $("<div id='img-container'></div>");

				$.each(imageData, function (index, value) {

					var img = "<a target='_blank' href='" + value.media.image.src + "'><img src ='" + value.media.image.src + "'></a>";
					imageContainer.append(img);
				});
				html.append(imageContainer);
			}

			function getSinglePhoto(media) {
				var imageContainer = $("<div id='img-container'></div>");
				var img = "<a target='_blank' href='" + media.image.src + "'><img src ='" + media.image.src + "'></a>";
				imageContainer.append(img);
				html.append(imageContainer);
			}

			var link = "<div id='link-container'><a href='https://fb.com" + data.id + "'>Facebook Post</a></div>";
			html.append(link);

			if (post_id) {
				container.html(html);
				container.show();
			}

		}

	}

	// cu 10000 milesecond lai kiem tra xem co conversation nao moi khong
	function refeshConversation(){
		var i_conversation = setInterval(loadConversation, 3500);
		return i_conversation;

	}
	var i_conversation = refeshConversation();
	
	function loadConversation(){
		var comment = $('#comment');
		var last = comment.attr('last');
		var page_id = $('#selected_page').attr('data-id');
		var type = $('#selected_type').attr('data-id');
		var is_read = $('#selected_read').attr('data-id');
		var has_order = $('#selected_order').attr('data-id');
		var selected = $(document).find('.seleted_comment:first').attr('conv_id');
        $.ajax({
            type: "POST",
            data: {last:last,selected:selected,page_id:page_id,type:type,is_read:is_read,has_order:has_order},
            url: parent_url + 'Chat/refreshConversation',
            success: function (response) {
            	// fill data
				if(response=='-1'){
					// khong co thay doi
				}
				else if(response=='0'){
					// khong co data => xoa data
					$('#listConversation').html('');
					//$('#chatbox').html('');
				}
				// co thay doi => load lai
				else {
					$('#listConversation').html(response);
					//$('#chatbox').html('');
					$('#comment').slimScroll({
						height: '480px'
					});
				}
            }
        });
	}


	function resetIntervalMsg(){
		if(i_msg) {
			clearInterval(i_msg);
		}
		i_msg = refreshMsg();
	}
	function resetIntervalConversation(){
		if(i_conversation) {
			clearInterval(i_conversation);
		}
		i_conversation = refeshConversation();
	}
	function reloadConversation(curr, selected){
		var page_id = $(curr).attr('data-id');
		var name = $(curr).text();
		selected.attr('data-id', page_id);
		selected.text(name);
		selected.append('<span class="caret"></span>');
		$('#comment').attr('last',0);
		loadConversation();
		resetIntervalConversation();
		if(i_msg) clearInterval(i_msg);
	}
	// Chon page chat
	$(document).on('click','.select_page',function() {
		reloadConversation(this, $('#selected_page'));
	});
	
	$(document).on('click','.select_type',function() {
		reloadConversation(this, $('#selected_type'));
	});
	$(document).on('click','.select_read',function() {
		reloadConversation(this, $('#selected_read'));
	});
	$(document).on('click','.select_order',function() {
		reloadConversation(this, $('#selected_order'));
	});
	
	// Search conversation
	$('#txtSearch').on('keydown', function(e) {
	    if (e.which == 13 || e.keyCode == 13) {
	    	searchConversation();
	    }
	    else if(e.which == 27 || e.keyCode == 27){
	    	espSearch();
	    }
	});
	
	function searchConversation(){
		var keyword = $('#txtSearch').val();
		if(keyword==''){
			return false;
		}
    	if(i_conversation) {
			clearInterval(i_conversation);
		}
		if(i_msg) {
			clearInterval(i_msg);
		}
		$('#listConversation').html('Đang tìm ...');
		$('#chatbox').html('');
		var page_id = $('#selected_page').attr('data-id');
		var type = $('#selected_type').attr('data-id');
		var is_read = $('#selected_read').attr('data-id');
		var has_order = $('#selected_order').attr('data-id');
		$.ajax({
			type : 'post',
			url : parent_url + 'Chat/searchConversation',
			data : {keyword:keyword,page_id:page_id,type:type,is_read:is_read,has_order:has_order},
			success : function(response) {
				// fill data
				$('#listConversation').html(response);
			},
			error : function(e) {
			}
		});
	}
	// bo seach
	function espSearch(){
		$('#txtSearch').val('');
		$('#listConversation').html('');
		// khoi dong lai interval refresh conversation
		loadConversation();	
		i_conversation = refeshConversation();
	}
	
	function customerInfo(fb_user_id){
		// set mac dinh
		$('#customerName').text('Đang tải ...');
		$('#customerPhone').text('Đang tải ...');
		$('#customerAddr').text('Đang tải ...');
		$('#customerImg').attr('src', 'https://graph.facebook.com/' + fb_user_id + '/picture?type=normal');
		$.ajax({
			type : 'post',
			url : parent_url + 'Chat/customerInfo',
			data : {fb_user_id:fb_user_id},
			success : function(response) {
				// fill data
				if(response !='0'){
					$('#customerInfo').html(response);
				}
			},
			error : function(e) {
			}
		});
	}

	// Send message
	$(document).on('click','#btnSend',function() {
		sendMessage();
	});

	$( "#txtMessage" ).keypress(function( event ) {
		if ( event.which == 13 ) {
			event.preventDefault();
			sendMessage();

		}
	});

	function sendMessage() {
		var conv_id = $('#listMsg').attr('conv_id');
		if(conv_id =='undefined' || conv_id=='') {
			return false;
		}
		var message = $('#txtMessage').val();

		$('#txtMessage').val('');

		$.ajax({
			type : 'post',
			url : parent_url + 'Chat/sendMsg',
			data : {message:message,conv_id:conv_id},
			success : function(response) {
				// fill data
				//$('#chatbox').html(response);
				$('#listMsg').append(response);
				resetIntervalMsg();
			},
			error : function(e) {
			}
		});

		console.log('send message');
	}
});



$( document ).ready(function() {

});
