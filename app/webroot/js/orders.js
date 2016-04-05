$(function() {
	// ajax lay danh sach san pham
	/**
	 * ajax lay danh sach san pham
	 */
	$('#add_prd_name').focus(function() {
		//var myDir = myURL.substring( 0, window.location.href.lastIndexOf( ''/' ) + 1);
		var targeturl = 'http://fbsale.dinhkk.com/Orders/ajax_listproduct';
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
				response = 'Có lỗi xảy ra, không lấy được sản phẩm';
				$('#list_product').html(response);
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
		var targeturl = 'http://fbsale.dinhkk.com/Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không Xác nhận được đơn hàng');
				}
				// fill data
				$('#modalThongbaoContent').html('Xác nhận hành công');
				$('#btnXacnhan').prop('disabled', true);
				$('#status_id').val(2).change();
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không Xác nhận được đơn hàng');
			}
		});
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
	});
	$('#btnThanhcong').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnThanhcong').attr('value');
		var targeturl = 'http://fbsale.dinhkk.com/Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không lấy cập nhât được trạng thái');
				}
				// fill data
				$('#modalThongbaoContent').html('Thành công');
				$('#btnThanhcong').prop('disabled', true);
				$('#status_id').val(3).change();
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không lấy cập nhât được trạng thái');
			}
		});
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
	});
	$('#btnChuyenhang').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnChuyenhang').attr('value');
		var targeturl = 'http://fbsale.dinhkk.com/Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không lấy cập nhât được trạng thái');
				}
				// fill data
				$('#modalThongbaoContent').html('Chuyển trạng thái Chuyển hàng thành công');
				$('#btnChuyenhang').prop('disabled', true);
				$('#status_id').val(4).change();
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không lấy cập nhât được trạng thái');
			}
		});
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
	});
	$('#btnHoan').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnHoan').attr('value');
		var targeturl = 'http://fbsale.dinhkk.com/Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không hoàn được đơn hàng');
				}
				// fill data
				$('#modalThongbaoContent').html('Hoàn thành công');
				$('#btnHoan').prop('disabled', true);
				$('#status_id').val(5).change();
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không hoàn được đơn hàng');
			}
		});
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
	});
	$('#btnHuy').on('click',function() {
		var order_id= $('#orderdetail').attr('order_id');
		var status = $('#btnHuy').attr('value');
		var targeturl = 'http://fbsale.dinhkk.com/Orders/setStatus/?status=' +status+'&order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không huỷ được đơn hàng');
				}
				// fill data
				$('#modalThongbaoContent').html('Huỷ thành công');
				$('#btnHuy').prop('disabled', true);
				$('#status_id').val(6).change();
			},
			error : function(e) {
				response = 'Có lỗi xảy ra, không huỷ được đơn hàng';
			}
		});
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
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
		var targeturl = 'http://fbsale.dinhkk.com/Orders/update';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : post_data,
			success : function(response) {
				if (response != 1) {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không cập nhật được đơn hàng');
				}
				// fill data
				$('#modalThongbaoContent').html('Cập nhật thành công');
				$('#tb_orderproducts').attr('is_changed',1)
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không cập nhật được đơn hàng');
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
		var post_data = {postal_code:postal_code,customer_name:customer_name,mobile:mobile,address:address,city:city,note1:note1,note2:note2,cancel_note:cancel_note,
				shipping_note:shipping_note,is_top_priority:is_top_priority,shipping_service_id:shipping_service_id,is_send_sms:is_send_sms,is_inner_city:is_inner_city,bundle_id:bundle_id,
				status_id:status_id,discount_price:discount_price,shipping_price:shipping_price,other_price:other_price,total_price:total_price,order_product:order_product,price:price};
		var targeturl = 'http://fbsale.dinhkk.com/Orders/addOrder';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : post_data,
			success : function(response) {
				if (response != 1) {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không tạo được đơn hàng');
				}
				// fill data
				$('#modalThongbaoContent').html('Tạo đơn hàng thành công');
				$('#tb_orderproducts').attr('is_changed',1);
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không tạo được đơn hàng');
			}
		});
		$('#btnOrderAdd').prop('disabled', true);
		// hien thi modal
		$('#modalThongbao').addClass('in');
		$('#modalThongbao').css('display', 'block');
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
				seach_shipping_service_id = $(this).attr('id').replace('search_ship_','');;
		});
		//var search_status_id = $('#search_status_id').val();
		var search_status_id = '';
		$('input[input-type="status"]').each(function() {
			if(search_status_id != '')
				search_status_id += ',' + $(this).attr('id').replace('search_stt_','');
			else
				search_status_id = $(this).attr('id').replace('search_stt_','');
		});
		var seach_viettel = $('#is_inner_city').prop('checked')?1:0;
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
				search_chuyen_from:search_chuyen_from,search_chuyen_to:search_chuyen_to,seach_shipping_service_id:seach_shipping_service_id,search_status_id:search_status_id,
				seach_viettel:seach_viettel,search_mobi:search_mobi,seach_vnm:seach_vnm,seach_vina:seach_vina,seach_sphone:seach_sphone,seach_gmobile:seach_gmobile,search_noithanh:search_noithanh,seach_bundle_id:seach_bundle_id,seach_user_id:seach_user_id};
		var targeturl = 'http://fbsale.dinhkk.com/Orders/search';
		$.ajax({
			type : 'post',
			url : targeturl,
			data : post_data,
			success : function(response) {
				$('#listOrder').html(response);
			},
			error : function(e) {
				$('#modalThongbao').addClass('in');
				$('#modalThongbao').css('display', 'block');
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không tạo được đơn hàng');
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
		var targeturl = 'http://fbsale.dinhkk.com/Orders/history/?order_id='+order_id;
		$.ajax({
			type : 'get',
			url : targeturl,
			success : function(response) {
				if (!response) {
					$('#modalThongbaoContent').html('Có lỗi xảy ra, không lấy lịch sử');
				}
				// fill data
				$('#orderHistoryContent').html(response);
				$('#modalOrderHistory').addClass('in');
				$('#modalOrderHistory').css('display', 'block');
			},
			error : function(e) {
				$('#modalThongbaoContent').html('Có lỗi xảy ra, không lấy lịch sử');
			}
		});
	});
	$('#modalOrderHistoryClose').on('click', function() {
		// click vao nut close se an modal
		$('#modalOrderHistory').removeClass('in');
		$('#modalOrderHistory').css('display', 'none');
	});
});
function setOrderPrice(){
	var order_price = 0;
	$('.total_price').each(function() {
		order_price += parseInt($(this).text());
	});
	$('#price').val(order_price);
	var total_price = order_price - parseInt($('#discount_price').val()) + parseInt($('#shipping_price').val()) + parseInt($('#other_price').val());
	$('#total_price').val(total_price);
}