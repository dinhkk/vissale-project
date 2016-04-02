<div id="sample_3_wrapper" class="dataTables_wrapper no-footer DTS">
	<div class="row">
		<div class="col-md-12">
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-12">
		<div class="dataTables_length" id="sample_1_length">
			<label>
				<select name="sample_1_length" aria-controls="sample_1" class="form-control input-sm input-xsmall input-inline">
					<option value="10">10</option><option value="15">15</option><option value="20">20</option>
					<option value="40">40</option>
					<option value="60">60</option>
					<option value="100">100</option>
				</select> Số lượng 1 trang
			</label>
		</div>
		<div class="col-md-6 col-sm-12">
		</div>
	</div>
	<div class="table-scrollable">
		<div class="dataTables_scroll">
			<div class="dataTables_scrollBody"
				style="position: relative; overflow: auto; width: 100%; max-height: 300px;">
				<table
					class="table table-striped table-bordered table-hover order-column dataTable no-footer"
					id="sample_3" role="grid" aria-describedby="sample_3_info"
					style="width: 1800px; position: absolute; top: 0px; left: 0px;">
					<thead>
						<tr role="row" style="height: 0px;">
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('total_qty','SL'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('code','Mã'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('postal_code','Mã vận đơn'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('customer_name', 'Tên KH'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('mobile', 'SĐT'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('telco_code','Mã bưu điện'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('address','Địa chỉ'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('note1','Ghi chú'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('shipping_note','Ghi chú bưu điện'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('shipping_service_id','Hình thức giao'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('status_id','Trạng thái'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('total_price','Tổng tiền'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('duplicate_id','Trùng đơn'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('user_confirmed','NV Xác nhận'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('confirmed','Ngày XN'); ?></th>
							<th class="sorting" aria-controls="sample_3" rowspan="1"
								colspan="1"
								style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
								aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('created','Ngày tạo'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if(!count($orders)) { ?>
						<tr role="row" rowspan="16">
							Chưa có đơn hàng
						</tr>
					<?php } ?>
					<?php $odd=true; foreach($orders as $order) { ?>
						<tr role="row" class="<?php if($odd) {$odd=false;echo 'odd';} else {$odd=true;echo 'even';} ?>">
							<td style="width: 100px;"><?php echo h($order['Orders']['total_qty']); ?>&nbsp;</td>
							<td style="width: 100px;"><a href="Orders/view/?order_id=<?php echo $order['Orders']['id']; ?>"><?php echo h($order['Orders']['code']); ?>&nbsp;</a></td>
							<td style="width: 100px;"><?php echo h($order['Orders']['postal_code']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['customer_name']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['mobile']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['telco_code']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['address']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['note1']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['shipping_note']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['ShippingServices']['name']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Statuses']['name']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['total_price']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['duplicate_id']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['user_confirmed']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['confirmed']); ?>&nbsp;</td>
							<td style="width: 100px;"><?php echo h($order['Orders']['created']); ?>&nbsp;</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<div
					style="position: relative; top: 0px; left: 0px; width: 1px; height: 500px;"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5 col-sm-12"><div class="dataTables_info" id="sample_3_info" role="status" aria-live="polite"><?php echo $this->Paginator->counter('Trang {:page} / {:pages}, có {:current} / tổng {:count}'); ?></div></div>
		<div class="col-md-7 col-sm-12">
			<div class="dataTables_paginate paging_bootstrap_number" id="sample_3_paginate">
				<?php echo $this->Paginator->numbers(); ?>
			</div>
		</div>
	</div>
</div>