<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'field' => 'name',
        'label' => false,
    ));
    ?>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'field' => 'level',
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
        'class' => 'form-control select2-multiple',
        'label' => false,
        'options' => $perms,
        'required' => true,
        'empty' => '',
        'multiple' => true,
        'field' => 'perm_id',
    ));
    ?>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'class' => 'form-control select2-multiple',
        'label' => false,
        'options' => $order_status,
        'required' => true,
        'empty' => '',
        'multiple' => true,
        'field' => 'status_id',
    ));
    ?>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'class' => 'form-control',
        'label' => false,
        'options' => $status,
        'required' => true,
        'default' => STATUS_ACTIVE,
        'field' => 'status',
    ));
    ?>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'class' => 'form-control',
        'label' => false,
        'field' => 'description',
    ));
    ?>
</td>