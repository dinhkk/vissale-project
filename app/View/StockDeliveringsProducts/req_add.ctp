<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form-product-<?php echo $stock_delivering_id ?>"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td colspan="8">
    <div class="row">
        <div class="col-md-6">
            <?php
            echo $this->Form->hidden('stock_delivering_id', array(
                'class' => 'form-control',
                'value' => $stock_delivering_id,
            ));

            echo $this->element('form/input', array(
                'field' => 'product_id',
                'label' => __('product_alias'),
                'options' => $products,
                'empty' => '',
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            echo $this->element('form/input', array(
                'field' => 'qty',
                'label' => __('product_qty'),
                'type' => 'number',
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            echo $this->element('form/input', array(
                'field' => 'price',
                'label' => __('product_price'),
                'type' => 'number',
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            echo $this->element('form/input', array(
                'field' => 'total_price',
                'label' => __('product_total_price'),
                'type' => 'number',
            ));
            ?>
        </div>
    </div>
</td>