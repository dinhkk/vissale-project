<?php
echo $this->element('breadcrumb');
//echo $this->element('plugins/datatables');
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
            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                <thead>
                    <tr>
                        <?php if (!empty($list_data)): ?>
                            <th><?php echo __('operation') ?></th>
                            <th><?php echo __('stock_book_code') ?></th>
                            <th><?php echo __('stock_book_name') ?></th>
                            <th><?php echo __('stock_book_begin_at') ?></th>
                            <th><?php echo __('stock_book_end_at') ?></th>
                            <th><?php echo __('stock_book_is_locked') ?></th>
                        <?php else: ?>
                            <th><?php echo __('operation') ?></th>
                            <th><?php echo __('stock_book_code') ?></th>
                            <th><?php echo __('stock_book_name') ?></th>
                            <th><?php echo __('stock_book_begin_at') ?></th>
                            <th><?php echo __('stock_book_end_at') ?></th>
                            <th><?php echo __('stock_book_is_locked') ?></th>
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
                            echo $this->Form->input('name', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'name',
                                'value' => $this->request->query('name'),
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('begin_at', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'name',
                                'value' => $this->request->query('begin_at'),
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('end_at', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'name',
                                'value' => $this->request->query('end_at'),
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('is_locked', array(
                                'class' => 'form-control ajax-input',
                                'label' => false,
                                'name' => 'name',
                                'value' => $this->request->query('is_locked'),
                                'options' => $is_locked,
                                'empty' => '',
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr id="add-form" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqAdd'), true) ?>">
                        <td>
                            <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
                            <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('code', array(
                                'class' => 'form-control',
                                'label' => false,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('name', array(
                                'class' => 'form-control',
                                'label' => false,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('begin_at', array(
                                'class' => 'form-control',
                                'label' => false,
                            ));
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->input('end_at', array(
                                'class' => 'form-control',
                                'label' => false,
                            ));
                            ?>
                        </td>
                        <td>

                        </td>
                    </tr>
                    <?php if (!empty($list_data)): ?>
                        <?php foreach ($list_data as $item): ?>
                            <?php
                            $id = $item[$model_class]['id'];
                            ?>
                            <tr>
                                <td>
                                    <button type="button" class="btn green accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-target="#detail-form-<?php echo $id ?>"><?php echo __('detail_btn') ?></button>
                                </td>
                                <td><?php echo h($item[$model_class]['code']) ?></td>
                                <td><?php echo h($item[$model_class]['name']) ?></td>
                                <td><?php echo h($item[$model_class]['begin_at']) ?></td>
                                <td><?php echo h($item[$model_class]['end_at']) ?></td>
                                <td>
                                    <?php
                                    echo!empty($is_locked[$item[$model_class]['is_locked']]) ?
                                            $is_locked[$item[$model_class]['is_locked']] : __('unknown');
                                    ?>
                                </td>
                            </tr>
                            <tr id="detail-form-<?php echo $id ?>" class="collapse detail-form" data-action="<?php
                            echo Router::url(array(
                                'controller' => 'StockBooksProducts',
                                'action' => 'reqIndex',
                                $id,
                                    ), true)
                            ?>">
                                <td colspan="6" class="ajax-container detail-container" data-action="<?php
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
                            <td colspan="6" class="center"><?php echo __('no_result') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
