<div class="portlet light bordered">
	<div class="portlet-body table-both-scroll">
		<div id="sample_3_wrapper" class="dataTables_wrapper no-footer DTS">
			<div class="table-scrollable">
				<div class="dataTables_scroll">
					<div class="dataTables_scrollHead"
						style="overflow: hidden; position: relative; border: 0px; width: 100%;">
						<div class="dataTables_scrollHeadInner"
							style="box-sizing: content-box; width: 1142px; padding-right: 15px;">
							<table
								class="table table-striped table-bordered table-hover order-column dataTable no-footer"
								role="grid" style="margin-left: 0px; width: 500px;">
								<thead>
									<tr role="row">
										<th class="sorting_asc" tabindex="0" aria-controls="sample_3"
											rowspan="1" colspan="1" style="width: 100px;"
											aria-label="First&amp;nbsp;name: activate to sort column descending"
											aria-sort="ascending">Mã</th>
										<th class="sorting" tabindex="0" aria-controls="sample_3"
											rowspan="1" colspan="1" style="width: 100px;"
											aria-label="Lastname: activate to sort column ascending">Tên</th>
										<th class="sorting" tabindex="0" aria-controls="sample_3"
											rowspan="1" colspan="1" style="width: 100px;"
											aria-label="Position: activate to sort column ascending">Giá</th>
										<th class="sorting" tabindex="0" aria-controls="sample_3"
											rowspan="1" colspan="1" style="width: 100px;"
											aria-label="Office: activate to sort column ascending">Màu</th>
										<th class="sorting" tabindex="0" aria-controls="sample_3"
											rowspan="1" colspan="1" style="width: 100px;"
											aria-label="Age: activate to sort column ascending">Size</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="dataTables_scrollBody"
						style="position: relative; overflow: auto; width: 100%; max-height: 300px;">
						<table class="table table-striped table-bordered table-hover order-column dataTable no-footer"
							id="tb_listproduct" role="grid" aria-describedby="sample_3_info"
							style="width: 500px; position: absolute; top: 0px; left: 0px;">
							<thead>
								<tr role="row" style="height: 0px;">
									<th class="sorting_asc" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-sort="ascending"><div class="dataTables_sizing"
											style="height: 0; overflow: hidden;">Mã</div></th>
									<th class="sorting_asc" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-sort="ascending"><div class="dataTables_sizing"
											style="height: 0; overflow: hidden;">Tên</div></th>
									<th class="sorting_asc" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-sort="ascending"><div class="dataTables_sizing"
											style="height: 0; overflow: hidden;">Giá</div></th>
									<th class="sorting_asc" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-sort="ascending"><div class="dataTables_sizing"
											style="height: 0; overflow: hidden;">Màu</div></th>
									<th class="sorting_asc" aria-controls="sample_3" rowspan="1"
										colspan="1"
										style="width: 100px; padding-top: 0px; padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;"
										aria-sort="ascending"><div class="dataTables_sizing"
											style="height: 0; overflow: hidden;">Size</div></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($products as $prd) { ?>
								<tr role="row" class="odd" prd_id="<?php echo $prd['Products']['id']; ?>">
									<td><?php echo $prd['Products']['code']; ?></td>
									<td><?php echo $prd['Products']['name']; ?></td>
									<td><?php echo $prd['Products']['price']; ?></td>
									<td><?php echo $prd['Products']['color']; ?></td>
									<td><?php echo $prd['Products']['size']; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<div
							style="position: relative; top: 0px; left: 0px; width: 1px; height: 500px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal show thong bao -->
<div class="modal fade" id="modal_message" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal Title</h4>
            </div>
            <div class="modal-body"> Modal body goes here </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">OK</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>