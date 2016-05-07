$(function() {
	var parent_url = base_url;
	/**
	 * Ajax hien thi popup edit 1 post
	 */
	$(document).on('click', '#btnSaveConfig', function() {
		var targeturl = parent_url + 'FBPage/updateConfig';
		var reply_comment_has_phone = $('#txaCommentPhone').val();
		var reply_comment_nophone = $('#txaCommentNoPhone').val();
		var is_like = $('#cbLike').prop('checked')?1:0;
		var is_hide_phone = $('#cbHidePhone').prop('checked')?1:0;
		var is_hide_nophone = $('#cbHideNoPhone').prop('checked')?1:0;
		var is_inbox = $('#cbInbox').prop('checked')?1:0;
		var chia_donhang = $( 'input[name=rdChiaOrder]:checked' ).val();
		var words_blacklist = $('#txtWordsBlacklist').val();
		var phone_filter = $('#txtPhoneFilter').val();
		var fb_app_id = $('#fb_app_id').val();
		var fb_app_secret_key = $('#fb_app_secret_key').val();
		var user_coment_filter = $('#user_coment_filter').val();
		var post_data = {reply_comment_has_phone:reply_comment_has_phone,reply_comment_nophone:reply_comment_nophone,is_like:is_like,
				is_hide_phone:is_hide_phone,is_hide_nophone:is_hide_nophone,is_inbox:is_inbox,chia_donhang:chia_donhang,words_blacklist:words_blacklist,phone_filter:phone_filter,
			fb_app_id:fb_app_id,fb_app_secret_key:fb_app_secret_key,user_coment_filter:user_coment_filter
		};
		$.ajax({
			type : 'post',
			url : targeturl,
			data : post_data,
			async: false,
			success : function(response) {
				// fill data
				if(response==1) {
					$('#modalThongbaoContent').html('Cập nhật thành công');
				}
				else {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không cập nhật được cấu hình');
				}
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không cập nhật được cấu hình');
			}
		});
		// hien thi modal
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
	});
	$('#modalThongbaoClose').on('click', function() {
		// click vao nut close se an modal
		$('#modalThongbao').removeClass('in');
		$('#modalThongbao').css('display', 'none');
	});
	
	/**
	 * Xoa page
	 */
	$(document).on('click','.btnRemovePage',function() {
		var fb_page_id = $(this).parent().parent().attr('fb_page_id');
		var targeturl = parent_url + 'FBPage/removePage/?id=' + fb_page_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			async: false,
			success : function(response) {
				// fill data
				if(response==1) {
					$('#modalThongbaoContent').html(response);
				}
				else {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không xoá được Fanpage');
				}
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không xoá được Fanpage');
			}
		});
		// hien thi modal
		if($('#modalThongbaoContent').html()==1) {
			$('#modalThongbaoContent').html('Xoá thành công');
			$(this).parent().parent().remove();
		}
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
	});
	/**
	 * Huy dang ky
	 */
	$(document).on('click','.btnCancelPage',function() {
		var fb_page_id = $(this).parent().parent().attr('fb_page_id');
		var targeturl = parent_url + 'FBPage/unregisterPage/?id=' + fb_page_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			async: false,
			success : function(response) {
				// fill data
				if(response==1) {
					$('#modalThongbaoContent').html(response);
				}
				else {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không huỷ đăng ký được Fanpage');
				}
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không huỷ đăng ký được Fanpage');
			}
		});
		// hien thi modal
		if($('#modalThongbaoContent').html()==1) {
			$('#modalThongbaoContent').html('Huỷ đăng ký thành công');
			$(this).parent().parent().find('.md-radiobtn').prop('checked',false);
			$(this).removeClass('purple-plum btnCancelPage');
			$(this).addClass('green btnRegPage');
			$(this).text('Đăng ký');
		}
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
	});
	/**
	 * Dang ky page
	 */
	$(document).on('click','.btnRegPage',function() {
		var fb_page_id = $(this).parent().parent().attr('fb_page_id');
		var targeturl = parent_url + 'FBPage/registerPage/?id=' + fb_page_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			async: false,
			success : function(response) {
				// fill data
				if(response==1) {
					$('#modalThongbaoContent').html(response);
				}
				else {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không đăng ký được Fanpage');
				}
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không huỷ ký được Fanpage');
			}
		});
		// hien thi modal
		if($('#modalThongbaoContent').html()==1) {
			$('#modalThongbaoContent').html('Đăng ký thành công');
			$(this).parent().parent().find('.md-radiobtn').prop('checked',true);
			$(this).removeClass(' green btnRegPage');
			$(this).addClass('purple-plum btnCancelPage');
			$(this).text('Huỷ đăng ký');
		}
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
	});
});