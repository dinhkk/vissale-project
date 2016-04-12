<td>
    <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
    <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
</td>
<td colspan="7">
    <div class="row">
        <div class="col-md-4">
            <?php
            echo $this->Form->hidden('no', array(
                'class' => 'form-control',
                'value' => $no,
            ));

            echo $this->element('form/input', array(
                'field' => 'code',
                'label' => __('stock_delivering_code'),
                'readonly' => true,
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'description',
                'label' => __('stock_delivering_description'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/date', array(
                'field' => 'received',
                'label' => __('stock_delivering_received'),
                'div' => false,
                'readonly' => true,
                'default' => date('Y-m-d'),
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'stock_book_id',
                'label' => __('stock_delivering_stock_book_id'),
                'options' => $stock_books,
                'empty' => '',
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'stock_id',
                'label' => __('stock_delivering_stock_id'),
                'options' => $stocks,
                'empty' => '',
            ));
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $this->element('form/input', array(
                'field' => 'supplier_id',
                'label' => __('stock_delivering_supplier_id'),
                'options' => $suppliers,
                'empty' => '',
            ));
            ?>
        </div>
        <div class="col-md-12">
            <?php
            echo $this->element('form/textarea', array(
                'field' => 'note',
                'label' => __('stock_delivering_note'),
            ));
            ?>
        </div>
    </div>
</td>