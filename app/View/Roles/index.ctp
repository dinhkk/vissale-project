<?php
echo $this->element('breadcrumb');
//echo $this->element('plugins/datatables');
?>

<div class="row">
	<div class="col-md-12">
		<div class="portlet-body" data-action="<?php
		echo Router::url(array(
			'action' => $this->action,
			'?' => $this->request->query,
		));
		?>">
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
					<th class="actions"><?php echo __('Actions'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('description'); ?></th>
					<th><?php echo $this->Paginator->sort('user_created'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
				</tr>
				</thead>
				<tbody>
				<tr id="search-form" class="ajax-search-form">
					<td>
						<button type="button" class="btn blue ajax-search-submit"><?php echo __('search_btn') ?></button>
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
						echo $this->Form->input('name', array(
							'class' => 'form-control ajax-input',
							'label' => false,
							'name' => 'name',
							'value' => $this->request->query('name'),
						));
						?>
					</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr id="add-form" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqAdd'), true) ?>">
					<td>
						<button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
						<button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
					</td>
					<td>
						<?php
						echo $this->Form->input('code', array(
							'class' => 'form-control',
							'label' => false,
						));
						?>
					</td>
					<td>
						<?php
						echo $this->Form->input('name', array(
							'class' => 'form-control',
							'label' => false,
						));
						?>
					</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php if (!empty($list_data)): ?>
					<?php foreach ($list_data as $item): ?>
						<?php
						$id = $item[$model_class]['id'];
						?>
						<tr>
							<td class="actions">
								<?php // echo $this->Html->link(__('View'), array('action' => 'view', $item[$model_class]['id'])); ?>
								<?php //echo $this->Html->link(__('Edit'), array('action' => 'edit', $item[$model_class]['id'])); ?>
								<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $item[$model_class]['id']), array('confirm' => __('Are you sure you want to delete # %s?', $item[$model_class]['id']))); ?>
								<?php if (isset($action) && $action == true) { ?>
									<button type="button" class="btn green" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('edit_btn') ?></button>
									<button type="button" class="btn red ajax-delete" data-action="<?php echo Router::url(array('action' => 'reqDelete', $id), true) ?>" ><?php echo __('delete_btn') ?></button>
								<?php } ?>
							</td>
							<td><?php echo h($item[$model_class]['name']); ?>&nbsp;</td>
							<td><?php echo h($item[$model_class]['description']); ?>&nbsp;</td>
							<td><?php echo h($item['User']['username']); ?>&nbsp;</td>
							<td><?php echo h($item[$model_class]['created']); ?>&nbsp;</td>
							<td><?php echo h($item[$model_class]['modified']); ?>&nbsp;</td>
						</tr>
						<tr id="edit-form-<?php echo $id ?>" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
							<td colspan="4">
								<table>
									<tr>
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
											echo $this->Form->input('name', array(
												'class' => 'form-control',
												'label' => false,
												'value' => $item[$model_class]['name'],
											));
											?>
										</td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</table>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="3" class="center"><?php echo __('no_result') ?></td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>