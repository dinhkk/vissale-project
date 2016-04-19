<?php
echo $this->element('breadcrumb');
echo $this->element('plugins/datepicker');
echo $this->element('plugins/select2');
?>
<?php
echo $this->start('script');
?>
<script>
    $(function () {

        $.fn.select2.defaults.set("theme", "bootstrap");
        var placeholder = "Select a State";

        $(".select2, .select2-multiple").select2({
            placeholder: placeholder,
            width: null
        });

        $(document).on('fbsale.ajaxsearch', function () {
            $(".select2, .select2-multiple").select2({
                placeholder: placeholder,
                width: null
            });
        });
    });
</script>
<?php
echo $this->end();
?>
<div class="row ajax-search-form">
    <div class="col-md-3">
        <div class="form-group">
            <div>
                <label><?php echo __('inventory_date_range') ?></label>
            </div>
            <div class="input-group input-medium date-picker input-daterange" >
                <?php
                echo $this->Form->input('begin_at', array(
                    'name' => 'begin_at',
                    'div' => false,
                    'label' => false,
                    'value' => $this->request->query('begin_at'),
                    'readonly' => true,
                    'class' => 'form-control',
                ));
                ?>
                <span class="input-group-addon"> to </span>
                <?php
                echo $this->Form->input('end_at', array(
                    'name' => 'end_at',
                    'div' => false,
                    'label' => false,
                    'value' => $this->request->query('end_at'),
                    'readonly' => true,
                    'class' => 'form-control',
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php
            echo $this->Form->input('product_id', array(
                'name' => 'product_id',
                'options' => $products,
                'empty' => '',
                'class' => 'form-control ajax-input select2-multiple',
                'div' => false,
                'label' => __('inventory_product_id'),
                'value' => $this->request->query('product_id'),
                'multiple' => true,
            ));
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php
            echo $this->Form->input('stock_id', array(
                'name' => 'stock_id',
                'options' => $stocks,
                'class' => 'form-control ajax-input',
                'div' => false,
                'label' => __('inventory_stock_id'),
                'value' => $this->request->query('stock_id'),
            ));
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <div>
            <label style="visibility: hidden"><?php echo __('search_btn') ?></label>
        </div>
        <div>
            <button type="button" class="btn blue ajax-search-submit"><?php echo __('search_btn') ?></button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body" data-action="<?php
        echo Router::url(array(
            'action' => $this->action,
            '?' => $this->request->query,
        ));
        ?>">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-3">
                        <div class="btn-group">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div id="datatable_ajax_wrapper" class="dataTables_wrapper dataTables_extended_wrapper no-footer pull-right">
                            <div class="dataTables_paginate paging_bootstrap_extended" id="datatable_ajax_paginate">
                                <div class="pagination-panel"> Page 
                                    <?php
                                    echo $this->Paginator->prev('<i class="fa fa-angle-left"></i>', array(
                                        'tag' => 'span',
                                        'escape' => false,
                                        'class' => 'btn btn-sm default prev',
                                            ), null, array(
                                        'class' => 'btn btn-sm default prev disabled',
                                        'tag' => 'span',
                                        'escape' => false,
                                        'disabledTag' => '',
                                    ));
                                    ?>
                                    <?php
                                    echo $this->Form->input('page', array(
                                        'default' => $this->Paginator->counter('{:page}'),
                                        'name' => 'page',
                                        'class' => 'pagination-panel-input form-control input-sm input-inline input-mini ajax-page ajax-control ajax-input',
                                        'label' => false,
                                        'div' => false,
                                        'style' => 'text-align:center; margin: 0 5px;',
                                        'maxlenght' => 5,
                                        'value' => $this->request->query('page'),
                                    ));
                                    ?>
                                    <?php
                                    echo $this->Paginator->next('<i class="fa fa-angle-right"></i>', array(
                                        'tag' => 'span',
                                        'escape' => false,
                                        'class' => 'btn btn-sm default next',
                                            ), null, array(
                                        'class' => 'btn btn-sm default next disabled',
                                        'tag' => 'span',
                                        'escape' => false,
                                        'disabledTag' => '',
                                    ));
                                    ?>
                                    of <span class="pagination-panel-total">
                                        <?php
                                        echo $this->Paginator->counter('{:pages}');
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="dataTables_length" id="datatable_ajax_length">
                                <label>
                                    <span class="seperator">|</span>View 
                                    <?php
                                    echo $this->Form->input('limit', array(
                                        'options' => $limits,
                                        'default' => LIMIT_DEFAULT,
                                        'name' => 'limit',
                                        'class' => 'form-control input-xs input-sm input-inline ajax-limit ajax-control ajax-input',
                                        'label' => false,
                                        'div' => false,
                                        'value' => $this->request->query('limit'),
                                    ));
                                    ?>
                                    records
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo __('inventory_stock') ?></th>
                            <th colspan="2"><?php echo __('inventory_product') ?></th>
                            <th><?php echo __('inventory_opening_qty') ?></th>
                            <th><?php echo __('inventory_receiving_qty') ?></th>
                            <th><?php echo __('inventory_delivering_qty') ?></th>
                            <th><?php echo __('inventory_closing_qty') ?></th>
                            <th colspan="2"><?php echo __('inventory_qty_forecast') ?></th>
                        </tr>
                        <tr>
                            <?php if (!empty($list_data)): ?>
                                <th><?php echo __('inventory_stock_code') ?></th>
                                <th><?php echo __('inventory_product_alias') ?></th>
                                <th><?php echo __('inventory_product_name') ?></th>
                                <th><?php echo __('inventory_qty') ?></th>
                                <th><?php echo __('inventory_qty') ?></th>
                                <th><?php echo __('inventory_qty') ?></th>
                                <th><?php echo __('inventory_qty') ?></th>
                                <th><?php echo __('inventory_receiving_qty_forecast') ?></th>
                                <th><?php echo __('inventory_delivering_qty_forecast') ?></th>
                            <?php else: ?>
                                <th><?php echo __('inventory_stock_code') ?></th>
                                <th><?php echo __('inventory_alias') ?></th>
                                <th><?php echo __('inventory_product_name') ?></th>
                                <th><?php echo __('inventory_opening_qty') ?></th>
                                <th><?php echo __('inventory_receiving_qty') ?></th>
                                <th><?php echo __('inventory_delivering_qty') ?></th>
                                <th><?php echo __('inventory_closing_qty') ?></th>
                                <th><?php echo __('inventory_receiving_qty_forecast') ?></th>
                                <th><?php echo __('inventory_delivering_qty_forecast') ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list_data)): ?>
                            <?php foreach ($list_data as $item): ?>
                                <?php
                                $id = $item['Product']['id'];
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo!empty($stock_codes[$stock_id]) ?
                                                $stock_codes[$stock_id] : __('unknown');
                                        ?>
                                    </td>
                                    <td><?php echo h($item['Product']['alias']) ?></td>
                                    <td><?php echo h($item['Product']['name']) ?></td>
                                    <td><?php echo number_format($item['Product']['opening_qty']) ?></td>
                                    <td><?php echo number_format($item['Product']['receiving_qty']) ?></td>
                                    <td><?php echo number_format($item['Product']['delivering_qty']) ?></td>
                                    <td><?php echo number_format($item['Product']['closing_qty']) ?></td>
                                    <td><?php echo number_format($item['Product']['receiving_qty_forecast']) ?></td>
                                    <td><?php echo number_format($item['Product']['delivering_qty_forecast']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="center"><?php echo __('no_result') ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
