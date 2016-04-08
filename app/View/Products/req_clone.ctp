<div class="form-body">
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo __('product_color') ?></label>
        <div class="col-md-9">
            <?php
            echo $this->Form->hidden('id', array(
                'class' => 'form-control product-clone-id',
            ));
            echo $this->element('form/input', array(
                'field' => 'color',
                'label' => false,
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo __('product_size') ?></label>
        <div class="col-md-9">
            <?php
            echo $this->element('form/input', array(
                'field' => 'size',
                'label' => false,
            ));
            ?>
        </div>
    </div>
</div>