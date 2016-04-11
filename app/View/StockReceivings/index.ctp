<?php
echo $this->element('breadcrumb');
echo $this->element('plugins/datepicker');
?>
<?php
echo $this->start('script');
?>
<script>
    $(function () {
        $('body').on('show.bs.collapse', '.detail-form', function () {

            var $container = $(this).find('.detail-container');
            var action = $(this).data('action');
            var req = $.get(action, {}, function (html) {
                $container.html(html);
            });

            req.error(function (xhr, status, error) {
                alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
            });
        });
    });
</script>
<?php
echo $this->end();
?>
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
                            <button class="btn green" data-toggle="collapse" data-target="#add-form"> <?php echo __('add_btn') ?>
                                <i class="fa fa-plus"></i>
                            </button>
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
                            <?php if (!empty($list_data)): ?>
                                <th><?php echo __('operation') ?></th>
                                <th><?php echo __('stock_receiving_code') ?></th>
                                <th><?php echo __('stock_receiving_description') ?></th>
                                <th><?php echo __('stock_receiving_received') ?></th>
                                <th><?php echo __('stock_receiving_stock_book_id') ?></th>
                                <th><?php echo __('stock_receiving_stock_id') ?></th>
                                <th><?php echo __('stock_receiving_supplier_id') ?></th>
                                <th><?php echo __('stock_receiving_note') ?></th>
                            <?php else: ?>
                                <th><?php echo __('operation') ?></th>
                                <th><?php echo __('stock_receiving_code') ?></th>
                                <th><?php echo __('stock_receiving_description') ?></th>
                                <th><?php echo __('stock_receiving_received') ?></th>
                                <th><?php echo __('stock_receiving_stock_book_id') ?></th>
                                <th><?php echo __('stock_receiving_stock_id') ?></th>
                                <th><?php echo __('stock_receiving_supplier_id') ?></th>
                                <th><?php echo __('stock_receiving_note') ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="search-form" class="ajax-search-form">
                            <td>
                                <button type="button" class="btn blue ajax-search-submit"><?php echo __('search_btn') ?></button>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('code', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'code',
                                    'value' => $this->request->query('code'),
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('description', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'description',
                                    'value' => $this->request->query('description'),
                                ));
                                ?>
                            </td>
                            <td>
                                <div class="input-group input-medium date date-picker">
                                    <?php
                                    echo $this->Form->input('received', array(
                                        'class' => 'form-control',
                                        'label' => false,
                                        'name' => 'received',
                                        'value' => $this->request->query('received'),
                                        'div' => false,
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
                                <?php
                                echo $this->Form->input('stock_book_id', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'stock_book_id',
                                    'value' => $this->request->query('stock_book_id'),
                                    'options' => $stock_books,
                                    'empty' => '',
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('stock_id', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'stock_id',
                                    'value' => $this->request->query('stock_id'),
                                    'options' => $stocks,
                                    'empty' => '',
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('supplier_id', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'supplier_id',
                                    'value' => $this->request->query('supplier_id'),
                                    'options' => $suppliers,
                                    'empty' => '',
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('note', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'note',
                                    'value' => $this->request->query('note'),
                                ));
                                ?>
                            </td>
                        </tr>
                        <tr id="add-form" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqAdd'), true) ?>">
                            <td>
                                <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
                                <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
                            </td>
                            <td colspan="7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('code', array(
                                            'class' => 'form-control',
                                            'label' => __('stock_receiving_code'),
                                            'readonly' => true,
                                            'default' => $code,
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('description', array(
                                            'class' => 'form-control',
                                            'label' => __('stock_receiving_description'),
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label><?php echo __('stock_receiving_received') ?></label>
                                        <div class="input-group input-medium date date-picker-field">
                                            <?php
                                            echo $this->Form->input('received', array(
                                                'class' => 'form-control',
                                                'div' => false,
                                                'readonly' => true,
                                                'label' => false,
                                                'default' => date('Y-m-d'),
                                            ));
                                            ?>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('stock_book_id', array(
                                            'class' => 'form-control',
                                            'label' => __('stock_receiving_stock_book_id'),
                                            'options' => $stock_books,
                                            'empty' => '',
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('stock_id', array(
                                            'class' => 'form-control',
                                            'label' => __('stock_receiving_stock_id'),
                                            'options' => $stocks,
                                            'empty' => '',
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('supplier_id', array(
                                            'class' => 'form-control',
                                            'label' => __('stock_receiving_supplier_id'),
                                            'options' => $suppliers,
                                            'empty' => '',
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label><?php echo __('stock_receiving_note') ?></label>
                                        <?php
                                        echo $this->Form->textarea('note', array(
                                            'class' => 'form-control',
                                            'label' => __('stock_receiving_note'),
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php if (!empty($list_data)): ?>
                            <?php foreach ($list_data as $item): ?>
                                <?php
                                $id = $item[$model_class]['id'];
                                ?>
                                <tr>
                                    <td>
                                        <button type="button" class="btn green" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('edit_btn') ?></button>
                                        <button type="button" class="btn purple" data-toggle="collapse" data-target="#detail-form-<?php echo $id ?>"><?php echo __('detail_btn') ?></button>
                                        <button type="button" class="btn red ajax-delete" data-action="<?php echo Router::url(array('action' => 'reqDelete', $id), true) ?>" ><?php echo __('delete_btn') ?></button>
                                    </td>
                                    <td><?php echo h($item[$model_class]['code']) ?></td>
                                    <td><?php echo h($item[$model_class]['description']) ?></td>
                                    <td><?php echo h($item[$model_class]['received']) ?></td>
                                    <td>
                                        <?php
                                        echo!empty($stock_books[$item[$model_class]['stock_book_id']]) ?
                                                $stock_books[$item[$model_class]['stock_book_id']] : __('unknown');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo!empty($stocks[$item[$model_class]['stock_id']]) ?
                                                $stocks[$item[$model_class]['stock_id']] : __('unknown');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo!empty($suppliers[$item[$model_class]['supplier_id']]) ?
                                                $suppliers[$item[$model_class]['supplier_id']] : __('unknown');
                                        ?>
                                    </td>
                                    <td><?php echo h($item[$model_class]['note']) ?></td>
                                </tr>
                                <tr id="edit-form-<?php echo $id ?>" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
                                    <td>
                                        <button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
                                        <button type="button" class="btn blue ajax-submit" id="edit-form-submit"><?php echo __('save_btn') ?></button>
                                    </td>
                                    <td colspan="7">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->hidden('id', array(
                                                    'class' => 'form-control',
                                                    'value' => $item[$model_class]['id'],
                                                ));

                                                echo $this->Form->input('code', array(
                                                    'class' => 'form-control',
                                                    'label' => __('stock_receiving_code'),
                                                    'value' => $item[$model_class]['code'],
                                                    'readonly' => true,
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('description', array(
                                                    'class' => 'form-control',
                                                    'label' => __('stock_receiving_description'),
                                                    'value' => $item[$model_class]['description'],
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <label><?php echo __('stock_receiving_received') ?></label>
                                                <div class="input-group input-medium date date-picker-field">
                                                    <?php
                                                    echo $this->Form->input('received', array(
                                                        'class' => 'form-control',
                                                        'div' => false,
                                                        'readonly' => true,
                                                        'label' => false,
                                                        'default' => date('Y-m-d'),
                                                        'value' => $item[$model_class]['received'],
                                                    ));
                                                    ?>
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('stock_book_id', array(
                                                    'class' => 'form-control',
                                                    'label' => __('stock_receiving_stock_book_id'),
                                                    'options' => $stock_books,
                                                    'empty' => '',
                                                    'value' => $item[$model_class]['stock_book_id'],
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('stock_id', array(
                                                    'class' => 'form-control',
                                                    'label' => __('stock_receiving_stock_id'),
                                                    'options' => $stocks,
                                                    'empty' => '',
                                                    'value' => $item[$model_class]['stock_id'],
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('supplier_id', array(
                                                    'class' => 'form-control',
                                                    'label' => __('stock_receiving_supplier_id'),
                                                    'options' => $suppliers,
                                                    'empty' => '',
                                                    'value' => $item[$model_class]['supplier_id'],
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-12">
                                                <label><?php echo __('stock_receiving_note') ?></label>
                                                <?php
                                                echo $this->Form->textarea('note', array(
                                                    'class' => 'form-control',
                                                    'label' => __('stock_receiving_note'),
                                                    'value' => $item[$model_class]['note'],
                                                ));
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="detail-form-<?php echo $id ?>" class="collapse detail-form" data-action="<?php
                                echo Router::url(array(
                                    'controller' => 'StockBooksProducts',
                                    'action' => 'reqIndex',
                                    $id,
                                        ), true)
                                ?>">
                                    <td colspan="8" class="ajax-container detail-container" data-action="<?php
                                    echo Router::url(array(
                                        'controller' => 'StockBooksProducts',
                                        'action' => 'reqIndex',
                                        $id,
                                            ), true)
                                    ?>">

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="center"><?php echo __('no_result') ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
