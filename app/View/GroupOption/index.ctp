<div class="col-md-6">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Cấu hình
            </div>
            <div class="tools">

            </div>
        </div>
        <div class="portlet-body flip-scroll">
            <div class="portlet-body form">
                <form role="form" action="">
                    <div class="form-group form-md-checkboxes">
                        <label>Cài đặt thời gian tự động trả lời</label>
                        <div class="md-checkbox-list">
                            <div class="md-checkbox">
                                <input type="checkbox" id="enable_scheduled_time" class="md-check">
                                <label for="enable_scheduled_time">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Bật tự động trả lời theo giờ</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="portlet box red">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Chọn thời gian
            </div>
            <div class="tools">

            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal form-bordered">
                <div class="form-body form">
                    <div class="form-group">
                        <label class="control-label col-md-3">Thời gian bắt đầu</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" value="11:24 AM"
                                       class="form-control timepicker timepicker-no-seconds">
                                <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Thời gian kết thúc</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control timepicker timepicker-no-seconds">
                                <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- END FORM-->
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        console.log("ready!");

        var time = $('#timepicker').timepicker('showWidget');

        $("#enable_scheduled_time").click(function () {
            console.log('clicked on enable_scheduled_time');

            var isChecked = $(this).is(':checked');

            console.log(isChecked);

            /*var request = $.ajax({
             url: "/GroupOption/enable-schedule",
             method: "POST",
             data: { id : null },
             dataType: "json"
             });

             request.done(function( msg ) {
             console.log(msg);
             });

             request.fail(function( jqXHR, textStatus ) {
             console.log(jqXHR);
             });*/
        });

        //notify('success', 'thank cong', 'thong bao');
    });

</script>

