<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Danh Sách Mã Bưu Điện</div>
        <div class="tools">

        </div>
    </div>
    <div class="portlet-body flip-scroll">
        <table id="postCodes" class="table table-bordered table-striped table-condensed flip-content">
            <thead class="flip-content">
            <tr>
                <th width="20%"> Code </th>
                <th> Company </th>
                <th class="numeric"> Price </th>
                <th class="numeric"> Change </th>
                <th class="numeric"> Change % </th>
                <th class="numeric"> Open </th>
                <th class="numeric"> High </th>
                <th class="numeric"> Low </th>
                <th class="numeric"> Volume </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td> AAC </td>
                <td> AUSTRALIAN AGRICULTURAL COMPANY LIMITED. </td>
                <td class="numeric"> &nbsp; </td>
                <td class="numeric"> -0.01 </td>
                <td class="numeric"> -0.36% </td>
                <td class="numeric"> $1.39 </td>
                <td class="numeric"> $1.39 </td>
                <td class="numeric"> &nbsp; </td>
                <td class="numeric"> 9,395 </td>
            </tr>
            <tr>
                <td> AAD </td>
                <td> ARDENT LEISURE GROUP </td>
                <td class="numeric"> $1.15 </td>
                <td class="numeric"> +0.02 </td>
                <td class="numeric"> 1.32% </td>
                <td class="numeric"> $1.14 </td>
                <td class="numeric"> $1.15 </td>
                <td class="numeric"> $1.13 </td>
                <td class="numeric"> 56,431 </td>
            </tr>
            <tr>
                <td> AAX </td>
                <td> AUSENCO LIMITED </td>
                <td class="numeric"> $4.00 </td>
                <td class="numeric"> -0.04 </td>
                <td class="numeric"> -0.99% </td>
                <td class="numeric"> $4.01 </td>
                <td class="numeric"> $4.05 </td>
                <td class="numeric"> $4.00 </td>
                <td class="numeric"> 90,641 </td>
            </tr>
            <tr>
                <td> ABC </td>
                <td> ADELAIDE BRIGHTON LIMITED </td>
                <td class="numeric"> $3.00 </td>
                <td class="numeric"> +0.06 </td>
                <td class="numeric"> 2.04% </td>
                <td class="numeric"> $2.98 </td>
                <td class="numeric"> $3.00 </td>
                <td class="numeric"> $2.96 </td>
                <td class="numeric"> 862,518 </td>
            </tr>
            <tr>
                <td> ABP </td>
                <td> ABACUS PROPERTY GROUP </td>
                <td class="numeric"> $1.91 </td>
                <td class="numeric"> 0.00 </td>
                <td class="numeric"> 0.00% </td>
                <td class="numeric"> $1.92 </td>
                <td class="numeric"> $1.93 </td>
                <td class="numeric"> $1.90 </td>
                <td class="numeric"> 595,701 </td>
            </tr>
            <tr>
                <td> ABY </td>
                <td> ADITYA BIRLA MINERALS LIMITED </td>
                <td class="numeric"> $0.77 </td>
                <td class="numeric"> +0.02 </td>
                <td class="numeric"> 2.00% </td>
                <td class="numeric"> $0.76 </td>
                <td class="numeric"> $0.77 </td>
                <td class="numeric"> $0.76 </td>
                <td class="numeric"> 54,567 </td>
            </tr>
            <tr>
                <td> ACR </td>
                <td> ACRUX LIMITED </td>
                <td class="numeric"> $3.71 </td>
                <td class="numeric"> +0.01 </td>
                <td class="numeric"> 0.14% </td>
                <td class="numeric"> $3.70 </td>
                <td class="numeric"> $3.72 </td>
                <td class="numeric"> $3.68 </td>
                <td class="numeric"> 191,373 </td>
            </tr>
            <tr>
                <td> ADU </td>
                <td> ADAMUS RESOURCES LIMITED </td>
                <td class="numeric"> $0.72 </td>
                <td class="numeric"> 0.00 </td>
                <td class="numeric"> 0.00% </td>
                <td class="numeric"> $0.73 </td>
                <td class="numeric"> $0.74 </td>
                <td class="numeric"> $0.72 </td>
                <td class="numeric"> 8,602,291 </td>
            </tr>
            <tr>
                <td> AGG </td>
                <td> ANGLOGOLD ASHANTI LIMITED </td>
                <td class="numeric"> $7.81 </td>
                <td class="numeric"> -0.22 </td>
                <td class="numeric"> -2.74% </td>
                <td class="numeric"> $7.82 </td>
                <td class="numeric"> $7.82 </td>
                <td class="numeric"> $7.81 </td>
                <td class="numeric"> 148 </td>
            </tr>
            <tr>
                <td> AGK </td>
                <td> AGL ENERGY LIMITED </td>
                <td class="numeric"> $13.82 </td>
                <td class="numeric"> +0.02 </td>
                <td class="numeric"> 0.14% </td>
                <td class="numeric"> $13.83 </td>
                <td class="numeric"> $13.83 </td>
                <td class="numeric"> $13.67 </td>
                <td class="numeric"> 846,403 </td>
            </tr>
            <tr>
                <td> AGO </td>
                <td> ATLAS IRON LIMITED </td>
                <td class="numeric"> $3.17 </td>
                <td class="numeric"> -0.02 </td>
                <td class="numeric"> -0.47% </td>
                <td class="numeric"> $3.11 </td>
                <td class="numeric"> $3.22 </td>
                <td class="numeric"> $3.10 </td>
                <td class="numeric"> 5,416,303 </td>
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