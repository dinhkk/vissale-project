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
            <form target="_blank" method="POST" action="" class="col-lg-10 form-horizontal" style="margin-right: auto; margin-left: auto; float: none;">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Tên Dịch Vụ:</label>
                        <div class="col-md-10">
                            <input type="text" name="service_name" placeholder="VizSales" class="form-control"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Website:</label>
                        <div class="col-md-5">
                            <input type="text" name="website" placeholder="Website: VizSales.Vn" class="form-control"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Hotline:</label>
                        <div class="col-md-10">
                            <input type="text" name="hotline" placeholder="Hotline: 012345678" class="form-control"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Địa chỉ:</label>
                        <div class="col-md-10">
                            <input type="text" name="company_address" placeholder="Địa chỉ: Số 1 Duy Tân, Cầu Giấy, Hà Nội" class="form-control"> </div>
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
                                    <p class="col-md-12 ">Tổng Thu: 1000000 VND</p>
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
                                        <textarea rows="3" name="note1" class="form-control">Quý khách yên tâm nhận hàng, công ty sẻ đổi hàng cho bạn nếu bạn không vừa ý.
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 ">
                                    <textarea rows="3" name="note2" class="form-control">Bưu điện trước khi chuyển hàng, vui lòng điện cho công ty theo số máy: 012345678
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

        $('.input-daterange').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>

