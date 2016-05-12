<?php
echo $this->element('breadcrumb');
echo $this->element('plugins/select2');
?>
<script>
    $(function () {

        $.fn.select2.defaults.set("theme", "bootstrap");
        var placeholder = "Select a State";

        $(".select2, .select2-multiple").select2({
            placeholder: placeholder,
            width: null
        });

        $(document).on('fbsale.ajaxsearch', function () {
            $(".select2, .select2-multiple").select2({
                placeholder: placeholder,
                width: null
            });
        });
    });
</script>
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
                        <?php if (!empty($list_data)): ?>
                            <th><?php echo __('operation') ?></th>
                            <th><?php echo __('role_name') ?></th>
                            <th><?php echo __('role_level') ?></th>
                            <th><?php echo __('role_perm_id') ?></th>
                            <th><?php echo __('role_status') ?></th>
                            <th><?php echo __('role_description') ?></th>
                        <?php else: ?>
                            <th><?php echo __('operation') ?></th>
                            <th><?php echo __('role_name') ?></th>
                            <th><?php echo __('role_level') ?></th>
                            <th><?php echo __('role_perm_id') ?></th>
                            <th><?php echo __('role_status') ?></th>
                            <th><?php echo __('role_description') ?></th>
                        <?php endif; ?>
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
                            echo $this->Form->input('type', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'type',
                                'value' => $this->request->query('type'),
                                'options' => $role_levels,
                                'empty' => '',
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('perm_id', array(
                                'class' => 'form-control ajax-input select2-multiple',
                                'label' => false,
                                'name' => 'perm_id',
                                'value' => $this->request->query('perm_id'),
                                'options' => $perms,
                                'empty' => '',
                                'multiple' => true,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('status', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'status',
                                'value' => $this->request->query('status'),
                                'options' => $status,
                                'empty' => '',
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('description', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'description',
                                'value' => $this->request->query('description'),
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
                            echo $this->Form->input('type', array(
                                'class' => 'form-control',
                                'label' => false,
                                'options' => $role_levels,
                                'required' => true,
                                'empty' => '',
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('perm_id', array(
                                'class' => 'form-control select2-multiple',
                                'label' => false,
                                'options' => $perms,
                                'required' => true,
                                'empty' => '',
                                'multiple' => true,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('status', array(
                                'class' => 'form-control',
                                'label' => false,
                                'options' => $status,
                                'required' => true,
                                'default' => STATUS_ACTIVE,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('description', array(
                                'class' => 'form-control',
                                'label' => false,
                            ));
                            ?>
                        </td>
                    </tr>
                    <?php if (!empty($list_data)): ?>
                        <?php foreach ($list_data as $item): ?>
                            <?php
                            $id = $item[$model_class]['id'];
                            ?>
                            <tr>
                                <td class="actions">
                                    <button type="button" class="btn green" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('edit_btn') ?></button>
                                    <button type="button" class="btn red ajax-delete" data-action="<?php echo Router::url(array('action' => 'reqDelete', $id), true) ?>" ><?php echo __('delete_btn') ?></button>
                                </td>
                                <td><?php echo h($item[$model_class]['name']); ?></td>
                                <td>
                                    <?php
                                    echo!empty($role_levels[$item[$model_class]['type']]) ?
                                            $role_levels[$item[$model_class]['type']] : __('unknown');
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->Form->input('perm_id', array(
                                        'class' => 'form-control select2-multiple',
                                        'label' => false,
                                        'options' => $perms,
                                        'empty' => '',
                                        'readonly' => true,
                                        'multiple' => true,
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo!empty($status[$item[$model_class]['status']]) ?
                                            $status[$item[$model_class]['status']] : __('unknown');
                                    ?>
                                </td>
                                <td>
                                    <?php echo h($item[$model_class]['description']); ?>
                                </td>
                            </tr>
                            <tr id="edit-form-<?php echo $id ?>" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
                                <td colspan="6">
                                    <table >
                                        <tr>
                                            <td>
                                                <?php
                                                echo $this->Form->hidden('id', array(
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'value' => $id,
                                                ));
                                                ?>
                                                <button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
                                                <button type="button" class="btn blue ajax-submit" id="edit-form-submit"><?php echo __('save_btn') ?></button>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->input('name', array(
                                                        'class' => 'form-control',
                                                        'label' => __('role_name'),
                                                        'value' => $item[$model_class]['name'],
                                                    ));
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->input('type', array(
                                                        'class' => 'form-control',
                                                        'label' => __('role_level'),
                                                        'value' => $item[$model_class]['type'],
                                                        'options' => $role_levels,
                                                    ));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->input('perm_id', array(
                                                        'class' => 'form-control select2-multiple',
                                                        'label' => __('role_perm_id'),
                                                        'value' => $item[$model_class]['perm_id'],
                                                        'options' => $perms,
                                                        'multiple' => true,
                                                    ));
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->input('status', array(
                                                        'class' => 'form-control',
                                                        'label' => __('role_status'),
                                                        'value' => $item[$model_class]['status'],
                                                        'options' => $status,
                                                    ));
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                    echo $this->Form->input('description', array(
                                                        'class' => 'form-control',
                                                        'label' => __('role_description'),
                                                        'value' => $item[$model_class]['description'],
                                                    ));
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="center"><?php echo __('no_result') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>