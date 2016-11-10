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
                                <input type="text" name="schedule_start_time" value="<?= $startTime ?>"
                                       id="schedule_start_time"
                                       default-time="0"
                                       class="form-control timepicker timepicker-24">
                                <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn green" onclick="setSchedule('schedule_start_time')">SET
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Thời gian kết thúc</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="schedule_end_time" id="schedule_end_time"
                                       value="<?= $endTime ?>"
                                       default-time="0"
                                       class="form-control timepicker timepicker-24">
                                <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                </span>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn green" onclick="setSchedule('schedule_end_time')">SET
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- END FORM-->
        </div>
    </div>
</div>
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
                        <label></label>
                        <div class="md-checkbox-list">
                            <div class="md-checkbox">
                                <?php $check = $enableSchedule == 'true' ? 'checked' : ''; ?>
                                <input type="checkbox" id="enable_scheduled_time" class="md-check" <?= $check; ?> >

                                <label for="enable_scheduled_time">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Bật tự động trả lời theo giờ</label>
                            </div>
                            <p><span class="required">*</span>Cần cài đặt <b>thời gian bắt đầu</b> và <b>kết thúc</b>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        $(document).ajaxSend(function (event, jqxhr, settings) {
            $.LoadingOverlay("show");
        });
        $(document).ajaxComplete(function (event, jqxhr, settings) {
            $.LoadingOverlay("hide");
        });


        var time = $('#timepicker').timepicker('showWidget');

        $("#enable_scheduled_time").click(function () {

            var isChecked = $(this).is(':checked');

            var request = $.ajax({
                url: "/GroupOption/createEnableSchedule",
                method: "POST",
                data: {enable: isChecked},
                dataType: "json"
            });

            request.done(function (msg) {
                if (msg.error == 1) {
                    notify('error', 'Có Lỗi Sảy Ra', msg.message);

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
                if (msg.error == 0) {
                    notify('info', 'Thành Công', msg.message);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                console.log(jqXHR);
            });
        });

        //notify('success', 'thank cong', 'thong bao');
    });


    function setSchedule(key) {

        var start = $("#schedule_start_time").val();
        var end = $("#schedule_end_time").val();

        if (start == end) {
            notify('error', 'Lỗi', 'Thời gian ko hợp lệ');
            return false;
        }

        var beginningTime = moment(start, 'HH:mm');
        var endTime = moment(end, 'HH:mm');
        var data = {key: key};
        if (key == 'schedule_start_time') {
            data.value = start;
        }
        if (key == 'schedule_end_time') {
            data.value = end;
        }

        var request = $.ajax({
            url: "/GroupOption/setScheduleTime",
            method: "POST",
            data: data,
            dataType: "json"
        });

        request.done(function (msg) {
            console.log(msg);

            if (msg.error == 1) {
                notify('error', 'Có Lỗi Sảy Ra', msg.message);
            }
            if (msg.error == 0) {
                notify('info', 'Thành Công', msg.message);
            }
        });

        request.fail(function (jqXHR, textStatus) {
            console.log(jqXHR);
        });
    }
</script>

