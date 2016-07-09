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
                <th>STT</th>
                <th> MA_DON_HANG </th>
                <th> SO_HIEU </th>
                <th> NGAY_KG </th>
                <th> KHOI_LUONG </th>
                <th> TRI_GIA </th>
                <th> TONG_CUOC </th>
            </tr>
            </thead>
            <tbody>

        <?php if ( empty($objWorksheet) ) { ?>
            <tr class="odd gradeX">
                <td colspan="7">
                    <?=!empty($error) ? $error : "Empty Data"; ?>
                </td>
            </tr>
        <?php } ?>

        <?php if ( !empty($objWorksheet) ) {
            foreach ($objWorksheet->getRowIterator() as $index => $row)  :
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);

                if ($index==1) {
                    continue;
                }

                ?>

            <tr class="odd gradeX">
                <?php
                foreach ($cellIterator as $cell) {
                    echo '<td>' .
                        $cell->getValue() .
                        '</td>' . PHP_EOL;
                }
                ?>
            </tr>

        <?php
                endforeach;
            }
        ?>
            </tbody>
        </table>
    </div>
</div>

<div class="portlet light bordered">
    <div class="portlet-body form">
        <?php echo $this->Form->create('ImportPostCode', array(
            'enctype' => 'multipart/form-data',
        )); ?>
            <div class="form-body">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputFile1">File Excel:</label>
                        <div class="form-control" style="margin-bottom: 10px;">
                            <?php echo $this->Form->file('ImportPostCode.excel_file'); ?>
                        </div>
                        <button class="btn blue"  id="upload_excel" type="button">Upload</button>
                        <button class="btn default" id="cancel_form" type="button">Cancel</button>
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
                        <button class="btn default" id="validate_data" value="validate" type="button">Kiểm tra dữ liệu</button>
                        <button class="btn green" id="do_import_data" value="do_import_data" type="button">Thực Hiện Import</button>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?php echo $this->Form->hidden('action'); ?>

                <?php echo $this->Form->hidden('uploaded_file', array(
                    "value" => !empty($uploaded_file) ? $uploaded_file : ""
                )); ?>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php if ( !empty($objWorksheet) ) { ?>
    <script>
        $(document).ready( function () {
            $('#dataTableCodes').DataTable({
                paging: false
            });
        } );
    </script>
<?php } ?>

<script>
    $(document).ready( function () {

        $('#validate_data').click(function () {
            $("#ImportPostCodeAction").val( "validate_data" );
            isFileUploaded();
        });

        $("#do_import_data").click(function () {
            $("#ImportPostCodeAction").val( "do_import_data" );
            isFileUploaded();
        });

        $("#upload_excel").click(function () {
            $("#ImportPostCodeAction").val( "upload_excel" );
            var form = $("#ImportPostCodeImportForm");
            form.submit();
        });

        $("#cancel_form").click(function () {
            window.location.reload(true);
        });


        function isFileUploaded() {
            var form = $("#ImportPostCodeImportForm");
            var uploaded_file = $("#ImportPostCodeUploadedFile").val();

            if ( typeof  uploaded_file== 'undefined' || uploaded_file=="") {
                alert("Chưa có file excel được upload");

                return false;
            }

            //form.submit();
            sendFormViaAjax(displayAlert);
        }

        function sendFormViaAjax(displayAlert) {
            var fd = new FormData(document.querySelector("#ImportPostCodeImportForm"));
            fd.append("CustomField", "This is some extra data");
            $.ajax({
                url: "/ShippingServices/import",
                type: "POST",
                data: fd,
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: function (data) {
                    console.log("ok");
                    console.log(data);

                    try {
                        JSON.parse(data);
                    }
                    catch(err) {
                        console.log(err.message);
                        return;
                    }

                    var result = JSON.parse(data);

                    displayAlert(result);

                },
                fail: function (data) {
                    console.log("fail");
                    console.log(data);
                }
            });
        }

        function displayAlert(result) {
            if (result.status==0 && result.action=="validate_data"){
                alert("Dữ liệu OK !");
            }

            if (result.status==1 && result.action=="validate_data"){
                alert("export error orders!");
                var form = $("#ImportPostCodeImportForm");
                form.submit();
            }

            if (result.status==1 && result.action=="import_only"){
                alert("Đã thực hiện import mã bưu điện");
            }

            if (result.status==1 && result.action=="import_success"){
                alert("Đã thực hiện import mã bưu điện và cập nhật trạng thái đơn hàng => Thành Công");
                
                window.location.href = "/ShippingServices/import";
            }

            if (result.status==1 && result.action=="import_return"){
                alert("Đã thực hiện import mã bưu điện và cập nhật trạng thái đơn hàng => 'Chuyển Hoàn'");
                
                window.location.href = "/ShippingServices/import";
            }
        }

    } );
</script>

