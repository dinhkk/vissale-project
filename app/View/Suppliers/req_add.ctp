<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td colspan="7">
    <div class="row">
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'name',
                'label' => __('supplier_name'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'phone',
                'label' => __('supplier_phone'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'note',
                'label' => __('supplier_note'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'address',
                'label' => __('supplier_address'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'tax_code',
                'label' => __('supplier_tax_code'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'email',
                'label' => __('supplier_email'),
            ));
            ?>
        </div>
    </div>
</td>