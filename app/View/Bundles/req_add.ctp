<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td>
    <?php
    $name_error = !empty($this->validationErrors[$model_class]['name']) ? $this->validationErrors[$model_class]['name'] : array();
    $name_error_clss = !empty($name_error) ? 'has-error' : '';
    ?>
    <div class="form-group <?php echo $name_error_clss ?>">
        <?php
        echo $this->Form->input('name', array(
            'class' => 'form-control',
            'label' => false,
            'div' => false,
        ));
        ?>
        <?php if (!empty($name_error)): ?>
            <span class="help-block"><?php echo implode(' ,', $name_error) ?></span>
        <?php endif; ?>
    </div>
</td>