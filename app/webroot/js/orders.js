$(function() {
	var parent_url = base_url;
	// ajax lay danh sach san pham
	/**
	 * ajax lay danh sach san pham
	 */
	$('#add_prd_name').focus(function() {
		//var myDir = myURL.substring( 0, window.location.href.lastIndexOf( ''/' ) + 1);
		var targeturl = parent_url+'Orders/ajax_listproduct';
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					response = 'Không có sản phẩm';
				}
				// fill data
				$('#list_product').html(response);
			},
			error : function(e) {
				$('#list_product').html('Có lỗi xảy ra, không lấy được sản phẩm');
			}
		});
		// hien thi modal
		$('#modal_list_production').addClass('in');
		$('#modal_list_production').css('display', 'block');
	});
	/**
	 * Dong modal danh sach san pham
	 */
	$('#btn_list_production_close').on('click', function() {
		// click vao nut close se an modal
		$('#modal_list_production').removeClass('in');
		$('#modal_list_production').css('display', 'none');
	});
	/**
	 * Click chon 1 product trong list
	 */
	$(document).on('click', '#tb_listproduct tbody tr', function() {
		var data = $(this).find('td').map(function() {
			return $(this).text();
		});
		var prd_id = $(this).attr('prd_id');
		$('#add_prd_name').attr('prd_id', prd_id);
		$('#add_prd_name').attr('prd_color', data[3]);
		$('#add_prd_name').attr('prd_size', data[4]);
		$('#add_prd_name').attr('value', data[1]);
		$('#add_prd_sl').attr('value', 1);
		$('#add_prd_price').attr('value', data[2]);
		$('#add_prd_name').attr('prd_code',data[0]);
		$('#modal_list_production').removeClass('in');
		$('#modal_list_production').css('display', 'none');
		$('#btn_add_product').removeAttr('disabled');
	});

	/**
	 * Them san pham vao don hang
	 */
	$('#btn_add_product').on(
			'click',
			function() {
				// lay thong tin san pham
				var add_prd_id = $('#add_prd_name').attr('prd_id');
				var add_sl = $('#add_prd_sl').val();
				var add_color = $('#add_prd_name').attr('prd_color');
				var add_size = $('#add_prd_name').attr('prd_size');
				var add_prd_data = add_prd_id + '_' + add_size + '_' + add_color;
				// lay danh sach product da co de check xem co trung san pham
				// hay khong
				var is_duplicate = false;
				$('#tb_orderproducts tbody tr').each(function() {
					var data = $(this).find('td').map(function() {
				        return $(this).text();
				    });
					var prd_data = $(this).attr('prd_id')  + '_' +  data[4]  + '_' +  data[3];
					if (prd_data == add_prd_data) {
						// trung san pham, san pham da co
						is_duplicate = true;
						var curr_sl = data[5];
						var new_sl = parseInt(curr_sl)+parseInt(add_sl);
						var old_total = parseInt(data[7]);
						var new_total = add_sl * parseInt($('#add_prd_price').val()) + old_total;
						$(this).find('td').eq(5).html(new_sl);
						$(this).find('td').eq(7).html(new_total);
						$('#tb_orderproducts').attr('is_changed',1);
						return false;
					}
				});
				if (!is_duplicate) {
					var add_prd_code = $('#add_prd_name').attr('prd_code');
					var add_prd_name = $('#add_prd_name').val();
					var add_prd_price = $('#add_prd_price').val();
					var total_price = parseInt(add_prd_price) * parseInt(add_sl);
					// so item da co
					var stt = $('#tb_orderproducts tbody tr').length + 1;
					// khong co su trung => add moi
					var prd_detail = '<tr role="row" class="odd" prd_id="' + add_prd_id + '"><td>' + stt
							+ '</td><td>' + add_prd_code + '</td><td>' + add_prd_name
							+ '</td><td>' + add_color + '</td><td>' + add_size
							+ '</td><td>' + add_sl + '</td><td>' + add_prd_price + '</td><td class="total_price">'
							+ total_price + '</td><td><button type="button" class="btn btn-danger btnProductRemove" value="'+add_prd_id+'">Xoá</button></td></tr>';
					$('#tb_orderproducts > tbody:last-child')
							.append(prd_detail);
					$('#tb_orderproducts').attr('is_changed',1);
				}
				// reset data tren
				$('#add_prd_name').attr('prd_id','');
				$('#add_prd_name').attr('value','');
				$('#add_prd_sl').attr('value','');
				$('#add_prd_price').attr('value','');
				$('#add_prd_name').attr('prd_color','');
				$('#add_prd_name').attr('prd_code','');
				$('#add_prd_name').attr('prd_size','');
				$('#btn_add_product').prop('disabled', true);
				setOrderPrice();
				// thay doi thong tin gia cho don hang
				
			});
	/**
	 * Thay doi trang thai don hang
	 */
	$('#btnXacnhan').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnXacnhan').attr('value');
		var targeturl = parent_url+'Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					showThongBao('Có lỗi xảy ra, không Xác nhận được đơn hàng');
				}
				// fill data
				showThongBao('Xác nhận hành công');
				$('#btnXacnhan').prop('disabled', true);
				$('#status_id').val(status).change();
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không Xác nhận được đơn hàng');
			}
		});
	});
	$('#btnThanhcong').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnThanhcong').attr('value');
		var targeturl = parent_url+'Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					showThongBao('Có lỗi xảy ra, không lấy cập nhât được trạng thái');
				}
				// fill data
				showThongBao('Thành công');
				$('#btnThanhcong').prop('disabled', true);
				$('#status_id').val(status).change();
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không lấy cập nhât được trạng thái');
			}
		});
	});
	$('#btnChuyenhang').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnChuyenhang').attr('value');
		var targeturl = parent_url+'Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					showThongBao('Có lỗi xảy ra, không lấy cập nhât được trạng thái');
				}
				// fill data
				showThongBao('Chuyển trạng thái Chuyển hàng thành công');
				$('#btnChuyenhang').prop('disabled', true);
				$('#status_id').val(4).change();
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không lấy cập nhât được trạng thái');
			}
		});
	});
	$('#btnHoan').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnHoan').attr('value');
		var targeturl = parent_url+'Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					showThongBao('Có lỗi xảy ra, không hoàn được đơn hàng');
				}
				// fill data
				showThongBao('Hoàn thành công');
				$('#btnHoan').prop('disabled', true);
				$('#status_id').val(5).change();
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không hoàn được đơn hàng');
			}
		});
	});
	$('#btnHuy').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnHuy').attr('value');
		var targeturl = parent_url+'Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					showThongBao('Có lỗi xảy ra, không huỷ được đơn hàng');
				}
				// fill data
				showThongBao('Huỷ thành công');
				$('#btnHuy').prop('disabled', true);
				$('#status_id').val(6).change();
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không huỷ được đơn hàng');
			}
		});
	});


	$('#btnOrderUpdate').on('click',function() {
		var post_data = '';
		var order_id= $('#orderdetail').attr('order_id');
		var postal_code = $('#postal_code').val();
		var customer_name = $('#customer_name').val();
		var mobile = $('#mobile').val();
		var address = $('#address').val();
		var city = $('#city').val();
		var note1 = $('#note1').val();
		var note2 = $('#note2').val();
		var cancel_note = $('#cancel_note').val();
		var shipping_note = $('#shipping_note').val();
		var is_top_priority = $('#is_top_priority').prop('checked')?1:0;
		var shipping_service_id = $('#shipping_service_id').val();
		var is_send_sms = $('#is_send_sms').prop('checked')?1:0;
		var is_inner_city = $('#is_inner_city').prop('checked')?1:0;
		var bundle_id = $('#bundle_id').val();
		var status_id = $('#status_id').val();
		var discount_price = $('#discount_price').val();
		var shipping_price = $('#shipping_price').val();
		var other_price = $('#other_price').val();
		var total_price = $('#total_price').val();
		var price = $('#price').val();
		// lay danh sach san pham trong order
		if($('#tb_orderproducts').attr('is_changed') != '0') {
			var order_product = '';
			$('#tb_orderproducts tbody tr').each(function() {
				var data = $(this).find('td').map(function() {
			        return $(this).text();
			    });
				var op = $(this).attr('prd_id') + '_' + data[5];
				if(order_product != '')
					order_product += ',' + op;
				else
					order_product = op;
			});
		}
		else
			order_product = -1; // khong thay doi j
		var post_data = {order_id:order_id,postal_code:postal_code,customer_name:customer_name,mobile:mobile,address:address,city:city,note1:note1,note2:note2,cancel_note:cancel_note,
				shipping_note:shipping_note,is_top_priority:is_top_priority,shipping_service_id:shipping_service_id,is_send_sms:is_send_sms,is_inner_city:is_inner_city,bundle_id:bundle_id,
				status_id:status_id,discount_price:discount_price,shipping_price:shipping_price,other_price:other_price,total_price:total_price,order_product:order_product,price:price};
		var targeturl = parent_url+'Orders/update';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : post_data,
			success : function(response) {
				if (response != 1) {
					showThongBao('Có lỗi xảy ra, không cập nhật được đơn hàng');
				}
				else {
					// fill data
					showThongBao('Cập nhật thành công');
					$('#tb_orderproducts').attr('is_changed',1)
				}
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không cập nhật được đơn hàng');
			}
		});
	});

	$("#btnListOrders").click(function () {
		window.location.assign("/Orders");
	});

	$('#modalThongbaoClose').on('click', function() {
		// click vao nut close se an modal
		$('#modalThongbao').removeClass('in');
		$('#modalThongbao').css('display', 'none');

		reloadPage();
	});
	
	$('#btnOrderAdd').on('click',function() {
		var post_data = '';
		var postal_code = $('#postal_code').val();
		var customer_name = $('#customer_name').val();
		var mobile = $('#mobile').val();
		var address = $('#address').val();
		var city = $('#city').val();
		var note1 = $('#note1').val();
		var note2 = $('#note2').val();
		var cancel_note = $('#cancel_note').val();
		var shipping_note = $('#shipping_note').val();
		var is_top_priority = $('#is_top_priority').prop('checked')?1:0;
		var shipping_service_id = $('#shipping_service_id').val();
		var is_send_sms = $('#is_send_sms').prop('checked')?1:0;
		var is_inner_city = $('#is_inner_city').prop('checked')?1:0;
		var bundle_id = $('#bundle_id').val();
		var status_id = $('#status_id').val();
		var discount_price = $('#discount_price').val();
		var shipping_price = $('#shipping_price').val();
		var other_price = $('#other_price').val();
		var total_price = $('#total_price').val();
		var price = $('#price').val();
		// lay danh sach san pham trong order
		if($('#tb_orderproducts').attr('is_changed') != '0') {
			var order_product = '';
			$('#tb_orderproducts tbody tr').each(function() {
				var data = $(this).find('td').map(function() {
			        return $(this).text();
			    });
				var op = $(this).attr('prd_id') + '_' + data[5];
				if(order_product != '')
					order_product += ',' + op;
				else
					order_product = op;
			});
		}
		else
			order_product = -1; // khong thay doi j
		//$order_product = $this->request->query ['order_product'];
		post_data = {postal_code:postal_code,customer_name:customer_name,mobile:mobile,address:address,city:city,note1:note1,note2:note2,cancel_note:cancel_note,
				shipping_note:shipping_note,is_top_priority:is_top_priority,shipping_service_id:shipping_service_id,is_send_sms:is_send_sms,is_inner_city:is_inner_city,bundle_id:bundle_id,
				status_id:status_id,discount_price:discount_price,shipping_price:shipping_price,other_price:other_price,total_price:total_price,order_product:order_product,price:price};
		var targeturl = parent_url+'Orders/addOrder';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : post_data,
			success : function(response) {
				if (response != 1) {
					showThongBao('Có lỗi xảy ra, không tạo được đơn hàng');
				}
				else {
					// fill data
					showThongBao('Tạo đơn hàng thành công');
					$('#tb_orderproducts').attr('is_changed',1);
				}
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không tạo được đơn hàng');
			}
		});
		$('#btnOrderAdd').prop('disabled', true);
	});
	/**
	 * Tim kiem order
	 */
	$('#btnOrderSearch').on('click',function() {
		var post_data = '';
		var search_email_phone = $('#seach_email_phone').val();
		var search_check_ngaytao = $('#search_check_ngaytao').prop('checked')?1:0;
		var search_ngaytao_from = $('#search_ngaytao_from').val();
		var search_ngaytao_to = $('#search_ngaytao_to').val();
		var search_check_xacnhan = $('#search_check_xacnhan').prop('checked')?1:0;
		var search_xacnhan_from = $('#search_xacnhan_from').val();
		var search_xacnhan_to = $('#search_xacnhan_to').val();
		var search_check_chuyen = $('#search_check_chuyen').prop('checked')?1:0;
		var search_chuyen_from = $('#search_chuyen_from').val();
		var search_chuyen_to = $('#search_chuyen_to').val();
		//var seach_shipping_service_id = $('#seach_shipping_service_id').val();
		var seach_shipping_service_id = '';
		$('input[input-type="shipping"]').each(function() {
			if(seach_shipping_service_id != ''){
				seach_shipping_service_id += ',' + $(this).attr('id').replace('search_ship_','');
			}
			else

				seach_shipping_service_id = $(this).attr('id').replace('search_ship_', '');
		});
		//var search_status_id = $('#search_status_id').val();
		var search_status_id = '';
		$('input[input-type="status"]').each(function() {
			if(search_status_id != '')
				search_status_id += ',' + $(this).attr('id').replace('search_stt_','');
			else
				search_status_id = $(this).attr('id').replace('search_stt_','');
		});
		var is_inner_city = $('#is_inner_city').prop('checked')?1:0;
		var seach_viettel = $('#search_viettel').prop('checked')?1:0;
		var search_mobi = $('#search_mobi').prop('checked')?1:0;
		var seach_vnm = $('#seach_vnm').prop('checked')?1:0;
		var seach_vina = $('#seach_vina').prop('checked')?1:0;
		var seach_sphone = $('#seach_sphone').prop('checked')?1:0;
		var seach_gmobile = $('#seach_gmobile').prop('checked')?1:0;
		var search_noithanh = $('#search_noithanh').prop('checked')?1:0;
		var seach_bundle_id = $('#seach_bundle_id').val();
		var seach_user_id = $('#seach_user_id').val();
		var post_data = {search_email_phone:search_email_phone,search_check_ngaytao:search_check_ngaytao,search_ngaytao_from:search_ngaytao_from,
				search_ngaytao_to:search_ngaytao_to,search_check_xacnhan:search_check_xacnhan,search_xacnhan_from:search_xacnhan_from,search_xacnhan_to:search_xacnhan_to,search_check_chuyen:search_check_chuyen,
				search_chuyen_from:search_chuyen_from,search_chuyen_to:search_chuyen_to,seach_shipping_service_id:seach_shipping_service_id,search_status_id:search_status_id,is_inner_city:is_inner_city,
				seach_viettel:seach_viettel,search_mobi:search_mobi,seach_vnm:seach_vnm,seach_vina:seach_vina,seach_sphone:seach_sphone,seach_gmobile:seach_gmobile,search_noithanh:search_noithanh,seach_bundle_id:seach_bundle_id,seach_user_id:seach_user_id};
		var targeturl = parent_url+'Orders/search';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : post_data,
			success : function(response) {
				$('#listOrder').html(response);
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không tạo được đơn hàng');
			}
		});
	});
	/**
	 * Xoa product trong order
	 */
	$(document).on('click','.btnProductRemove',function() {
//		var prd_id = $(this).attr('value');
//		alert('Xoa ' + prd_id);
//		$('tr[prd_id="'+prd_id+'"]').remove();
		$(this).parent().parent().remove();
		$('#tb_orderproducts').attr('is_changed',1);
		setOrderPrice();
	});
	$( "#discount_price").focusout(function() {
		var current_total = +$('#total_price').val();
		var add_price = +$(this).val();
		$('#total_price').val( +current_total- add_price); 
	});
	$( "#shipping_price").focusout(function() {
		var current_total = +$('#total_price').val();
		var add_price = +$(this).val();
		$('#total_price').val( +current_total+ add_price); 
	});
	$( "#other_price").focusout(function() {
		var current_total = +$('#total_price').val();
		var add_price = +$(this).val();
		$('#total_price').val( +current_total+ add_price); 
	});
	/**
	 * Popup lich su don hang
	 */
	$('#btnOrderHistory').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var targeturl = parent_url+'Orders/history/?order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					showThongBao('Có lỗi xảy ra, không lấy lịch sử');
				}
				// fill data
				$('#orderHistoryContent').html(response);
				$('#modalOrderHistory').addClass('in');
				$('#modalOrderHistory').css('display', 'block');
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không lấy lịch sử');
			}
		});
	});
	$('#modalOrderHistoryClose').on('click', function() {
		// click vao nut close se an modal
		$('#modalOrderHistory').removeClass('in');
		$('#modalOrderHistory').css('display', 'none');
	});
	// Click chon mot don hang
	$('#tblListOrder').on('click','.order_item', function() {
		var order_id = $(this).attr('data_id');
		var old_selected = $('#tblListOrder').find('.selected_order:first');
		if(old_selected === this){
			return false;
		}
		old_selected.removeClass('selected_order');
		$(this).addClass('selected_order');
		$('#tblListOrder').attr('selected_order', order_id);
	});
	$('#tblListOrder').on('dblclick','.order_item', function() {
		var order_id = $(this).attr('data_id');
		$(location).attr('href', parent_url+'Orders/view/?order_id='+order_id);
	});
	$('#btnUpdate').on('click', function() {
		gotoEdit();
	});
	$('#btnOrderView').on('click', function() {
		gotoEdit();
	});
	function gotoEdit(){
		order_id = $('#tblListOrder').attr('selected_order');
		if(order_id=='undefined' || order_id==''){
			return true;
		}
		$(location).attr('href', parent_url+'Orders/view/?order_id='+order_id);
	}
	// Chat nhanh
	$('#btnQuickChat').on('click',function() {
		var comment_id= $(this).attr('comment_id');
		var fb_user_id= $(this).attr('fb_user_id');
		var page_name= $(this).attr('page_name');
		var page_id= $(this).attr('page_id');
		var customer_name= $(this).attr('customer_name');
		var targeturl = parent_url+'Orders/quick_chat';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : {comment_id:comment_id,fb_user_id:fb_user_id,page_name:page_name,page_id:page_id,customer_name:customer_name},
			success : function(response) {
				if (response=='0') {
					showThongBao('Không tồn tại nội dung chat');
				}
				else if (response=='-1') {
					showThongBao('Có lỗi xảy ra, không lấy được nội dung chat');
				}
				else {
					// fill data
					$('#quickChatContent').html(response);
					$('#modalQuickChat').addClass('in');
					$('#modalQuickChat').css('display', 'block');
				}
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không lấy được nội dung chat');
			}
		});
	});
	$('#modalQuickChatClose').on('click', function() {
		// click vao nut close se an modal
		$('#modalQuickChat').removeClass('in');
		$('#modalQuickChat').css('display', 'none');
	});
	$(document).on('click','#btnSendMessage',function() {
		var message= $('#txtMessage').val();
		$('#txtMessage').val('');
		var conv_id= $('#listChatMessage').attr('conv_id');
		var page_name= $('#btnQuickChat').attr('page_name');
		var page_id= $('#btnQuickChat').attr('page_id');
		var targeturl = parent_url+'Orders/quick_chat_send';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : {conv_id:conv_id,message:message,page_id:page_id,page_name:page_name},
			success : function(response) {
				if(response=='0'){
					showThongBao('Có lỗi, không gửi được tin nhắn');
				}
				else {
					// fill data
					$('#listChatMessage').append(response);
				}
			},
			error : function(e) {
				showThongBao('Có lỗi, không gửi được tin nhắn');
			}
		});
	});
	//reload quick chat
	$(document).on('click','#btnRefreshMessage',function() {
		var chat_data = $('#btnQuickChat');
		var comment_id= chat_data.attr('comment_id');
		var fb_user_id= chat_data.attr('fb_user_id');
		var page_name= chat_data.attr('page_name');
		var page_id= chat_data.attr('page_id');
		var customer_name= chat_data.attr('customer_name');
		var fb_conversation_id= $('#listChatMessage').attr('conv_id');
		if(fb_conversation_id=='undefined' || fb_conversation_id==''){
			showThongBao('Không tồn tại nội dung chat');
			return true;
		}
		var customer_name= chat_data.attr('customer_name');
		var last= $('#listChatMessage').attr('last');
		var targeturl = parent_url+'Orders/quick_chat_refresh';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : {comment_id:comment_id,fb_user_id:fb_user_id,page_name:page_name,page_id:page_id,customer_name:customer_name,last:last,fb_conversation_id:fb_conversation_id},
			success : function(response) {
				if (response!='-1' && response!='0') {
					// fill data
					$('#box-body-chat').html(response);
				}
				else {
					//showThongBao('Có lỗi xảy ra, không lấy được nội dung chat');
				}
			},
			error : function(e) {
				showThongBao('Có lỗi xảy ra, không lấy được nội dung chat');
			}
		});
	});

	//add user to order
	$("#OrdersAddUserToOrder").on("change", function () {
		var selected_order = $("#tblListOrder").attr("selected_order");
		var selected_user = $(this).val();
		if ( $.isNumeric(selected_order)
			&& $.isNumeric(selected_user)
			&& selected_order > 0
			&& selected_user > 0
		) {
			addUserToOrder({order_id:selected_order,user_id:selected_user});
		}


	});


});

console.log("fbsale");

function addUserToOrder(data) {
	$.ajax({
		url: "/Orders/assignUserToOrder",
		data: data,
		method: "POST",
		dataType: "json",
		beforeSend: function( xhr ) {
		},
		success: function (data) {
			if (data.status == 1){
				window.location.assign("/Orders/index");
			}
		},
		fail: function (data) {
			alert(data)
		}
	});
}

function showThongBao(msg){
	$('#modalThongbaoContent').html(msg);
	$('#modalThongbao').addClass('in');
	$('#modalThongbao').css('display', 'block');
}
function setOrderPrice(){
	var order_price = 0;
	$('.total_price').each(function() {
		order_price += parseInt($(this).text());
	});
	$('#price').val(order_price);
	var total_price = order_price - parseInt($('#discount_price').val()) + parseInt($('#shipping_price').val()) + parseInt($('#other_price').val());
	$('#total_price').val(total_price);
}

function reloadPage() {
	window.location.reload(true);
}


