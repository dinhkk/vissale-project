<?php
$field_error = !empty($this->validationErrors[$model_class][$field]) ? $this->validationErrors[$model_class][$field] : array();
$field_error_clss = !empty($field_error) ? 'has-error' : '';
?>
<div class="form-group <?php echo $field_error_clss ?>">
    <?php
    $attrs = array(
        'class' => 'form-control',
        'label' => $label,
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
    <?php if (!empty($label)):
        ?>
        <label><?php echo $label ?></label>
    <?php endif; ?>
    <?php
    echo $this->Form->textarea($field, $attrs);
    ?>
    <?php if (!empty($field_error)): ?>
        <span class="help-block"><?php echo implode(' ,', $field_error) ?></span>
    <?php endif; ?>
</div>