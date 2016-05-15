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

        $(document).on('fbsale.ajaxsearch fbsale.ajaxreload fbsale.ajaxsubmiterror', function () {
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
                            <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                <th><?php echo __('role_level') ?></th>
                                <th><?php echo __('role_perm_id') ?></th>
                            <?php endif; ?>
                            <th><?php echo __('role_status_id') ?></th>
                            <th><?php echo __('role_print_perm') ?></th>
                            <th><?php echo __('role_export_exel_perm') ?></th>
                            <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                <th><?php echo __('role_status') ?></th>
                                <th><?php echo __('role_parent_id') ?></th>
                                <th><?php echo __('role_group_id') ?></th>
                                <th><?php echo __('role_description') ?></th>
                            <?php endif; ?>
                        <?php else: ?>
                            <th><?php echo __('operation') ?></th>
                            <th><?php echo __('role_name') ?></th>
                            <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                <th><?php echo __('role_level') ?></th>
                                <th><?php echo __('role_perm_id') ?></th>
                            <?php endif; ?>
                            <th><?php echo __('role_status_id') ?></th>
                            <th><?php echo __('role_print_perm') ?></th>
                            <th><?php echo __('role_export_exel_perm') ?></th>
                            <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                <th><?php echo __('role_status') ?></th>
                                <th><?php echo __('role_parent_id') ?></th>
                                <th><?php echo __('role_group_id') ?></th>
                                <th><?php echo __('role_description') ?></th>
                            <?php endif; ?>
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
                        <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                            <td>
                                <?php
                                echo $this->Form->input('level', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'level',
                                    'value' => $this->request->query('level'),
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
                        <?php endif; ?>
                        <td>
                            <?php
                            echo $this->Form->input('status_id', array(
                                'class' => 'form-control ajax-input select2-multiple',
                                'label' => false,
                                'name' => 'status_id',
                                'value' => $this->request->query('status_id'),
                                'options' => $order_status,
                                'empty' => '',
                                'multiple' => true,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->checkbox('enable_print_perm', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'enable_print_perm',
                                'checked' => $this->request->query('enable_print_perm'),
                                'value' => 1,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->checkbox('enable_export_exel_perm', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'enable_export_exel_perm',
                                'checked' => $this->request->query('enable_export_exel_perm'),
                                'value' => 1,
                            ));
                            ?>
                        </td>
                        <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
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
                                echo $this->Form->input('parent_id', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'parent_id',
                                    'value' => $this->request->query('parent_id'),
                                    'options' => $parents,
                                    'empty' => '',
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('group_id', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'group_id',
                                    'value' => $this->request->query('group_id'),
                                    'options' => $groups,
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
                        <?php endif; ?>
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
                        <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                            <td>
                                <?php
                                echo $this->Form->input('level', array(
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
                        <?php endif; ?>
                        <td>
                            <?php
                            echo $this->Form->input('status_id', array(
                                'class' => 'form-control select2-multiple',
                                'label' => false,
                                'options' => $order_status,
                                'required' => true,
                                'empty' => '',
                                'multiple' => true,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->checkbox('enable_print_perm', array(
                                'class' => 'form-control',
                                'label' => false,
                                'value' => 1,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->checkbox('enable_export_exel_perm', array(
                                'class' => 'form-control',
                                'label' => false,
                                'value' => 1,
                            ));
                            ?>
                        </td>
                        <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
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
                                echo $this->Form->input('parent_id', array(
                                    'class' => 'form-control select2-multiple',
                                    'label' => false,
                                    'options' => $parents,
                                    'empty' => '',
                                    'multiple' => true,
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('group_id', array(
                                    'class' => 'form-control select2-multiple',
                                    'label' => false,
                                    'options' => $groups,
                                    'empty' => '',
                                    'multiple' => true,
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
                        <?php endif; ?>
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
                                <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                    <td>
                                        <?php
                                        echo!empty($role_levels[$item[$model_class]['level']]) ?
                                                $role_levels[$item[$model_class]['level']] : __('unknown');
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
                                            'value' => $item[$model_class]['perm_id'],
                                        ));
                                        ?>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    <?php
                                    echo $this->Form->input('status_id', array(
                                        'class' => 'form-control select2-multiple',
                                        'label' => false,
                                        'options' => $order_status,
                                        'empty' => '',
                                        'disabled' => true,
                                        'multiple' => true,
                                        'value' => $item[$model_class]['status_id'],
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->Form->checkbox('enable_print_perm', array(
                                        'class' => 'form-control',
                                        'label' => false,
                                        'disabled' => true,
                                        'value' => 1,
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->Form->checkbox('enable_export_exel_perm', array(
                                        'class' => 'form-control',
                                        'label' => false,
                                        'disabled' => true,
                                        'value' => 1,
                                    ));
                                    ?>
                                </td>
                                <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                    <td>
                                        <?php
                                        echo!empty($status[$item[$model_class]['status']]) ?
                                                $status[$item[$model_class]['status']] : __('unknown');
                                        ?>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    <?php echo h($item[$model_class]['description']); ?>
                                </td>
                            </tr>
                            <tr id="edit-form-<?php echo $id ?>" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
                                <td>
                                    <button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
                                    <button type="button" class="btn blue ajax-submit" id="edit-form-submit"><?php echo __('save_btn') ?></button>  
                                </td>
                                <td colspan="6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?php
                                            echo $this->Form->hidden('id', array(
                                                'class' => 'form-control',
                                                'label' => false,
                                                'value' => $id,
                                            ));
                                            ?>
                                            <?php
                                            echo $this->Form->input('name', array(
                                                'class' => 'form-control',
                                                'label' => __('role_name'),
                                                'value' => $item[$model_class]['name'],
                                            ));
                                            ?>
                                        </div>
                                        <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('level', array(
                                                    'class' => 'form-control',
                                                    'label' => __('role_level'),
                                                    'value' => $item[$model_class]['level'],
                                                    'options' => $role_levels,
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
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
                                        <?php endif; ?>
                                        <div class="col-md-4">
                                            <?php
                                            echo $this->Form->input('status_id', array(
                                                'class' => 'form-control select2-multiple',
                                                'label' => __('role_status_id'),
                                                'value' => $item[$model_class]['status_id'],
                                                'options' => $order_status,
                                                'multiple' => true,
                                            ));
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?php
                                            echo $this->Form->input('enable_print_perm', array(
                                                'class' => 'form-control',
                                                'label' => __('role_print_perm'),
                                                'checked' => $item[$model_class]['enable_print_perm'],
                                                'value' => 1,
                                            ));
                                            ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?php
                                            echo $this->Form->input('enable_export_exel_perm', array(
                                                'class' => 'form-control',
                                                'label' => __('role_export_exel_perm'),
                                                'checked' => $item[$model_class]['enable_export_exel_perm'],
                                                'value' => 1,
                                            ));
                                            ?>
                                        </div>
                                        <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('status', array(
                                                    'class' => 'form-control',
                                                    'label' => __('role_status'),
                                                    'value' => $item[$model_class]['status'],
                                                    'options' => $status,
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('parent_id', array(
                                                    'class' => 'form-control',
                                                    'label' => __('role_parent_id'),
                                                    'value' => $item[$model_class]['parent_id'],
                                                    'options' => $parents,
                                                    'disabled' => true,
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('group_id', array(
                                                    'class' => 'form-control',
                                                    'label' => __('role_group_id'),
                                                    'value' => $item[$model_class]['group_id'],
                                                    'options' => $groups,
                                                    'disabled' => true,
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('description', array(
                                                    'class' => 'form-control',
                                                    'label' => __('role_description'),
                                                    'value' => $item[$model_class]['description'],
                                                ));
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
                                <td colspan="7" class="center"><?php echo __('no_result') ?></td>
                            <?php else: ?>
                                <td colspan="7" class="center"><?php echo __('no_result') ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>