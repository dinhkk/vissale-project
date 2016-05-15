<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'field' => 'name',
        'class' => 'form-control',
        'label' => false,
    ));
    ?>
</td>
<?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
    <td>
        <?php
        echo $this->element('form/input', array(
            'field' => 'level',
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
        echo $this->element('form/input', array(
            'field' => 'perm_id',
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
    echo $this->element('form/input', array(
        'field' => 'status_id',
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
    echo $this->element('form/input', array(
        'field' => 'enable_print_perm',
        'class' => 'form-control',
        'label' => false,
        'value' => 1,
        'type' => 'checkbox',
    ));
    ?>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'field' => 'enable_export_exel_perm',
        'class' => 'form-control',
        'label' => false,
        'value' => 1,
        'type' => 'checkbox',
    ));
    ?>
</td>
<?php if (!empty($user_level) && $user_level >= ADMINSYSTEM): ?>
    <td>
        <?php
        echo $this->element('form/input', array(
            'field' => 'status',
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
        echo $this->element('form/input', array(
            'field' => 'parent_id',
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
        echo $this->element('form/input', array(
            'field' => 'group_id',
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
        echo $this->element('form/input', array(
            'field' => 'description',
            'class' => 'form-control',
            'label' => false,
        ));
        ?>
    </td>
<?php endif; ?>