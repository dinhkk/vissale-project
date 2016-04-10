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
    <div class="input-group input-medium date date-picker-field">
        <?php
        echo $this->element('form/input', array(
            'field' => 'begin_at',
            'label' => false,
            'readonly' => true,
        ));
        ?>
        <span class="input-group-btn">
            <button class="btn default" type="button">
                <i class="fa fa-calendar"></i>
            </button>
        </span>
    </div>
</td>
<td>
    <div class="input-group input-medium date date-picker-field">
        <?php
        echo $this->element('form/input', array(
            'field' => 'end_at',
            'label' => false,
            'readonly' => true,
        ));
        ?>
        <span class="input-group-btn">
            <button class="btn default" type="button">
                <i class="fa fa-calendar"></i>
            </button>
        </span>
    </div>
</td>
<td>

</td>