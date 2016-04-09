<?php
echo $this->element('breadcrumb');
//echo $this->element('plugins/datatables');
?>
<?php
echo $this->start('script');
?>
<script>
    $(function () {
        $('body').on('click', '.clone-btn', function () {
            var id = $(this).data('id');
            var action = $(this).data('action');
            $('.product-clone-form').data('id', id);
            $('.product-clone-form').data('action', action);
            $('.product-clone-id').val(id);
        });
        $('body').on('click', '.product-clone-submit', function () {
            var action = $('.product-clone-form').data('action');
            var $form = $('.product-clone-form');
            var data = $form.find(':input').serialize();
            var req = $.post(action, data, function (res) {
                if (res.error === 0) {
                    alert('<?php echo __('save_successful_message') ?>');
                    $('#product-clone').modal('hide');
                    fbsale.ajaxForm.reload();
                } else {
                    var html = res.data.html;
                    $form.html(html);
                }
            }, 'json');

            req.error(function (xhr, status, error) {
                alert("An AJAX error occured: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);
            });
        });
    });
</script>
<?php echo $this->end(); ?>
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
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <?php if (!empty($list_data)): ?>
                                <th><?php echo __('operation') ?></th>
                                <th><?php echo __('product_code') ?></th>
                                <th><?php echo __('product_alias') ?></th>
                                <th><?php echo __('product_name') ?></th>
                                <th><?php echo __('product_color') ?></th>
                                <th><?php echo __('product_size') ?></th>
                                <th><?php echo __('product_unit_id') ?></th>
                                <th><?php echo __('product_made_in') ?></th>
                                <th><?php echo __('product_bundle_id') ?></th>
                                <th><?php echo __('product_price') ?></th>
                            <?php else: ?>
                                <th><?php echo __('operation') ?></th>
                                <th><?php echo __('product_code') ?></th>
                                <th><?php echo __('product_alias') ?></th>
                                <th><?php echo __('product_name') ?></th>
                                <th><?php echo __('product_color') ?></th>
                                <th><?php echo __('product_size') ?></th>
                                <th><?php echo __('product_unit_id') ?></th>
                                <th><?php echo __('product_made_in') ?></th>
                                <th><?php echo __('product_bundle_id') ?></th>
                                <th><?php echo __('product_price') ?></th>
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
                                echo $this->Form->input('alias', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'alias',
                                    'value' => $this->request->query('alias'),
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
                                echo $this->Form->input('color', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'color',
                                    'value' => $this->request->query('color'),
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('size', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'size',
                                    'value' => $this->request->query('size'),
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('unit_id', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'unit_id',
                                    'value' => $this->request->query('unit_id'),
                                    'options' => $units,
                                    'empty' => '',
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('made_in', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'made_in',
                                    'value' => $this->request->query('made_in'),
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('product_id', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'product_id',
                                    'value' => $this->request->query('product_id'),
                                    'options' => $bundles,
                                    'empty' => '',
                                ));
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $this->Form->input('price', array(
                                    'class' => 'form-control ajax-input',
                                    'label' => false,
                                    'name' => 'price',
                                    'value' => $this->request->query('price'),
                                ));
                                ?>
                            </td>
                        </tr>
                        <tr id="add-form" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqAdd'), true) ?>">
                            <td>
                                <button type="button" class="btn default" data-toggle="collapse" data-target="#add-form"><?php echo __('cancel_btn') ?></button>
                                <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
                            </td>
                            <td colspan="9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('code', array(
                                            'class' => 'form-control',
                                            'label' => __('product_code'),
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('price', array(
                                            'class' => 'form-control',
                                            'label' => __('product_price'),
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('name', array(
                                            'class' => 'form-control',
                                            'label' => __('product_name'),
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('unit_id', array(
                                            'class' => 'form-control',
                                            'label' => __('product_unit_id'),
                                            'options' => $units,
                                            'empty' => '',
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('made_in', array(
                                            'class' => 'form-control',
                                            'label' => __('product_made_in'),
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo $this->Form->input('bundle_id', array(
                                            'class' => 'form-control',
                                            'label' => __('product_bundle_id'),
                                            'options' => $bundles,
                                            'empty' => '',
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
                                        <button type="button" class="btn purple clone-btn"  data-target="#product-clone" data-toggle="modal" data-id="<?php echo $id ?>" data-action="<?php echo Router::url(array('action' => 'reqClone', $id), true) ?>"><?php echo __('product_clone_btn') ?></button>
                                        <button type="button" class="btn red ajax-delete" data-action="<?php echo Router::url(array('action' => 'reqDelete', $id), true) ?>" ><?php echo __('delete_btn') ?></button>
                                    </td>
                                    <td>
                                        <?php echo h($item[$model_class]['code']) ?>
                                    </td>
                                    <td>
                                        <?php echo h($item[$model_class]['alias']) ?>
                                    </td>
                                    <td>
                                        <?php echo h($item[$model_class]['name']) ?>
                                    </td>
                                    <td>
                                        <?php echo h($item[$model_class]['color']) ?>
                                    </td>
                                    <td>
                                        <?php echo h($item[$model_class]['size']) ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo!empty($units[$item[$model_class]['unit_id']]) ?
                                                $units[$item[$model_class]['unit_id']] : __('unknown');
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo h($item[$model_class]['made_in']) ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo!empty($bundles[$item[$model_class]['bundle_id']]) ?
                                                $bundles[$item[$model_class]['bundle_id']] : __('unknown');
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo h($item[$model_class]['price']) ?>
                                    </td>
                                </tr>
                                <tr id="edit-form-<?php echo $id ?>" class="collapse ajax-form" data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
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
                                                echo $this->Form->input('code', array(
                                                    'class' => 'form-control',
                                                    'label' => __('product_code'),
                                                    'value' => $item[$model_class]['code'],
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('price', array(
                                                    'class' => 'form-control',
                                                    'label' => __('product_price'),
                                                    'value' => $item[$model_class]['price'],
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('name', array(
                                                    'class' => 'form-control',
                                                    'label' => __('product_name'),
                                                    'value' => $item[$model_class]['name'],
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('unit_id', array(
                                                    'class' => 'form-control',
                                                    'label' => __('product_unit_id'),
                                                    'value' => $item[$model_class]['unit_id'],
                                                    'options' => $units,
                                                    'empty' => '',
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('made_in', array(
                                                    'class' => 'form-control',
                                                    'label' => __('product_made_in'),
                                                    'value' => $item[$model_class]['made_in'],
                                                ));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php
                                                echo $this->Form->input('bundle_id', array(
                                                    'class' => 'form-control',
                                                    'label' => __('product_bundle_id'),
                                                    'value' => $item[$model_class]['bundle_id'],
                                                    'options' => $bundles,
                                                    'empty' => '',
                                                ));
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="center"><?php echo __('no_result') ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="product-clone" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?php echo __('product_clone_title') ?></h4>
            </div>
            <div class="modal-body">
                <div class="portlet-body form">
                    <form class="form-horizontal product-clone-form" role="form">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('product_color') ?></label>
                                <div class="col-md-9">
                                    <?php
                                    echo $this->Form->hidden('id', array(
                                        'class' => 'form-control product-clone-id',
                                    ));
                                    echo $this->Form->input('color', array(
                                        'class' => 'form-control',
                                        'label' => false,
                                        'div' => false,
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('product_size') ?></label>
                                <div class="col-md-9">
                                    <?php
                                    echo $this->Form->input('size', array(
                                        'class' => 'form-control',
                                        'label' => false,
                                        'div' => false,
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline"><?php echo __('close_btn') ?></button>
                <button type="button" class="btn green product-clone-submit"><?php echo __('save_btn') ?></button>
            </div>
        </div>
    </div>
</div>
