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
        echo $this->element('form/input', array(
            'field' => 'username',
            'class' => 'form-control',
            'label' => __('user_username'),
            'disabled' => true,
        ));
        ?> 
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'field' => 'name',
            'class' => 'form-control',
            'label' => __('user_name'),
        ));
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'field' => 'phone',
            'class' => 'form-control',
            'label' => __('user_phone'),
        ));
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'field' => 'address',
            'class' => 'form-control',
            'label' => __('user_address'),
        ));
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $this->element('form/input', array(
            'field' => 'status',
            'class' => 'form-control',
            'label' => __('user_status'),
            'checked' => $this->request->data($model_class . '.status'),
            'value' => STATUS_ACTIVE,
            'type' => 'checkbox',
        ));
        ?>
    </div>
</td>