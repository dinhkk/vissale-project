﻿$(function() {
	/**
	 * Thuc hien refresh noi dung chat cua 1 conversation
	 */
	var i;
	function refreshMsg(){
		var conv_id = $('.seleted_comment:first').attr('conv_id');
		if((conv_id == 'undefined' || conv_id == '')) {
			return false;
		}
		var last = $('#listMsg').attr('last');
		if(last=='undefined') {
			return false;
		}
		var fb_user_id = $('.seleted_comment:first').attr('uid');
		var i = setInterval(function () {
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
		// set da doc roi; unread
		$(this).find('.unread:first').text('');
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
				resetIntervalMsg();
			},
			error : function(e) {
			}
		});
	});
	// cu 10000 milesecond lai kiem tra xem co conversation nao moi khong
	function refeshConversation(){
		var i_conversation = setInterval(loadConversation, 10000);
		return i_conversation;
	}
	var i_conversation = refeshConversation();
	
	function loadConversation(){
		var last = $('#comment').attr('last');
		var page_id = $('#selected_page').attr('data-id');
		var type = $('#selected_type').attr('data-id');
		var is_read = $('#selected_read').attr('data-id');
		var has_order = $('#selected_order').attr('data-id');
		var selected = $('#comment').attr('cselected');
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
		var type = 'inbox';
		var conv_id = $('.seleted_comment:first').attr('conv_id');
		$.ajax({
			type : 'post',
			url : 'http://fbsale.dinhkk.com/Chat/sendMsg',
			data : {message:message,type:type,conv_id:conv_id},
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
		if(i) {
			clearInterval(i);
		}
		i = refreshMsg();
	}
	function resetIntervalConversation(){
		if(i_conversation) {
			clearInterval(i_conversation);
		}
		i_conversation = refeshConversation();
	}
	// Chon page chat
	$(document).on('click','.select_page',function() {
		var page_id = $(this).attr('data-id');
		var name = $(this).text();
		$('#selected_page').attr('data-id', page_id);
		$('#selected_page').text(name);
		$('#selected_page').append('<span class="caret"></span>');
		loadConversation();
		resetIntervalConversation();
		clearInterval(i);
	});
	$(document).on('click','.select_type',function() {
		var page_id = $(this).attr('data-id');
		var name = $(this).text();
		$('#selected_type').attr('data-id', page_id);
		$('#selected_type').text(name);
		$('#selected_type').append('<span class="caret"></span>');
		$('#listConversation').html('');
		loadConversation();
		resetIntervalConversation();
		clearInterval(i);
	});
	$(document).on('click','.select_read',function() {
		var page_id = $(this).attr('data-id');
		var name = $(this).text();
		$('#selected_read').attr('data-id', page_id);
		$('#selected_read').text(name);
		$('#selected_read').append('<span class="caret"></span>');
		$('#listConversation').html('');
		loadConversation();
		resetIntervalConversation();
		clearInterval(i);
	});
	$(document).on('click','.select_order',function() {
		var page_id = $(this).attr('data-id');
		var name = $(this).text();
		$('#selected_order').attr('data-id', page_id);
		$('#selected_order').text(name);
		$('#selected_order').append('<span class="caret"></span>');
		$('#listConversation').html('');
		loadConversation();
		resetIntervalConversation();
		clearInterval(i);
	});
});