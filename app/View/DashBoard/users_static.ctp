<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-share font-red-sunglo hide"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Revenue</span>
            <span class="caption-helper">Báo cáo bán hàng theo nhân viên...</span>
        </div>

    </div>
    <div class="portlet-body">
        <div class="container">
            <form target="_blank" method="POST" action="/dashboard/users-static">
                <div class="col-lg-6">
                    <div class="input-daterange input-group" id="datepicker" data-provide="datepicker">
                        <input type="text" class="input-sm form-control" name="start_date" />
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control" name="end_date" />
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <div class="col-lg-6">
                            <?php
                            echo $this->Form->select('User.id', $list_users ,["empty"=>"Tất cả", "class"=>"form-control"]);
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <button id="search_orders" class="btn green" type="submit" >Submit</button>
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

