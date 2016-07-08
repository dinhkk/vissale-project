<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-share font-red-sunglo hide"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Thông mẫu in</span>
            <span class="caption-helper"> BillingPrint Information ...</span>
        </div>

    </div>
    <div class="portlet-body">
        <div class="container">
            <form method="POST" action="" class="col-lg-10 form-horizontal" style="margin-right: auto; margin-left: auto; float: none;">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tên Dịch Vụ:</label>
                        <div class="col-md-10">
                            <input required type="text" value="<?=!empty($data['service_name'])?$data['service_name'] : '';?>" name="service_name" placeholder="VizSales" class="form-control"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Website:</label>
                        <div class="col-md-5">
                            <input required type="text" value="<?=!empty($data['website'])?$data['website'] : '';?>" name="website" placeholder="Website: VizSales.Vn" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Hotline:</label>
                        <div class="col-md-10">
                            <input required type="text" value="<?=!empty($data['hotline'])?$data['hotline'] : '';?>" name="hotline" placeholder="Hotline: 012345678" class="form-control"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Địa chỉ:</label>
                        <div class="col-md-10">
                            <input required type="text" value="<?=!empty($data['company_address'])?$data['company_address'] : '';?>" name="company_address" placeholder="Địa chỉ: Số 1 Duy Tân, Cầu Giấy, Hà Nội" class="form-control"> </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-10 col-md-offset-2">
                                    <p class="col-md-12 ">Mã Đơn Hàng: #0987654</p>
                                    <p class="col-md-12 ">Sản phẩm: Túi Xách Gucci A300</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="col-md-12 ">Người nhận: Nguyễn Văn A</p>
                                <p class="col-md-12 ">Địa Chỉ: Ngách 200, Ngõ 100, Đường Nguyễn Trãi, Thanh Xuân, Hà Nội  </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-10 col-md-offset-2">
                                    <p class="col-md-12 ">Tổng Thu: <?=$this->Common->parseVietnameseCurrency(1000000)?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="col-md-12 ">Số Điện Thoại : 098 888 888</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 col-md-offset-0">
                                    <div class="col-md-12 ">
                                        <textarea required rows="3" name="note1" class="form-control"><?=!empty($data['note1'])?$data['note1'] : '';?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 ">
                                    <textarea required rows="3" name="note2" class="form-control"><?=!empty($data['note2'])?$data['note2'] : '';?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn green" id="update" type="submit">Cập Nhật</button>
                            <button class="btn default" id="preview" type="button">In Thử</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#preview").click(function () {
            window.open("/BillingPrints/previewOrderPrint", "_blank","toolbar=no,scrollbars=no,resizable=no,top=0,left=0,fullscreen=yes,location=yes");
        });
    });
</script>

