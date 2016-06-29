<?php
echo $this->Html->script(array(
    '/assets/global/plugins/highcharts/js/highcharts.js',
));
?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-share font-red-sunglo hide"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Revenue</span>
            <span class="caption-helper">Thống kê đơn hàng...</span>
        </div>

    </div>
    <div class="portlet-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="input-sm form-control" name="start" />
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control" name="end" />
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="input-group">
                        <button id="search_orders" class="btn btn-success" type="button" style="padding: 6px 15px;">Tìm kiếm</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div id="chart_container" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div>
            </div>
        </div>
    </div>
</div>


<script>

    $(function () {

        getCharts(null,handleData);

        $("#search_orders").click(function () {
            var data  = {};
            var start_date = $("input[name='start']").val();
            var end_date = $("input[name='end']").val();
            data.start_date = start_date;
            data.end_date = end_date;

            getCharts(data,handleData);
        });


        function getCharts(searchQuery,handleData) {
            $.ajax({
                type: "POST",
                url: "/dashboard/orders-static",
                data: searchQuery,
                dataType: "json",
                success: function (data) {
                    return handleData(data);

                },
                fail: function (data) {
                    alert(data);
                }

            });
        }


        function handleData(data) {
            console.log(data);
            $('#chart_container').highcharts({
                title: {
                    text: 'Thống kê đơn hàng theo trạng thái',
                    x: -20 //center
                },
                subtitle: {
                    text: '---',
                    x: -20
                },
                xAxis: {
                    categories: data.categories
                },
                yAxis: {
                    title: {
                        text: 'Số lượng đơn hàng / ngày'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ' đơn'
                },
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom',
                    borderWidth: 0
                },
                series : data.counter
                /*series: [{
                    name: 'Tokyo',
                    data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
                }, {
                    name: 'New York',
                    data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
                }, {
                    name: 'Berlin',
                    data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
                }, {
                    name: 'London',
                    data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                }]*/
            });
        }

        $('.input-daterange').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
