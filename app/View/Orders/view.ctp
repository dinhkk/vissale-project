<?php
    echo $this->Html->script(array(
        '/js/orders',
    ));
    echo $this->Html->css(array('/css/chat','/css/AdminLTE.min'));
    ?>
 <div class="row" id="orderdetail" order_id="<?php echo h($order['Orders']['id']); ?>">
	<div class="col-md-4">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Thông tin khách hàng</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body form form-horizontal">
				<div class="form-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Mã</label>
                        <div class="col-md-6">
                        <input disabled type="text" value="<?php echo h($order['Orders']['code']); ?>" class="form-control spinner">
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">Mã vận đơn</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
		                        <input type="text" id="postal_code" class="form-control" placeholder="Mã bưu điện" value="<?php echo h($order['Orders']['postal_code']); ?>">
		                        <span class="input-group-btn">
		                            <button class="btn blue" type="button">Xem</button>
		                        </span>
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Tên KH</label>
                        <div class="col-md-6">
                        <input type="text" id="customer_name" class="form-control spinner" placeholder="Tên khách hàng" value="<?php echo h($order['Orders']['customer_name']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">SĐT</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
		                        <input id="mobile" type="text" class="form-control" value="<?php echo h($order['Orders']['mobile']); ?>">
		                        <span class="input-group-btn">
		                            <button class="btn blue" type="button">Gọi</button>
		                        </span>
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Địa chỉ</label>
                        <div class="col-md-6">
                        <input id="address" type="text" class="form-control spinner" value="<?php echo h($order['Orders']['address']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">Tỉnh/TP</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
		                        <input id="city" type="text" class="form-control" value="<?php echo h($order['Orders']['city']); ?>">
		                        <!-- <span class="input-group-btn">
		                            <button class="btn blue" type="button">...</button>
		                        </span> -->
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Ghi chú 1</label>
                        <div class="col-md-6">
                        <input id="note1" type="text" class="form-control spinner" value="<?php echo h($order['Orders']['note1']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Ghi chú 2</label>
                        <div class="col-md-6">
                        <input id="note2" type="text" class="form-control spinner" value="<?php echo h($order['Orders']['note2']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Lý do huỷ</label>
                        <div class="col-md-6">
                        <input id="cancel_note" type="text" class="form-control spinner" value="<?php echo h($order['Orders']['cancel_note']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">GC giao hàng</label>
                        <div class="col-md-6">
                        <input id="shipping_note" type="text" class="form-control spinner" value="<?php echo h($order['Orders']['shipping_note']); ?>">
                        </div>
                    </div>
                </div>
			</div>
			<div class="portlet-title">
				<div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green" id="btnOrderHistory">Lịch sử đơn hàng</button>
                </div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
	<div class="col-md-4">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Thông tin đơn hàng</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body">
				<!-- start -->
				<div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			            <div class="md-checkbox">
			                <input type="checkbox" id="is_top_priority" name="seach_viettel" class="md-check" <?php if($order['Orders']['is_top_priority']){echo 'checked=""';} ?> >
			                <label for="is_top_priority">
			                    <span></span>
			                    <span class="check"></span>
			                    <span class="box"></span> Ưu tiên </label>
			            </div>
			            <div class="md-checkbox">
			                <input type="checkbox" id="is_send_sms" name="search_mobi" class="md-check" <?php if($order['Orders']['is_send_sms']){echo 'checked=""';} ?>>
			                <label for="is_send_sms">
			                    <span></span>
			                    <span class="check"></span>
			                    <span class="box"></span> Đã SMS </label>
			            </div>
			            <div class="md-checkbox">
			                <input type="checkbox" id="is_inner_city" name="seach_vnm" class="md-check" <?php if($order['Orders']['is_inner_city']){echo 'checked=""';} ?>>
			                <label for="is_inner_city">
			                    <span></span>
			                    <span class="check"></span>
			                    <span class="box"></span> Nội thành </label>
			            </div>
			        </div>
			    </div>
			    <!-- end -->
			    <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span> Trạng thái </label>
		              	<select class="form-control" name="status_id" disabled>
		              		<option value="<?php echo $order['Statuses']['id']; ?>"><?php echo $order['Statuses']['name']; ?></option>
		                </select>
	            	</div>
			    </div>
			    <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span> Giao hàng </label>
		              	<select class="form-control" id="shipping_service_id">
		              		<option value="0">--- Giao hàng ---</option>
		              		<?php foreach($shipping_services as $id => $ship) { ?>
	                    		<option value="<?php echo $id; ?>" <?php if($id==$order['ShippingServices']['id']) echo 'selected=""'; ?>><?php echo $ship; ?></option>
	                    	<?php } ?>
		                </select>
	            	</div>
			    </div>
			    <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span> Phân loại </label>
		              	<select class="form-control" id="bundle_id">
		              		<option value="0">--- Phân loại ---</option>
		              		<?php foreach($bundles as $id => $bundle) { ?>
	                    		<option value="<?php echo $id; ?>" <?php if($id==$order['Orders']['bundle_id']) echo 'selected=""'; ?>><?php echo $bundle; ?></option>
	                    	<?php } ?>
		                </select>
	            	</div>
			    </div>

				<?php if(
					!empty($order['FBPosts']['post_id']) &&
					!empty($order['FBPostComments']['comment_id'])
				) { ?>
			    <div class="clearfix form-group">
                    <a class="btn btn-link" href="<?php echo $order['FBCustomers']['fb_id']?"http://facebook.com/{$order['FBCustomers']['fb_id']}":'#'; ?>"><?php echo $order['FBCustomers']['fb_name']; ?></a>
                    <a class="btn btn-link" href="<?php echo $order['FBPosts']['post_id']?"http://facebook.com/{$order['FBPosts']['post_id']}":'#'; ?>">Link post</a>
                    <a class="btn btn-link" href="<?php echo $order['FBPostComments']['comment_id']?"http://facebook.com/{$order['FBPostComments']['comment_id']}":'#'; ?>">Comment</a>
                </div>
				<?php } ?>

			    <div class="form-group form-md-checkboxes">
				    <div class="input-group input-medium">
	                    <input disabled type="text" class="form-control" value="<?php echo $order['Orders']['mobile']; ?>">

						<?php
							if(!empty($order['FBCustomers']) &&
							!empty($order['FBPostComments']) &&
							!empty($page['FBPage'])
						) { ?>
							<span class="input-group-btn">
								<button customer_name="<?php echo $order['FBCustomers']['fb_name']; ?>"
										page_id="<?php echo $page['FBPage']['page_id']; ?>"
										fb_user_id="<?php echo $order['FBCustomers']['fb_id']; ?>"
										page_name="<?php echo $page['FBPage']['page_name']; ?>"
										comment_id="<?php echo $order['FBPostComments']['comment_id']; ?>"
										class="btn blue" <?php if(!$order['FBPostComments']['comment_id']) echo 'disabled'; ?>
										type="button" id="btnQuickChat">Chat reply</button>
							</span>
						<?php } ?>

	                </div>
                </div>
                <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
						<label for="status_id"><span class="box"></span> Trạng thái </label>
		              	<select class="form-control" id="status_id">
		              		<option value="0">--- Trạng thái ---</option>
		              		<?php foreach($statuses as $id => $status) { ?>
	                    		<option value="<?php echo $id; ?>" <?php if($id==$order['Statuses']['id']) echo 'selected=""'; ?>><?php echo $status; ?></option>
	                    	<?php } ?>
		                </select>
	            	</div>
			    </div>
			    <div class="clearfix form-group">
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    <button type="button" class="btn btn-primary" id="btnXacnhan" <?php if($order['Statuses']['id']==7) echo 'disabled'; ?> value="7">Xác nhận</button>
                    <!-- Indicates a successful or positive action -->
                    <button type="button" class="btn btn-success" id="btnThanhcong" <?php if($order['Statuses']['id']==5) echo 'disabled'; ?> value="5">Thành công</button>
                    <!-- Contextual button for informational alert messages -->
                    <button type="button" class="btn btn-info" id="btnChuyenhang" <?php if($order['Statuses']['id']==8) echo 'disabled'; ?> value="8">Chuyển hàng</button>
                </div>
                <div class="clearfix form-group">
                    <!-- Indicates caution should be taken with this action -->
                    <button type="button" class="btn btn-warning" id="btnHoan" <?php if($order['Statuses']['id']==6) echo 'disabled'; ?> value="6">Chuyển hoàn</button>
                    <!-- Indicates a dangerous or potentially negative action -->
                    <button type="button" class="btn btn-danger" id="btnHuy" <?php if($order['Statuses']['id']==9) echo 'disabled'; ?> value="9">Huỷ</button>
                    <!-- Deemphasize a button by making it look like a link while maintaining button behavior -->
                </div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
	<div class="col-md-4">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Chi phí</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body form form-horizontal">
				<div class="form-body">
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Thành tiền</label>
	                    <div class="col-md-6">
	                    <input disabled type="text" id="price" class="form-control spinner" value="<?php echo $order['Orders']['price'] ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Giảm giá</label>
	                    <div class="col-md-6">
	                    <input type="text" id="discount_price" class="form-control spinner" value="<?php echo $order['Orders']['discount_price'] ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Phí vận chuyển</label>
	                    <div class="col-md-6">
	                    <input type="text" id="shipping_price" class="form-control spinner" value="<?php echo $order['Orders']['shipping_price'] ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Phụ thu</label>
	                    <div class="col-md-6">
	                    <input type="text" id="other_price" class="form-control spinner" value="<?php echo $order['Orders']['other_price'] ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Tổng tiền</label>
	                    <div class="col-md-6">
	                    <input id="total_price" disabled type="text" class="form-control spinner" value="<?php echo $order['Orders']['total_price'] ?>">
	                    </div>
	                </div>
                </div>
			</div>
			<div class="portlet-title">
				<div class="col-md-offset-2 col-md-10">
                    <button type="button" class="btn btn-primary" id="btnOrderUpdate">Cập nhật Đơn</button>
                    <button type="button" class="btn btn-danger" id="btnListOrders">Danh sách Đơn</button>
                </div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- modal list product -->
