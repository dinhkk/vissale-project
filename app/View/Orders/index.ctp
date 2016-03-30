<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-green">
			<i class="icon-settings font-green"></i> <span
				class="caption-subject bold uppercase">Đơn hàng</span>
		</div>
		<div class="tools"></div>
	</div>
	<div class="portlet-body table-both-scroll">
		<div id="sample_3_wrapper" class="dataTables_wrapper no-footer DTS">
			<div class="row">
				<div class="col-md-12">
					<div class="dt-buttons">
						<a class="dt-button buttons-print btn dark btn-outline"
							tabindex="0" aria-controls="sample_3"><span>Print</span></a><a
							class="dt-button buttons-pdf buttons-html5 btn green btn-outline"
							tabindex="0" aria-controls="sample_3"><span>PDF</span></a><a
							class="dt-button buttons-csv buttons-html5 btn purple btn-outline"
							tabindex="0" aria-controls="sample_3"><span>CSV</span></a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-12">
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
							style="width: 1900px; position: absolute; top: 0px; left: 0px;">
							<thead>
								<tr role="row" style="height: 0px;">
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('total_qty'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('code'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('postal_code'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('customer_name'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('mobile'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('telco_code'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('address'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('note1'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('cancel_note'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('shipping_note'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('shipping_service_id'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('status_id'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('price'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('total_price'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('duplicate_id'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('user_confirmed'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('user_assigned'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('confirmed'); ?></th>
									<th class="sorting" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-label="Lastname: activate to sort column ascending"><?php echo $this->Paginator->sort('created'); ?></th>
									<th class="actions"><?php echo __('Actions'); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php $odd=true; foreach($orders as $order) { ?>
								<tr role="row" class="<?php if($odd) {$odd=false;echo 'odd';} else {$odd=true;echo 'even';} ?>">
									<td style="width: 100px;"><?php echo h($order['Orders']['total_qty']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['code']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['postal_code']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['customer_name']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['mobile']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['telco_code']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['address']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['note1']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['cancel_note']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['shipping_note']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['ShippingServices']['name']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Statuses']['name']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['price']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['total_price']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['duplicate_id']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['user_confirmed']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['user_assigned']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['confirmed']); ?>&nbsp;</td>
									<td style="width: 100px;"><?php echo h($order['Orders']['created']); ?>&nbsp;</td>
									<td style="width: 100px;">
										<?php echo $this->Html->link(__('View'), array('action' => 'view', $order['Orders']['id'])); ?>
										<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $order['Orders']['id'])); ?>
										<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $order['Orders']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $order['Orders']['id']))); ?>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<div
							style="position: relative; top: 0px; left: 0px; width: 1px; height: 2052px;"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5 col-sm-12"></div>
				<div class="col-md-7 col-sm-12">
					<div class="dataTables_paginate paging_bootstrap_number"
						id="sample_3_paginate">
						<ul class="pagination" style="visibility: visible;">
							<li class="prev"><a href="#" title="Prev"><i
									class="fa fa-angle-left"></i></a></li>
							<li class="active"><a href="#">1</a></li>
							<li class="next"><a href="#" title="Next"><i
									class="fa fa-angle-right"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>