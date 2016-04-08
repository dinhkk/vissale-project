$(function() {
	/**
	 * Thuc hien refresh noi dung chat cua 1 conversation
	 */
	var i;
	function refreshMsg(){
		var i = setInterval(function () {
			var conv_id = $('.seleted_comment:first').attr('conv_id');
			if((conv_id == 'undefined' || conv_id == '')) {
				return false;
			}
			var last = $('#listMsg').attr('last');
			if(last=='undefined') {
				return false;
			}
			var fb_user_id = $('.seleted_comment:first').attr('uid');
	        $.ajax({
	            type: "POST",
	            data: {last:last,conv_id:conv_id,uid:fb_user_id},
	            url: 'http://fbsale.dinhkk.com/Chat/refreshMsg',
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
	    }, 10000);
		return i;
		
	}
	// lay danh sach message chat khi click vao 1 conversation
	$(document).on('click','.comment_item',function() {
		$(document).find('.comment_item').removeClass('seleted_comment');
		$(this).addClass('seleted_comment');
		var conv_id = $(this).attr('conv_id');
		$('#comment').attr('cselected',conv_id);
		var fb_user_id = $(this).attr('uid');
		var last_time = $(this).attr('last_time');
		var targeturl = 'http://fbsale.dinhkk.com/Chat/loadMsg';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : {conv_id:conv_id,uid:fb_user_id,last:last_time},
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
				if(i) {
					clearInterval(i);
				}
				i = refreshMsg();
			},
			error : function(e) {
			}
		});
	});
	// cu 10000 milesecond lai kiem tra xem co conversation nao moi khong
	setInterval(function () {
		var last = $('#Chat-Select').attr('last');
		var selected = $('#comment').attr('cselected');
        $.ajax({
            type: "POST",
            data: {last:last,selected:selected},
            url: 'http://fbsale.dinhkk.com/Chat/refreshConversation',
            success: function (response) {
            	// fill data
				if(response=='-1'){
					// khong co thay doi
				}
				else if(response=='0'){
					// khong co data => xoa data
					$('#comment').html('');
				}
				// co thay doi => load lai
				else $('#comment').html(response);
            }
        });
    }, 10000);
	// Send message
	$(document).on('click','#btnSend',function() {
		var message = $('#txtMessage').val();
		$('#txtMessage').val('');
		var type = 'inbox';
		var conv_id = $('.seleted_comment:first').attr('conv_id');
		$.ajax({
			type : 'post',
			url : 'http://fbsale.dinhkk.com/Chat/sendMsg',
			data : {message:message,type:type,conv_id:conv_id},
			success : function(response) {
				// fill data
				$('#chatbox').html(response);
				if(i) {
					clearInterval(i);
				}
				i = refreshMsg();
			},
			error : function(e) {
				
			}
		});
	});
});