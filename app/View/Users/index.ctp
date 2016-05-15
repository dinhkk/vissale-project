<?php
echo $this->element('breadcrumb');
echo $this->element('plugins/validate');
?>
<script>
    $(function () {
        $('.validate-form').each(function () {
            $(this).validate();
//            var $password = $(this).find('.password');
//            $(this).find('.re_password').rules('add', {
//                equalTo: '#'+$password,
//                messages: {
//                    equalTo: "<?php echo __('Nhập mật khẩu không khớp') ?>"
//                }
//            });
        });

        $('.modal-form').on('submit', function () {
            var action = $(this).attr('action');
            var data = $(this).serialize();
            var req = $.post(action, data, function (res) {
                if (res.error === 0) {

                    alert('<?php echo __('save_successful_message') ?>');
                    window.location.reload();
                } else {
                    alert(res.message);
                }
            }, 'json');

            req.error(function (xhr, status, error) {
                alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
            });

            return false;
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
                            <th><?php echo __('user_username') ?></th>
                            <th><?php echo __('user_name') ?></th>
                            <th><?php echo __('user_phone') ?></th>
                            <th><?php echo __('user_address') ?></th>
                            <th><?php echo __('user_status') ?></th>
                            <th><?php echo __('user_user_created') ?></th>
                            <th><?php echo __('user_created') ?></th>
                        <?php else: ?>
                            <th><?php echo __('operation') ?></th>
                            <th><?php echo __('user_username') ?></th>
                            <th><?php echo __('user_name') ?></th>
                            <th><?php echo __('user_phone') ?></th>
                            <th><?php echo __('user_address') ?></th>
                            <th><?php echo __('user_status') ?></th>
                            <th><?php echo __('user_user_created') ?></th>
                            <th><?php echo __('user_created') ?></th>
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
                            echo $this->Form->input('username', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'username',
                                'value' => $this->request->query('username'),
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
                                'name' => 'phone',
                                'value' => $this->request->query('address'),
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->checkbox('status', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'status',
                                'value' => STATUS_ACTIVE,
                                'checked' => $this->request->query('status'),
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
                        <td colspan="7">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php
                                    echo $this->Form->input('username', array(
                                        'class' => 'form-control',
                                        'label' => __('user_username'),
                                        'required' => true,
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    echo $this->Form->input('name', array(
                                        'class' => 'form-control',
                                        'label' => __('user_name'),
                                        'required' => true,
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    echo $this->Form->input('phone', array(
                                        'class' => 'form-control',
                                        'label' => __('user_phone'),
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    echo $this->Form->input('address', array(
                                        'class' => 'form-control',
                                        'label' => __('user_address'),
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    echo $this->Form->input('status', array(
                                        'class' => 'form-control',
                                        'value' => STATUS_ACTIVE,
                                        'label' => __('user_status'),
                                        'type' => 'checkbox',
                                        'default' => STATUS_ACTIVE,
                                    ));
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php if (!empty($list_data)): ?>
                        <?php foreach ($list_data as $item): ?>
                            <?php
                            $id = $item[$model_class]['id'];
                            ?>
                            <tr>
                                <td>
                                    <button type="button" class="btn green" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('edit_btn') ?></button>
                                    <button type="button" class="btn purple" data-toggle="modal" data-target="#reset-password-form-<?php echo $id ?>"><?php echo __('reset_password_btn') ?></button>
                                    <button type="button" class="btn blue" data-toggle="modal" data-target="#assign-role-form-<?php echo $id ?>"><?php echo __('assign_role_btn') ?></button>
                                    <button type="button" class="btn red ajax-delete" data-action="<?php echo Router::url(array('action' => 'reqDelete', $id), true) ?>" ><?php echo __('delete_btn') ?></button>
                                </td>
                                <td><?php echo h($item[$model_class]['username']) ?></td>
                                <td><?php echo h($item[$model_class]['name']) ?></td>
                                <td><?php echo h($item[$model_class]['phone']) ?></td>
                                <td><?php echo h($item[$model_class]['address']) ?></td>
                                <td>
                                    <?php
                                    echo $this->Form->checkbox('status', array(
                                        'class' => 'form-control ajax-input',
                                        'label' => false,
                                        'value' => STATUS_ACTIVE,
                                        'checked' => $item[$model_class]['status'],
                                        'disabled' => true,
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo!empty($users[$item[$model_class]['user_created']]) ?
                                            h($users[$item[$model_class]['user_created']]) : __('unknown');
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->Common->parseDateTime($item[$model_class]['created']);
                                    ?>
                                </td>
                            </tr>
                            <tr id="edit-form-<?php echo $id ?>" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
                                <td>
                                    <button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
                                    <button type="button" class="btn blue ajax-submit" id="edit-form-submit"><?php echo __('save_btn') ?></button>
                                </td>
                                <td colspan="7">
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->hidden('id', array(
                                            'class' => 'form-control',
                                            'label' => false,
                                            'value' => $id,
                                        ));
                                        echo $this->Form->input('username', array(
                                            'class' => 'form-control',
                                            'label' => false,
                                            'value' => $item[$model_class]['username'],
                                            'disabled' => true,
                                        ));
                                        ?> 
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('name', array(
                                            'class' => 'form-control',
                                            'label' => false,
                                            'value' => $item[$model_class]['name'],
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('phone', array(
                                            'class' => 'form-control',
                                            'label' => false,
                                            'value' => $item[$model_class]['phone'],
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('address', array(
                                            'class' => 'form-control',
                                            'label' => false,
                                            'value' => $item[$model_class]['address'],
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('status', array(
                                            'class' => 'form-control',
                                            'label' => false,
                                            'checked' => $item[$model_class]['status'],
                                            'value' => STATUS_ACTIVE,
                                            'type' => 'checkbox',
                                        ));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="center"><?php echo __('no_result') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php if (!empty($list_data)): ?>
    <?php foreach ($list_data as $item): ?>
        <?php
        $id = $item[$model_class]['id'];
        ?>
        <div id="reset-password-form-<?php echo $id ?>" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><?php echo __('reset_password_btn') ?></h4>
                    </div>
                    <?php
                    echo $this->Form->create($model_class, array(
                        'url' => array(
                            'action' => 'resetPassword',
                        ),
                        'class' => 'modal-form validate-form',
                    ));
                    ?>
                    <div class="modal-body">
                        <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    echo $this->Form->hidden('id', array(
                                        'class' => 'form-control',
                                        'value' => $id,
                                        'id' => 'id-' . $id,
                                    ));
                                    echo $this->Form->input('username', array(
                                        'class' => 'form-control',
                                        'label' => __('user_username'),
                                        'value' => $item[$model_class]['username'],
                                        'disabled' => true,
                                        'id' => 'username-' . $id,
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    echo $this->Form->input('name', array(
                                        'class' => 'form-control',
                                        'label' => __('user_name'),
                                        'value' => $item[$model_class]['name'],
                                        'disabled' => true,
                                        'id' => 'name-' . $id,
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    echo $this->Form->input('password', array(
                                        'class' => 'form-control password',
                                        'label' => __('user_new_password'),
                                        'type' => 'password',
                                        'minlength' => 6,
                                        'id' => 'new_password-' . $id,
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    echo $this->Form->input('re_password', array(
                                        'class' => 'form-control re_password',
                                        'label' => __('user_re_password'),
                                        'type' => 'password',
                                        'minlength' => 6,
                                        'id' => 're_password-' . $id,
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline"><?php echo __('close_btn') ?></button>
                        <button  class="btn green"><?php echo __('save_btn') ?></button>
                    </div>
                    <?php
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
        <div id="assign-role-form-<?php echo $id ?>" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><?php echo __('assign_role_btn') ?></h4>
                    </div>
                    <?php
                    echo $this->Form->create($model_class, array(
                        'url' => array(
                            'action' => 'assignRole',
                        ),
                        'class' => 'modal-form',
                    ));
                    ?>
                    <div class="modal-body">
                        <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    echo $this->Form->hidden('id', array(
                                        'class' => 'form-control',
                                        'value' => $id,
                                        'id' => 'id2-' . $id,
                                    ));
                                    echo $this->Form->input('username', array(
                                        'class' => 'form-control',
                                        'label' => __('user_username'),
                                        'value' => $item[$model_class]['username'],
                                        'disabled' => true,
                                        'id' => 'name2-' . $id,
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    echo $this->Form->input('name', array(
                                        'class' => 'form-control',
                                        'label' => __('user_name'),
                                        'value' => $item[$model_class]['name'],
                                        'disabled' => true,
                                        'id' => 'username2-' . $id,
                                    ));
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo __('Chọn quyền') ?></label>
                                        <div class="checkbox-list">
                                            <?php if (!empty($role_actives)): ?>
                                                <?php foreach ($role_actives as $rid => $rn): ?>
                                                    <label>
                                                        <input type="checkbox" value="<?php echo $rid ?>" name="data[<?php echo $model_class ?>][role_id][]">
                                                        <?php echo $rn; ?>
                                                    </label>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline"><?php echo __('close_btn') ?></button>
                        <button  class="btn green"><?php echo __('save_btn') ?></button>
                    </div>
                    <?php
                    echo $this->Form->end();
                    ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

