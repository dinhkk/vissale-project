
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
<h3 class="page-title"> User Management
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
                    <span class="caption-subject font-red sbold uppercase">Quản lý nhân viên</span>
                </div>
                <div class="actions">
                    <?php if (isset($action) && $action == true) { ?>
                    <button id="btn_set_role" href="#role" data-toggle="modal" class="btn btn-warning"> <?php echo __("Phân Quyền") ?>
                        <i class="fa fa-sitemap"></i>
                    </button>
                    <a id="btn_set_password" id="" href="#responsive" data-toggle="modal" class="btn red-mint"> <?php echo __("Đổi Mật Khẩu") ?>
                        <i class="fa fa-key"></i>
                    </a>
                    <?php } ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            <?php if (isset($action) && $action == true) { ?>
                                <button id="sample_editable_1_new" data-toggle="collapse" class="btn green" data-target="#add-form"> Add New
                                    <i class="fa fa-plus"></i>
                                </button>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                    <tr>
                        <th> Edit | Delete </th>
                        <th> Tên tài khoản </th>
                        <th> Tên nhân viên </th>
                        <th> Điện thoại </th>
                        <th> Địa chỉ </th>
                        <th> Tạo bởi </th>
                        <th> Ngày tạo </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="add-form" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqAdd'), true) ?>">
                        <td>
                            <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
                            <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('username', array(
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
                                'type' => 'text'
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
                            echo $this->Form->input('address', array(
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

                    <?php if (!empty($list_data)): ?>
                        <?php foreach ($list_data as $item): ?>
                            <?php
                            $id = $item[$model_class]['id'];
                            ?>
                            <tr class="row_data" user-id="<?=$item[$model_class]['id']?>">
                                <td>
                                <?php if (isset($action) && $action == true) { ?>
                                    <button type="button" class="btn green" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('edit_btn') ?></button>
                                    <button type="button" class="btn red ajax-delete" data-action="<?php echo Router::url(array('action' => 'reqDelete', $id), true) ?>" ><?php echo __('delete_btn') ?></button>
                                <?php } ?>
                                </td>
                                <td><?php echo h($item[$model_class]['username']) ?></td>
                                <td><?php echo h($item[$model_class]['name']) ?></td>
                                <td><?php echo h($item[$model_class]['phone']) ?></td>
                                <td><?php echo h($item[$model_class]['address']) ?></td>
                                <td></td>
                                <td></td>
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
                                    echo $this->Form->input('username', array(
                                        'class' => 'form-control',
                                        'label' => false,
                                        'value' => $item[$model_class]['username'],
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->Form->input('name', array(
                                        'class' => 'form-control',
                                        'label' => false,
                                        'type' => 'text',
                                        'value' => $item[$model_class]['name'],
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
                                    echo $this->Form->input('address', array(
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
                            <div id="responsive_<?=$item[$model_class]['id']?>"
                                 class="modal fade ajax-form" tabindex="-1" aria-hidden="true"
                                 data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
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
                                                            <label><?=__('username')?></label>
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
                                                                echo $this->Form->hidden('action', array(
                                                                    'class' => 'form-control',
                                                                    'label' => false,
                                                                    'value' => 'change_password',
                                                                ));
                                                                echo $this->Form->input('_username', array(
                                                                    'class' => 'form-control',
                                                                    'label' => false,
                                                                    'type' => 'text',
                                                                    'value' => $item[$model_class]['username'],
                                                                    'readonly' => true
                                                                ));
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><?=__('user_name')?></label>
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
                                                            <label><?=__('new_password')?></label>
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
                                                            <label><?=__('re_password')?></label>
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

                            <div id="role_<?=$item[$model_class]['id']?>"
                                 class="modal fade ajax-form" tabindex="-1" aria-hidden="true"
                                 data-action="<?php echo Router::url(array('action' => 'reqEditRoles', $id), true) ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">Phân quyền</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                                                <div class="form-body">
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label><strong>Thông tin</strong></label><br />
                                                                    <label><strong>Username</strong>: <?=$item[$model_class]['username']?></label><br />
                                                                    <label><strong>Tên</strong>: <?=$item[$model_class]['name']?></label><br />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Chọn quyền</label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="multi-checkbox" style="padding-left: 20px;">
                                                                        <?php
                                                                        $selected = $item['UsersRole'];
                                                                        echo $this->Form->input('Role.id', array(
                                                                            'label' => false,
                                                                            'type' => 'select',
                                                                            'multiple' => 'checkbox',
                                                                            'options' => $roles,
                                                                            'selected' => $selected,
                                                                            'id' => "UsersRole" .$item[$model_class]['id'],
                                                                            //'class' => 'multiple-checkbox'
                                                                        ));
                                                                        ?>
                                                                    </div>
                                                                </div>
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

    $(function(){
        // jQuery methods go here...
        $('tr.row_data').click(function () {
            $('tr.row_data').removeClass('active');
            $(this).addClass('active');
            var  id = $(this).attr("user-id");
            $("#btn_set_password").attr("href", "#responsive_"+id);
            $("#btn_set_role").attr("href", "#role_"+id);
        });

        $("label").each(function () {
            if ( $(this).hasClass("selected")==true){
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