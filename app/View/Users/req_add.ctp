<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td colspan="7">
    <div class="row">
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'username',
                'class' => 'form-control',
                'label' => __('user_username'),
                'required' => true,
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'name',
                'class' => 'form-control',
                'label' => __('user_name'),
                'required' => true,
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
                'value' => STATUS_ACTIVE,
                'label' => __('user_status'),
                'type' => 'checkbox',
                'default' => STATUS_ACTIVE,
            ));
            ?>
        </div>
    </div>
</td>