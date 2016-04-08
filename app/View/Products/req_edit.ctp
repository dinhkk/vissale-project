<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="edit-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td colspan="9">
    <div class="row">
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
                'field' => 'code',
                'label' => __('product_code'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'price',
                'label' => __('product_price'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'name',
                'label' => __('product_name'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'unit_id',
                'label' => __('product_unit_id'),
                'options' => $units,
                'empty' => '',
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'made_in',
                'label' => __('product_made_in'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'bundle_id',
                'label' => __('product_bundle_id'),
                'options' => $bundles,
                'empty' => '',
            ));
            ?>
        </div>
    </div>
</td>