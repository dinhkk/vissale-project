<table class="table table-striped table-hover table-bordered" >
    <thead>
        <tr>
            <?php if (!empty($list_data)): ?>
                <th>
                    <button class="btn green" data-toggle="collapse" data-target="#add-form-product-<?php echo $stock_delivering_id ?>"> <?php echo __('add_btn') ?>
                        <i class="fa fa-plus"></i>
                    </button>
                </th>
                <th><?php echo __('product_code') ?></th>
                <th><?php echo __('product_alias') ?></th>
                <th><?php echo __('product_name') ?></th>
                <th><?php echo __('product_color') ?></th>
                <th><?php echo __('product_size') ?></th>
                <th><?php echo __('product_qty') ?></th>
                <th><?php echo __('product_price') ?></th>
                <th><?php echo __('product_total_price') ?></th>
            <?php else: ?>
                <th>
                    <button class="btn green" data-toggle="collapse" data-target="#add-form-product-<?php echo $stock_delivering_id ?>"> <?php echo __('add_btn') ?>
                        <i class="fa fa-plus"></i>
                    </button>
                </th>
                <th><?php echo __('product_code') ?></th>
                <th><?php echo __('product_alias') ?></th>
                <th><?php echo __('product_name') ?></th>
                <th><?php echo __('product_color') ?></th>
                <th><?php echo __('product_size') ?></th>
                <th><?php echo __('product_qty') ?></th>
                <th><?php echo __('product_price') ?></th>
                <th><?php echo __('product_total_price') ?></th>
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
                echo $this->Form->input('product_code', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'product_code',
                    'value' => $this->request->query('product_code'),
                ));
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->input('product_alias', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'product_alias',
                    'value' => $this->request->query('product_alias'),
                ));
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->input('product_name', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'product_name',
                    'value' => $this->request->query('product_name'),
                ));
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->input('product_color', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'product_color',
                    'value' => $this->request->query('product_color'),
                ));
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->input('product_size', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'product_size',
                    'value' => $this->request->query('product_size'),
                ));
                ?>
            </td>
            <td>
                <?php
                echo $this->Form->input('qty', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'qty',
                    'value' => $this->request->query('qty'),
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
            <td>
                <?php
                echo $this->Form->input('total_price', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'total_price',
                    'value' => $this->request->query('total_price'),
                ));
                ?>
            </td>
        </tr>
        <tr id="add-form-product-<?php echo $stock_delivering_id ?>" class="collapse ajax-form add-form-product" data-action="<?php echo Router::url(array('action' => 'reqAdd', $stock_delivering_id), true) ?>">
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

                        echo $this->Form->input('product_id', array(
                            'class' => 'form-control',
                            'label' => __('product_alias'),
                            'options' => $products,
                            'empty' => '',
                        ));
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo $this->Form->input('qty', array(
                            'class' => 'form-control',
                            'label' => __('product_qty'),
                            'type' => 'number',
                        ));
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo $this->Form->input('price', array(
                            'class' => 'form-control',
                            'label' => __('product_price'),
                            'type' => 'number',
                        ));
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        echo $this->Form->input('total_price', array(
                            'class' => 'form-control',
                            'label' => __('product_total_price'),
                            'type' => 'number',
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
                        <button type="button" class="btn green" data-toggle="collapse" data-target="#edit-form-product-<?php echo $stock_delivering_id ?>-<?php echo $id ?>"><?php echo __('edit_btn') ?></button>
                        <button type="button" class="btn red ajax-delete" data-action="<?php echo Router::url(array('action' => 'reqDelete', $id), true) ?>" ><?php echo __('delete_btn') ?></button>
                    </td>
                    <td>
                        <?php
                        echo!empty($item['Product']['code']) ?
                                h($item['Product']['code']) : h($item[$model_class]['product_code']);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo!empty($item['Product']['alias']) ?
                                h($item['Product']['alias']) : h($item[$model_class]['product_alias']);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo!empty($item['Product']['name']) ?
                                h($item['Product']['name']) : h($item[$model_class]['product_name']);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo!empty($item['Product']['color']) ?
                                h($item['Product']['color']) : h($item[$model_class]['product_color']);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo!empty($item['Product']['size']) ?
                                h($item['Product']['size']) : h($item[$model_class]['product_size']);
                        ?>
                    </td>
                    <td><?php echo number_format($item[$model_class]['qty']) ?></td>
                    <td><?php echo number_format($item[$model_class]['price']) ?></td>
                    <td><?php echo number_format($item[$model_class]['total_price']) ?></td>
                </tr>
                <tr id="edit-form-product-<?php echo $stock_delivering_id ?>-<?php echo $id ?>" class="collapse ajax-form add-form-product" data-action="<?php echo Router::url(array('action' => 'reqEdit', $id), true) ?>">
                    <td>
                        <button type="button" class="btn default" data-toggle="collapse" data-target="#edit-form-product-<?php echo $id ?>"><?php echo __('cancel_btn') ?></button>
                        <button type="button" class="btn blue ajax-submit" id="add-form-submit"><?php echo __('save_btn') ?></button>
                    </td>
                    <td colspan="8">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                echo $this->Form->hidden('id', array(
                                    'class' => 'form-control',
                                    'value' => $id,
                                ));

                                echo $this->Form->input('product_id', array(
                                    'class' => 'form-control',
                                    'label' => __('product_alias'),
                                    'options' => $products,
                                    'empty' => '',
                                    'value' => $item[$model_class]['product_id'],
                                ));
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                echo $this->Form->input('qty', array(
                                    'class' => 'form-control',
                                    'label' => __('product_qty'),
                                    'type' => 'number',
                                    'value' => $item[$model_class]['qty'],
                                ));
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                echo $this->Form->input('price', array(
                                    'class' => 'form-control',
                                    'label' => __('product_price'),
                                    'type' => 'number',
                                    'value' => $item[$model_class]['price'],
                                ));
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                echo $this->Form->input('total_price', array(
                                    'class' => 'form-control',
                                    'label' => __('product_total_price'),
                                    'type' => 'number',
                                    'value' => $item[$model_class]['total_price'],
                                ));
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" class="center"><?php echo __('no_result') ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>