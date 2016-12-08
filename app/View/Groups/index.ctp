
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN THEME PANEL -->

<!-- END THEME PANEL -->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="index.html">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="#">Tables</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>Datatables</span>
		</li>
	</ul>

</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Groups Management
	<small> </small>
</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light portlet-fit bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-settings font-red"></i>
					<span class="caption-subject font-red sbold uppercase">Quản lý công ty</span>
				</div>
				<div class="actions">
					<!--<a id="btn_set_password" id="" href="#responsive" data-toggle="modal" class="btn red-mint"> <?php /*echo __("Tạo Group Admin") */?>
						<i class="fa fa-key"></i>
					</a>-->
				</div>
			</div>
			<div class="portlet-body">

				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-3">
							<div class="btn-group">
								<button class="btn green" data-toggle="collapse" data-target="#add-form"> <?php echo __('add_btn') ?>
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="col-md-9">
							<div id="datatable_ajax_wrapper" class="dataTables_wrapper dataTables_extended_wrapper no-footer pull-right">
								<div class="dataTables_paginate paging_bootstrap_extended" id="datatable_ajax_paginate">
									<div class="pagination-panel"> Page
										<?php
											echo $this->Paginator->prev('<i class="fa fa-angle-left"></i>', array(
											'tag' => 'span',
											'escape' => false,
											'class' => 'btn btn-sm default prev',
										), null, array(
											'class' => 'btn btn-sm default prev disabled',
											'tag' => 'span',
											'escape' => false,
											'disabledTag' => '',
										));
										?>
										<?php
											echo $this->Form->input('page', array(
											'default' => $this->Paginator->counter('{:page}'),
											'name' => 'page',
											'class' => 'pagination-panel-input form-control input-sm input-inline input-mini ajax-page ajax-control ajax-input',
											'label' => false,
											'div' => false,
											'style' => 'text-align:center; margin: 0 5px;',
											'maxlenght' => 5,
											'value' => $this->request->query('page'),
										));
										?>
										<?php
											echo $this->Paginator->next('<i class="fa fa-angle-right"></i>', array(
											'tag' => 'span',
											'escape' => false,
											'class' => 'btn btn-sm default next',
										), null, array(
											'class' => 'btn btn-sm default next disabled',
											'tag' => 'span',
											'escape' => false,
											'disabledTag' => '',
										));
										?>
										of <span class="pagination-panel-total">
                                        <?php
											echo $this->Paginator->counter('{:pages}');
										?>
                                    </span>
									</div>
								</div>
								<div class="dataTables_length" id="datatable_ajax_length">
									<label>
										<span class="seperator">|</span>View
										<?php
										echo $this->Form->input('limit', array(
											'options' => $limits,
											'default' => LIMIT_DEFAULT,
											'name' => 'limit',
											'class' => 'form-control input-xs input-sm input-inline ajax-limit ajax-control ajax-input',
											'label' => false,
											'div' => false,
											'value' => $this->request->query('limit'),
										));
										?>
										records
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
					<thead>
					<tr>
						<th style="width: 21.7%;"> Edit | Delete </th>
						<th> Tên Group </th>
						<th> Admin UserName </th>
						<th> Điện thoại </th>
						<th> Địa chỉ </th>
						<th> Tạo bởi </th>
						<th> Ngày tạo </th>
					</tr>
					</thead>
					<tbody>

					<tr id="search-form" class="ajax-search-form">
						<td>
							<button type="button" class="btn blue ajax-search-submit"><?php echo __('search_btn') ?></button>
						</td>
						<td>
							<?php
							echo $this->Form->input('name', array(
								'class' => 'form-control ajax-input',
								'label' => false,
								'name' => 'name',
								'value' => $this->request->query('name'),
							));
							?>
						</td>
						<td>
							<?php
							echo $this->Form->input('code', array(
								'class' => 'form-control ajax-input',
								'label' => false,
								'name' => 'code',
								'value' => $this->request->query('code'),
							));
							?>
						</td>
						<td>
							<?php
							echo $this->Form->input('phone', array(
								'class' => 'form-control ajax-input',
								'label' => false,
								'name' => 'phone',
								'value' => $this->request->query('phone'),
							));
							?>
						</td>
						<td>
							<?php
							echo $this->Form->input('address', array(
								'class' => 'form-control ajax-input',
								'label' => false,
								'name' => 'address',
								'value' => $this->request->query('address'),
							));
							?>
						</td>
						<td>
							<?php
							echo $this->Form->input('user_created', array(
								'class' => 'form-control ajax-input',
								'label' => false,
								'name' => 'user_created',
								'value' => $this->request->query('user_created'),
							));
							?>
						</td>
						<td>
							<?php
							echo $this->Form->input('created', array(
								'class' => 'form-control ajax-input',
								'label' => false,
								'name' => 'created',
								'value' => $this->request->query('created'),
							));
							?>
						</td>
					</tr>

					<tr id="add-form" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqAdd'), true) ?>">
						<td>
							<button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
							<button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
						</td>
						<td>
							<?php
							echo $this->Form->input('name', array(
								'class' => 'form-control',
								'label' => false,
							));
							?>
						</td>
						<td>
							<?php
							echo $this->Form->input('code', array(
								'class' => 'form-control',
								'label' => false,
								'type' 	=> 'text',
							));
							?>
						</td>
						<td>
							<?php
							echo $this->Form->input('phone', array(
								'class' => 'form-control',
								'label' => false,
								'type' => 'text'
							));
							?>
						</td>
						<td>
							<?php
							echo $this->Form->textarea('address', array(
								'class' => 'form-control',
								'label' => false,
								'type' => 'text',
								'value' => ''
							));
							?>
						</td>
						<td></td>
						<td></td>
					</tr>

					<?php if (!empty($groups)): ?>
						<?php foreach ($groups as $item): ?>
							<?php
							$id = $item[$model_class]['id'];
							?>
							<tr class="row_data" user-id="<?= $item[$model_class]['id'] ?>">
								<td>
									<?php //if (isset($action) && $action == true) { ?>
										<button type="button" class="btn green" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('edit_btn') ?></button>
										<button type="button" class="btn red ajax-delete" data-action="<?php echo Router::url(array('action' => 'reqDelete', $id), true) ?>" ><?php echo __('delete_btn') ?></button>
										<a id="btn_set_password" id="" href="#responsive_<?=$id?>" data-toggle="modal" class="btn red-mint"> <?php echo __("Đổi MK") ?>
											<i class="fa fa-key"></i>
										</a>
									<?php //} ?>
								</td>
								<td><?php echo h($item[$model_class]['name']) ?></td>
								<td><?php echo h($item[$model_class]['code']) ?></td>
								<td><?php echo h($item[$model_class]['phone']) ?></td>
								<td><?php echo h($item[$model_class]['address']) ?></td>
								<td></td>
								<td><?php $date = date_create($item[$model_class]['created']); echo h( date_format($date, 'd-m-Y')) ?></td>
							</tr>
							<tr id="edit-form-<?php echo $id ?>" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
								<td>
									<button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
									<button type="button" class="btn blue ajax-submit" id="edit-form-submit"><?php echo __('save_btn') ?></button>
								</td>
								<td>
									<?php
									echo $this->Form->hidden('id', array(
										'class' => 'form-control',
										'label' => false,
										'value' => $id,
									));
									echo $this->Form->input('name', array(
										'class' => 'form-control',
										'label' => false,
										'value' => $item[$model_class]['name'],
									));
									?>
								</td>
								<td>
									<?php
									echo $this->Form->input('code', array(
										'class' => 'form-control',
										'label' => false,
										'type' => 'text',
										'value' => $item[$model_class]['code'],
										'readonly',
										'disabled',
									));
									?>
								</td>
								<td>
									<?php
									echo $this->Form->input('phone', array(
										'class' => 'form-control',
										'label' => false,
										'type' => 'text',
										'value' => $item[$model_class]['phone'],
									));
									?>
								</td>
								<td>
									<?php
									echo $this->Form->textarea('address', array(
										'class' => 'form-control',
										'label' => false,
										'type' => 'text',
										'value' => $item[$model_class]['address'],
									));
									?>
								</td>
								<td></td>
								<td></td>
							</tr>
							<!-- /.modal -->
							<div id="responsive_<?= $item[$model_class]['id'] ?>"
								 class="modal fade ajax-form" tabindex="-1" aria-hidden="true"
								 data-action="<?php echo Router::url(array('controller'=>'groups','action' => 'reqEdit', $id), true) ?>">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">Đổi mật khẩu</h4>
										</div>
										<div class="modal-body">
											<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
												<div class="form-body">
													<div class="form-body">
														<div class="form-group">
															<label><?= __('username') ?></label>
															<div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-user"></i>
                                                                </span>
																<?php
																echo $this->Form->hidden('id', array(
																	'class' => 'form-control',
																	'label' => false,
																	'value' => $id,
																));

																echo $this->Form->hidden('user_id', array(
																	'class' => 'form-control',
																	'label' => false,
																	'value' => $item['User']['id'],
																));

																echo $this->Form->hidden('action', array(
																	'class' => 'form-control',
																	'label' => false,
																	'value' => 'change_password',
																));
																echo $this->Form->input('_username', array(
																	'class' => 'form-control',
																	'label' => false,
																	'type' => 'text',
																	'value' => $item[$model_class]['name'],
																	'readonly' => true
																));
																?>
															</div>
														</div>
														<div class="form-group">
															<label><?= __('user_name') ?></label>
															<div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-user"></i>
                                                                </span>
																<?php
																echo $this->Form->input('_name', array(
																	'class' => 'form-control',
																	'label' => false,
																	'type' => 'text',
																	'value' => $item[$model_class]['name'],
																	'readonly' => true
																));
																?>
															</div>
														</div>
														<div class="form-group">
															<label><?= __('new_password') ?></label>
															<div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-keyboard-o"></i>
                                                                </span>
																<?php
																echo $this->Form->input('new_password', array(
																	'class' => 'form-control',
																	'label' => false,
																	'type' => 'password',
																	'value' => '',
																));
																?>
															</div>
														</div>
														<div class="form-group">
															<label><?= __('re_password') ?></label>
															<div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-keyboard-o"></i>
                                                                </span>
																<?php
																echo $this->Form->input('re_password', array(
																	'class' => 'form-control',
																	'label' => false,
																	'type' => 'password',
																	'value' => '',
																));
																?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
											<button type="button" class="btn green ajax-submit">Save changes</button>
										</div>
									</div>
								</div>
							</div>

						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="2" class="center"><?php echo __('no_result') ?></td>
						</tr>
					<?php endif; ?>

					</tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>

<script>

	$(function () {
		// jQuery methods go here...
		/*$('tr.row_data').click(function () {
			$('tr.row_data').removeClass('active');
			$(this).addClass('active');
			var id = $(this).attr("user-id");
			$("#btn_set_password").attr("href", "#responsive_" + id);
			$("#btn_set_role").attr("href", "#role_" + id);
		});*/

		$("label").each(function () {
			if ($(this).hasClass("selected") == true) {
				var parent = $(this).parent();
				var span = parent.find("span");
				span.addClass("checked");
			} else {
				var parent = $(this).parent();
				var span = parent.find("span");
				span.removeClass("checked");
			}
		});

	});

</script>
