<?php
$field_error = !empty($this->validationErrors[$model_class][$field]) ? $this->validationErrors[$model_class][$field] : array();
$field_error_clss = !empty($field_error) ? 'has-error' : '';
?>
<div class="form-group <?php echo $field_error_clss ?>">
    <?php
    $attrs = array(
        'class' => 'form-control',
        'label' => false,
        'div' => false,
    );
    if (isset($empty)) {
        $attrs['empty'] = $empty;
    }
    if (isset($readonly)) {
        $attrs['readonly'] = $readonly;
    }
    if (isset($options)) {
        $attrs['options'] = $options;
    }
    if (isset($default)) {
        $attrs['default'] = $default;
    }
    ?>
    <?php if (!empty($label)): ?>
        <label><?php echo $label ?></label>
    <?php endif; ?>
    <div class="input-group input-medium date date-picker-field">
        <?php
        echo $this->Form->input($field, $attrs);
        ?>
        <span class="input-group-btn">
            <button class="btn default" type="button">
                <i class="fa fa-calendar"></i>
            </button>
        </span>
    </div>
    <?php if (!empty($field_error)): ?>
        <span class="help-block"><?php echo implode(' ,', $field_error) ?></span>
    <?php endif; ?>
</div>