<div id="modal_list_production" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="btn_list_production_close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Danh sách sản phẩm</h4>
            </div>
            <div class="modal-body" id="list_product">
                
            </div>
        </div>
    </div>
</div>
<!-- end modal list product -->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i> <span
						class="caption-subject bold uppercase">Danh sách mặt hàng</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body">
				<div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
					<div class="row">
						<div class="col-md-12">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Sản phẩm</label>
										<div class="col-md-9">
											<input type="text" class="form-control" prd_id="" prd_code="" id ="add_prd_name" prd_price="0" prd_color="" prd_size="">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Số lượng</label>
										<div class="col-md-9">
											<input type="text" class="form-control" id ="add_prd_sl">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Giá</label>
										<div class="col-md-9">
											<input type="text" class="form-control" disabled id ="add_prd_price">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Kho</label>
										<div class="col-md-9">
											<input type="text" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button type="button" class="btn btn-primary" disabled id="btn_add_product">Thêm</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12" id="ajax">
						</div>
					</div>
					<div class="table-scrollable">
						<table
							class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed"
							width="100%" id="tb_orderproducts" role="grid" is_changed="0"
							aria-describedby="sample_1_info" style="width: 100%;">
							<thead>
								<tr role="row">
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">STT</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Code</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Tên SP</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Màu</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Size</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Số lượng</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Đơn giá</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
										rowspan="1" colspan="1" style="width: auto;">Thành tiền</th>
									<th class="all sorting_asc" tabindex="0" aria-controls="sample_1"
									rowspan="1" colspan="1" style="width: auto;"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($order['Product'] as $i => $prd) { ?>
								<tr role="row" class="odd" prd_id="<?php echo $prd['id']; ?>">
									<td><?php echo $i+1; ?></td>
									<td><?php echo $prd['code']; ?></td>
									<td><?php echo $prd['name']; ?></td>
									<td><?php echo $prd['color']; ?></td>
									<td><?php echo $prd['size']; ?></td>
									<td><?php echo $prd['OrdersProduct']['qty']; ?></td>
									<td><?php echo $prd['price']; ?></td>
									<td class="total_price"><?php echo intval($prd['price'])*intval($prd['OrdersProduct']['qty']); ?></td>
									<td><button type="button" class="btn btn-danger btnProductRemove" value="<?php echo $prd['id']; ?>">Xoá</button></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-5 col-sm-12">
						</div>
						<div class="col-md-7 col-sm-12">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
<!-- Modal thong bao -->
<div class="modal fade" id="modalThongbao" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông báo</h4>
            </div>
            <div class="modal-body" id="modalThongbaoContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" id="modalThongbaoClose" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- modal lich su don hang -->
<div id="modalOrderHistory" class="modal fade" tabindex="-1"
	aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="modalOrderHistoryClose"
					data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Lịch sử đơn hàng</h4>
			</div>
			<div class="modal-body" id="orderHistoryContent">
			</div>
		</div>
	</div>
</div>
<!-- end -->
<!-- modal quick chat -->
<div id="modalQuickChat" class="modal fade" tabindex="-1"
	aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="modalQuickChatClose"
					data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Chat</h4>
			</div>
			<div class="modal-body" id="quickChatContent">
			</div>
		</div>
	</div>
</div>
<!-- end -->