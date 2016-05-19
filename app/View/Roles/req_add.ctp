<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td colspan="9">
    <div class="col-md-4">
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
                'required' => true,
                'empty' => '',
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
                'required' => true,
                'empty' => '',
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
                'value' => $role_clone[$model_class]['perm_id'],
                'options' => $perms,
                'multiple' => true,
                'style' => 'display:none;',
                'div' => false,
            ));
            echo $this->Form->hidden('level', array(
                'value' => $role_clone[$model_class]['level'],
            ));
            echo $this->Form->hidden('parent_id', array(
                'value' => $role_clone[$model_class]['id'],
            ));
            ?>
        <?php endif; ?>
        <?php
        echo $this->element('form/input', array(
            'field' => 'status_id',
            'class' => 'form-control select2-multiple',
            'label' => __('role_status_id'),
            'options' => $order_status,
            'required' => true,
            'empty' => '',
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
                'required' => true,
                'default' => STATUS_ACTIVE,
            ));
            ?>
        </div>
    <?php endif; ?>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'field' => 'description',
            'class' => 'form-control',
            'label' => __('role_description'),
        ));
        ?>
    </div>
</td>


