$(function() {
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
		var selected = $('.seleted_comment:first');
		if(this==selected) {
			// select cai dang duoc select
			return false;
		}
		selected.removeClass('seleted_comment');
		$(this).addClass('seleted_comment');
		var conv_id = $(this).attr('conv_id');
		var fb_user_id = $(this).attr('uid');
		// set da doc roi; unread
		$(this).find('.unread:first').text('');
		var targeturl = 'http://fbsale.dinhkk.com/Chat/loadMsg';
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
			},
			error : function(e) {
			}
		});
		customerInfo(fb_user_id);
	});
	// cu 10000 milesecond lai kiem tra xem co conversation nao moi khong
	function refeshConversation(){
		var i_conversation = setInterval(loadConversation, 10000);
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
            url: 'http://fbsale.dinhkk.com/Chat/refreshConversation',
            success: function (response) {
            	// fill data
				if(response=='-1'){
					// khong co thay doi
				}
				else if(response=='0'){
					// khong co data => xoa data
					$('#listConversation').html('');
					$('#chatbox').html('');
				}
				// co thay doi => load lai
				else {
					$('#listConversation').html(response);
					$('#chatbox').html('');
				}
            }
        });
	}
	
	// Send message
	$(document).on('click','#btnSend',function() {
		var message = $('#txtMessage').val();
		$('#txtMessage').val('');
		var conv_id = $('.seleted_comment:first').attr('conv_id');
		$.ajax({
			type : 'post',
			url : 'http://fbsale.dinhkk.com/Chat/sendMsg',
			data : {message:message,conv_id:conv_id},
			success : function(response) {
				// fill data
				$('#chatbox').html(response);
				resetIntervalMsg();
			},
			error : function(e) {
			}
		});
	});
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
			url : 'http://fbsale.dinhkk.com/Chat/searchConversation',
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
		$('#customerImg').attr('src','http://graph.facebook.com/'+fb_user_id+'/picture?type=normal');
		$.ajax({
			type : 'post',
			url : 'http://fbsale.dinhkk.com/Chat/customerInfo',
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
});