<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'field' => 'code',
        'label' => false,
    ));
    ?>
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
        'field' => 'module',
        'label' => false,
    ));
    ?>
</td>
<td>
    <?php
    echo $this->element('form/input', array(
        'field' => 'description',
        'label' => false,
    ));
    ?>
</td>