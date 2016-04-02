<?php
echo $this->element('breadcrumb');
echo $this->element('plugins/datatables');
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <button id="sample_editable_1_new" class="btn green"> Add New
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-group pull-right">

                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                <thead>
                    <tr>
                        <?php if (!empty($list_data)): ?>
                            <th><?php echo __('operation') ?></th>
                            <th><?php echo __('bundle_name') ?></th>
                        <?php else: ?>
                            <th><?php echo __('operation') ?></th>
                            <th><?php echo __('bundle_name') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_data)): ?>
                        <?php foreach ($list_data as $item): ?>
                            <tr>
                                <td>
                                    <a class="edit" href="javascript:;"> Edit </a>
                                    <a class="delete" href="javascript:;"> Delete </a>
                                </td>
                                <td> alex </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="center"><?php echo __('no_result') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
