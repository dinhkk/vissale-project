<?php
//debug($this->validationErrors);
$name_error = !empty($this->validationErrors[$model_class]['username']) ? $this->validationErrors[$model_class]['username'] : array();
$name_error_class = !empty($name_error) ? 'has-error' : '';
$phone_error = !empty($this->validationErrors[$model_class]['phone']) ? $this->validationErrors[$model_class]['phone'] : array();
$phone_error_class = !empty($name_error) ? 'has-error' : '';
?>
<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td>
    <?php
    echo $this->Form->input('username', array(
        'class' => 'form-control',
        'label' => false,
        'div' => 'input text ' . $name_error_class
    ));
    ?>
    <div>
        <?php if (!empty($name_error)): ?>
            <span class="help-block"><?php echo implode(' ,', $name_error) ?></span>
        <?php endif; ?>
    </div>
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
        'type' => 'text',
        'div'   => 'input text '. $phone_error_class
    ));
    ?>
    <div>
        <?php if (!empty($phone_error)): ?>
            <span class="help-block"><?php echo implode(' ,', $phone_error) ?></span>
        <?php endif; ?>
    </div>
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

