<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="edit-form-submit"><?php echo __('save_btn') ?></button>  
</td>
<td colspan="6">
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
            'label' => false,
        ));
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'class' => 'form-control',
            'label' => __('role_level'),
            'options' => $role_levels,
            'field' => 'level',
        ));
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'class' => 'form-control select2-multiple',
            'label' => __('role_perm_id'),
            'options' => $perms,
            'multiple' => true,
            'field' => 'perm_id',
        ));
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'class' => 'form-control select2-multiple',
            'label' => __('role_status_id'),
            'options' => $perms,
            'multiple' => true,
            'field' => 'status_id',
        ));
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'class' => 'form-control',
            'label' => __('role_status'),
            'value' => $item[$model_class]['status'],
            'options' => $status,
            'field' => 'status',
        ));
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'class' => 'form-control',
            'label' => __('role_description'),
            'field' => 'description',
        ));
        ?>
    </div>
</td>

