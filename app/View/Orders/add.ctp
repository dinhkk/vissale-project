<div class="row">
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
                        <input disabled type="text" value="" class="form-control spinner">
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">Mã vận đơn</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
		                        <input type="text" class="form-control" placeholder="Mã bưu điện" value="">
		                        <span class="input-group-btn">
		                            <button class="btn blue" type="button">Xem</button>
		                        </span>
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Tên KH</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control spinner" placeholder="Tên khách hàng" value="">
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">SĐT</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
		                        <input type="text" class="form-control" value="">
		                        <span class="input-group-btn">
		                            <button class="btn blue" type="button">Gọi</button>
		                        </span>
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Địa chỉ</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control spinner" value="">
                        </div>
                    </div>
                    <div class="form-group">
	                    <label class="col-md-4 control-label">Tỉnh/TP</label>
	                    <div class="col-md-6">
	                    	<div class="input-group input-medium">
		                        <input type="text" class="form-control" value="">
		                        <span class="input-group-btn">
		                            <button class="btn blue" type="button">...</button>
		                        </span>
	                        </div>
	                    </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Ghi chú 1</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control spinner" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Ghi chú 2</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control spinner" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Lý do huỷ</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control spinner" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">GC giao hàng</label>
                        <div class="col-md-6">
                        <input type="text" class="form-control spinner" value="">
                        </div>
                    </div>
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
			                <input type="checkbox" id="seach_viettel" name="seach_viettel" class="md-check">
			                <label for="seach_viettel">
			                    <span></span>
			                    <span class="check"></span>
			                    <span class="box"></span> Ưu tiên </label>
			            </div>
			            <div class="md-checkbox">
			                <input type="checkbox" id="search_mobi" name="search_mobi" class="md-check">
			                <label for="search_mobi">
			                    <span></span>
			                    <span class="check"></span>
			                    <span class="box"></span> Đã SMS </label>
			            </div>
			            <div class="md-checkbox">
			                <input type="checkbox" id="seach_vnm" name="seach_vnm" class="md-check">
			                <label for="seach_vnm">
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
		              	<select class="form-control" name="search_nhanvien" disabled>
		              		<option value="<?php echo $default_status['id']; ?>"><?php echo $default_status['name']; ?></option>
		                </select>
	            	</div>
			    </div>
			    <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span> Giao hàng </label>
		              	<select class="form-control" name="search_nhanvien">
		              		<option value="0">--- Giao hàng ---</option>
		              		<?php foreach($shipping_services as $ship) { ?>
	                    		<option value="<?php echo $ship['ShippingServices']['id']; ?>"><?php echo $ship['ShippingServices']['name']; ?></option>
	                    	<?php } ?>
		                </select>
	            	</div>
			    </div>
			    <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span> Phân loại </label>
		              	<select class="form-control" name="search_nhanvien">
		              		<option value="0">--- Phân loại ---</option>
		              		<?php foreach($bundles as $bundle) { ?>
	                    		<option value="<?php echo $bundle['Bundles']['id']; ?>"><?php echo $bundle['Bundles']['name']; ?></option>
	                    	<?php } ?>
		                </select>
	            	</div>
			    </div>
                <div class="form-group form-md-checkboxes">
			        <div class="md-checkbox-inline">
			        	<span class="box"></span> Trạng thái </label>
		              	<select class="form-control" name="search_nhanvien">
		              		<option value="0">--- Trạng thái ---</option>
		              		<?php foreach($statuses as $status) { ?>
	                    		<option value="<?php echo $status['Statuses']['id']; ?>"><?php echo $status['Statuses']['name']; ?></option>
	                    	<?php } ?>
		                </select>
	            	</div>
			    </div>
			    <div class="clearfix form-group">
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    <button type="button" class="btn btn-primary">Xác nhận</button>
                    <!-- Indicates a successful or positive action -->
                    <button type="button" class="btn btn-success">Thành công</button>
                    <!-- Contextual button for informational alert messages -->
                    <button type="button" class="btn btn-info">Chuyển hàng</button>
                </div>
                <div class="clearfix form-group">
                    <!-- Indicates caution should be taken with this action -->
                    <button type="button" class="btn btn-warning">Hoàn</button>
                    <!-- Indicates a dangerous or potentially negative action -->
                    <button type="button" class="btn btn-danger">Huỷ</button>
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
	                    <input type="text" class="form-control spinner" value="">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Giảm giá</label>
	                    <div class="col-md-6">
	                    <input type="text" class="form-control spinner" value="">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Phí vận chuyển</label>
	                    <div class="col-md-6">
	                    <input type="text" class="form-control spinner" value="">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Phụ thu</label>
	                    <div class="col-md-6">
	                    <input type="text" class="form-control spinner" value="">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-md-4 control-label">Tổng tiền</label>
	                    <div class="col-md-6">
	                    <input disabled type="text" class="form-control spinner" value="">
	                    </div>
	                </div>
                </div>
			</div>
			<div class="portlet-title">
				<div class="col-md-offset-3 col-md-9">
                    <button type="button" class="btn btn-primary">Xác nhận</button>
                    <button type="button" class="btn btn-danger">Huỷ</button>
                </div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
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
											<input type="text" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Số lượng</label>
										<div class="col-md-9">
											<input type="text" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label class="control-label col-md-3">Giá</label>
										<div class="col-md-9">
											<input type="text" class="form-control">
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
										<button type="button" class="btn btn-primary">Thêm</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
						</div>
					</div>
					<div class="table-scrollable">
						<table
							class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed"
							width="100%" id="sample_1" role="grid"
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
								</tr>
							</thead>
							<tbody>
								<tr role="row" class="odd">
									<td columnspan="8">Không có sản phẩm</td>
								</tr>
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