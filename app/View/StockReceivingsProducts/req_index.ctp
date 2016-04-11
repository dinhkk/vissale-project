<table class="table table-striped table-hover table-bordered" >
    <thead>
        <tr>
            <?php if (!empty($list_data)): ?>
                <th><?php echo __('operation') ?></th>
                <th><?php echo __('product_alias') ?></th>
                <th><?php echo __('product_qty') ?></th>
                <th><?php echo __('product_total_price') ?></th>
                <th><?php echo __('product_stock_code') ?></th>
            <?php else: ?>
                <th><?php echo __('operation') ?></th>
                <th><?php echo __('product_alias') ?></th>
                <th><?php echo __('product_qty') ?></th>
                <th><?php echo __('product_total_price') ?></th>
                <th><?php echo __('product_stock_code') ?></th>
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
                echo $this->Form->input('product_qty', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'qty',
                    'value' => $this->request->query('qty'),
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
            <td>
                <?php
                echo $this->Form->input('stock_code', array(
                    'class' => 'form-control ajax-input',
                    'label' => false,
                    'name' => 'stock_code',
                    'value' => $this->request->query('stock_code'),
                ));
                ?>
            </td>
        </tr>
        <?php if (!empty($list_data)): ?>
            <?php foreach ($list_data as $item): ?>
                <?php
                $id = $item[$model_class]['id'];
                ?>
                <tr>
                    <td>

                    </td>
                    <td><?php echo h($item[$model_class]['product_alias']) ?></td>
                    <td><?php echo number_format($item[$model_class]['qty']) ?></td>
                    <td><?php echo number_format($item[$model_class]['total_price']) ?></td>
                    <td><?php echo h($item[$model_class]['stock_code']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="center"><?php echo __('no_result') ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>