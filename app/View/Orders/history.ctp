<!-- Lich su trang thai don hang -->
<div class="row">
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption font-dark">
				<i class="icon-settings font-dark"></i> <span
					class="caption-subject bold uppercase">Trạng thái</span>
			</div>
			<div class="tools"></div>
		</div>
		<div class="portlet-body">
			<div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
				<div class="table-scrollable">
					<table
						class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed"
						width="100%" id="sample_1" role="grid"
						aria-describedby="sample_1_info" style="width: 100%;">
						<thead>
							<tr role="row">
								<th class="all" tabindex="0"
									aria-controls="sample_1" rowspan="1" colspan="1"
									aria-sort="ascending"
									aria-label="First name: activate to sort column descending"
									style="width: 25%;">Trạng thái cũ</th>
								<th class="min-phone-l" tabindex="0"
									aria-controls="sample_1" rowspan="1" colspan="1"
									aria-label="Last name: activate to sort column ascending"
									style="width: 25%;">Trạng thái mới</th>
								<th class="min-tablet" tabindex="0"
									aria-controls="sample_1" rowspan="1" colspan="1"
									aria-label="Position: activate to sort column ascending"
									style="width: 25%;">Nhân viên</th>
								<th class="" tabindex="0" aria-controls="sample_1"
									rowspan="1" colspan="1"
									aria-label="Office: activate to sort column ascending"
									style="width: 25%;">Thời gian</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($revisions as $re) { ?>
							<tr role="row" class="odd">
								<td><?php echo $re['OrderRevision']['before_order_status'] ?></td>
								<td><?php echo $re['OrderRevision']['order_status'] ?></td>
								<td><?php echo $re['OrderRevision']['user_created_name'] ?></td>
								<td><?php echo $re['OrderRevision']['modified'] ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Thong tin -->
<div class="row">
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption font-dark">
				<i class="icon-settings font-dark"></i> <span
					class="caption-subject bold uppercase">Thông tin</span>
			</div>
			<div class="tools"></div>
		</div>
		<div class="portlet-body">
			<div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
				<div class="table-scrollable">
					<table
						class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed"
						width="100%" id="sample_1" role="grid"
						aria-describedby="sample_1_info" style="width: 100%;">
						<thead>
							<tr role="row">
								<th class="all" tabindex="0"
									aria-controls="sample_1" rowspan="1" colspan="1"
									aria-sort="ascending"
									aria-label="First name: activate to sort column descending"
									style="width: 20%;">Nội dung</th>
								<th class="min-phone-l" tabindex="0"
									aria-controls="sample_1" rowspan="1" colspan="1"
									aria-label="Last name: activate to sort column ascending"
									style="width: 20%;">Giá trị cũ</th>
								<th class="min-tablet" tabindex="0"
									aria-controls="sample_1" rowspan="1" colspan="1"
									aria-label="Position: activate to sort column ascending"
									style="width: 20%;">Giá trị mới</th>
								<th class="none" tabindex="0" aria-controls="sample_1"
									rowspan="1" colspan="1"
									aria-label="Office: activate to sort column ascending"
									style="width: 20%;">Nhân viên</th>
								<th class="none" tabindex="0" aria-controls="sample_1"
									rowspan="1" colspan="1"
									aria-label="Age: activate to sort column ascending"
									style="width: 20%;">Thời gian</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($changes as $c) { ?>
							<tr role="row" class="odd">
								<td><?php echo $c['OrderChange']['field_label'] ?></td>
								<td><?php echo $c['OrderChange']['before_value'] ?></td>
								<td><?php echo $c['OrderChange']['value'] ?></td>
								<td><?php echo $c['OrderChange']['user_created_name'] ?></td>
								<td><?php echo $c['OrderChange']['modified'] ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END -->