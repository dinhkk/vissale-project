$(function() {
	/**
	 * Ajax hien thi popup edit 1 post
	 */
	$(document).on('click','.updatePost',function() {
		var post_id = $(this).parent().attr('post_id');
		var targeturl = base_url + '/FBPosts/edit/?id='+post_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				// fill data
				$('#modalPostBody').html(response);
				$('#modalPost').addClass('in');
				$('#modalPost').css('display', 'block');
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không cập nhật được post');
				// hien thi modal
				$('#modalThongbao').addClass('in');
				$('#modalThongbao').css('display', 'block');
			}
		});
	});
	/**
	 * Ajax hien thi popup copy 1 post
	 */
	$(document).on('click','.copyPost',function() {
		var post_id = $(this).parent().attr('post_id');
		var targeturl = base_url + '/FBPosts/copy/?id='+post_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				// fill data
				$('#modalPostBody').html(response);
				$('#modalPost').addClass('in');
				$('#modalPost').css('display', 'block');
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không copy được post');
				// hien thi modal
				$('#modalThongbao').addClass('in');
				$('#modalThongbao').css('display', 'block');
			}
		});
	});
	$('#modalThongbaoClose').on('click', function() {
		// click vao nut close se an modal
		$('#modalThongbao').removeClass('in');
		$('#modalThongbao').css('display', 'none');
	});
	$(document).on('click','#btnPostModalCancel', function() {
		// click vao nut close se an modal
		$('#modalPost').removeClass('in');
		$('#modalPost').css('display', 'none');
	});
	/**
	 * Thuc hien ajax de edit 1 post
	 */
	$(document).on('click','#btnPostModalSubmit',function() {
		var post_id = $(this).parent().attr('post_id');
		var targeturl = base_url + '/FBPosts/editPost';
		var update_data = '';
		var id = $('#fb_post_id').val();
		var post_id = $('#post_id').val();
		var fb_page_id = $('#fb_page_id').val();
		var description = $('#description').val();
		var product_id = $('#product_id').val();
		var bundle_id = $('#bundle_id').val();
		var answer_nophone = $('#answer_nophone').val();
		var answer_phone = $('#answer_phone').val();
		update_data = {id:id,post_id:post_id,description:description,product_id:product_id,bundle_id:bundle_id,answer_nophone:answer_nophone,answer_phone:answer_phone,fb_page_id:fb_page_id};

		$( ".form-data" ).each(function() {
			//console.log( $(this).val() );
			var property = $(this).attr('id');
			update_data[property] = $(this).val();
		});
		
		$.ajax({
			type : 'post',
			url : targeturl,
			data : update_data,
			complete : function() {
				$('#modalPost').removeClass('in');
				$('#modalPost').css('display', 'none');
				$('#modalThongbao').addClass('in');
				$('#modalThongbao').css('display', 'block');
			},
			success : function(response) {
				// fill data
				if(response=='1'){
					// reload lai page
					$('#modalThongbaoContent').html('Cập nhật thành công ');
					$('#modalThongbao').delay(2000).show(0);
					location.reload();
				}
				else 
					$('#modalThongbaoContent').html('Cập nhật không thành công ');
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, cập nhật không thành công');
			}
		});
	});
	/**
	 * Thuc hien ajax xoa 1 post
	 */
	$(document).on('click','.delPost',function() {
		var post_id = $(this).parent().attr('post_id');
		var targeturl = base_url + '/FBPosts/delete/?id='+post_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			complete : function() {
				$('#modalThongbao').addClass('in');
				$('#modalThongbao').css('display', 'block');
			},
			success : function(response) {
				// fill data
				$('#modalThongbaoContent').html('Xoá thành công ');
				$('#modalThongbao').delay(2000).show(0);
				location.reload();
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không xoá được post');
				// hien thi modal
				$('#modalThongbao').addClass('in');
				$('#modalThongbao').css('display', 'block');
			}
		});
	});
	/**
	 * Thuc hien ajax de them moi 1 post
	 */
	$(document).on('click','#btnPostModalAddSubmit',function() {
		var post_id = $(this).parent().attr('post_id');
		var targeturl = base_url + '/FBPosts/addPost';
		var update_data = '';
		var post_id = $('#post_id').val();
		var description = $('#description').val();
		var product_id = $('#product_id').val();
		var bundle_id = $('#bundle_id').val();
		var answer_nophone = $('#answer_nophone').val();
		var answer_phone = $('#answer_phone').val();
		var fb_page_id = $('#fb_page_id').val();

		update_data = {post_id:post_id,description:description,product_id:product_id,bundle_id:bundle_id,answer_nophone:answer_nophone,answer_phone:answer_phone,fb_page_id:fb_page_id};

		$( ".form-data" ).each(function() {
			//console.log( $(this).val() );
			var property = $(this).attr('id');
			update_data[property] = $(this).val();
		});


			$.ajax({
			type : 'post',
			url : targeturl,
			data : update_data,
			complete : function() {
				$('#modalPost').removeClass('in');
				$('#modalPost').css('display', 'none');
				$('#modalThongbao').addClass('in');
				$('#modalThongbao').css('display', 'block');
			},
			success : function(response) {
				// fill data
				if(response=='1'){
					// reload lai page
					$('#modalThongbaoContent').html('Thêm mới thành công ');
					$('#modalThongbao').delay(2000).show(0);
					location.reload();
				}
				else 
					$('#modalThongbaoContent').html('Thêm mới không thành công ');
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, thêm mới không thành công');
			}
		});
	});
	/**
	 * ajax hien thi Popup them moi post
	 * 
	 */
	$(document).on('click','#btnNewPost',function() {
		var post_id = $(this).parent().attr('post_id');
		var targeturl = base_url + '/FBPosts/add';
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				// fill data
				$('#modalPostBody').html(response);
				$('#modalPost').addClass('in');
				$('#modalPost').css('display', 'block');
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, thêm mới được post');
				// hien thi modal
				$('#modalThongbao').addClass('in');
				$('#modalThongbao').css('display', 'block');
			}
		});
	});
});