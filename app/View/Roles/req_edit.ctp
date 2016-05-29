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
            echo $this->element('form/input', array(
                'field' => 'name',
                'class' => 'form-control',
                'label' => __('role_name'),
            ));
            ?>
        </div>
        <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
            <div class="col-md-4">
                <?php
                echo $this->element('form/input', array(
                    'field' => 'level',
                    'class' => 'form-control',
                    'label' => __('role_level'),
                    'options' => $role_levels,
                ));
                ?>
            </div>
            <div class="col-md-4">
                <?php
                echo $this->element('form/input', array(
                    'field' => 'perm_id',
                    'class' => 'form-control select2-multiple',
                    'label' => __('role_perm_id'),
                    'options' => $perms,
                    'multiple' => true,
                ));
                ?>
            </div>
        <?php endif; ?>
        <div class="col-md-4">
            <?php if (!empty($user_level) && $user_level < ADMINSYSTEM): ?>
                <?php
                echo $this->Form->input('perm_id', array(
                    'class' => 'form-control',
                    'label' => false,
                    'value' => $item[$model_class]['perm_id'],
                    'options' => $perms,
                    'multiple' => true,
                    'style' => 'display:none;',
                    'div' => false,
                ));
                ?>
            <?php endif; ?>
            <?php
            echo $this->element('form/input', array(
                'field' => 'status_id',
                'class' => 'form-control select2-multiple',
                'label' => __('role_status_id'),
                'options' => $order_status,
                'multiple' => true,
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'enable_print_perm',
                'class' => 'form-control',
                'label' => __('role_print_perm'),
                'checked' => $this->request->data($model_class . '.enable_print_perm'),
                'value' => STATUS_ACTIVE,
                'type' => 'checkbox',
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'enable_export_exel_perm',
                'class' => 'form-control',
                'label' => __('role_export_exel_perm'),
                'checked' => $this->request->data($model_class . '.enable_export_exel_perm'),
                'value' => STATUS_ACTIVE,
                'type' => 'checkbox',
            ));
            ?>
        </div>
        <?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
            <div class="col-md-4">
                <?php
                echo $this->element('form/input', array(
                    'field' => 'status',
                    'class' => 'form-control',
                    'label' => __('role_status'),
                    'options' => $status,
                ));
                ?>
            </div>
            <div class="col-md-4">
                <?php
                echo $this->element('form/input', array(
                    'field' => 'parent_id',
                    'class' => 'form-control',
                    'label' => __('role_parent_id'),
                    'disabled' => true,
                    'type' => 'text',
                ));
                ?>
            </div>
            <div class="col-md-4">
                <?php
                echo $this->element('form/input', array(
                    'field' => 'group_id',
                    'class' => 'form-control',
                    'label' => __('role_group_id'),
                    'options' => $groups,
                    'disabled' => true,
                ));
                ?>
            </div>
            <div class="col-md-4">
                <?php
                echo $this->element('form/input', array(
                    'field' => 'description',
                    'class' => 'form-control',
                    'label' => __('role_description'),
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
</td>