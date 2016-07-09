<?php
    echo $this->Html->css(array(
        "/assets/global/plugins/datatables/datatables.min.css",
        //"/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css",
    ));

    echo $this->Html->script(array(
        "/assets/global/scripts/datatable.js",
        "/assets/global/plugins/datatables/datatables.min.js",
        "/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js",
        "/assets/pages/scripts/table-datatables-managed.min.js",
    ));

?>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Danh Sách Mã Bưu Điện</div>
        <div class="tools">

        </div>
    </div>
    <div class="portlet-body flip-scroll">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="dataTableCodes">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /> </th>
                <th> Username </th>
                <th> Email </th>
                <th> Points </th>
                <th> Joined </th>
                <th> Status </th>
            </tr>
            </thead>
            <tbody>
            
            <tr class="odd gradeX">
                <td>
                    <input type="checkbox" class="checkboxes" value="1" /> </td>
                <td> shuxer </td>
                <td>
                    <a href="mailto:shuxer@gmail.com"> shuxer@gmail.com </a>
                </td>
                <td> 120 </td>
                <td class="center"> 12 Jan 2012 </td>
                <td>
                    <span class="label label-sm label-success"> Approved </span>
                </td>
            </tr>
            
            </tbody>
        </table>
    </div>
</div>

<div class="portlet light bordered">
    <div class="portlet-body form">
        <?php echo $this->Form->create('ImportPostCode', array(
            'enctype' => 'multipart/form-data'
        )); ?>
            <div class="form-body">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputFile1">File Excel:</label>
                        <div class="form-control" style="margin-bottom: 10px;">
                            <?php echo $this->Form->file('ImportPostCode.excel_file'); ?>
                        </div>
                        <button class="btn blue" type="submit">Upload</button>
                        <button class="btn default" type="button">Cancel</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label style="margin-left: 50px;">Hành Động:</label>
                        <div class="radio-list text-center">
                            <label class="radio-inline">
                                 <input type="radio" checked="" value="import_only" id="optionsRadios4" name="data[ImportPostCode][option]">
                                Import Mã Bưu Điện </label>
                            <label class="radio-inline">
                                <input type="radio" value="import_success" id="import_success" name="data[ImportPostCode][option]">
                                Import Thành Công
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="import_return" id="import_return" name="data[ImportPostCode][option]">
                                Import Chuyển Hoàn
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-actions right">
                        <button class="btn default" name="action" value="validate" type="button">Kiểm tra dữ liệu</button>
                        <button class="btn green" name="action" value="do_import" type="submit">Thực Hiện Import</button>
                    </div>
                </div>
            </div>
            <div class="form-actions">

            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>


<script>

    $(document).ready( function () {
        $('#dataTableCodes').DataTable({
            paging: false
        });
    } );
</script>