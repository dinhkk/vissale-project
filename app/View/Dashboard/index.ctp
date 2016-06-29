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
            <span class="caption-helper">monthly stats...</span>
        </div>
        <!--<div class="actions">
            <div class="btn-group">
                <a href="" class="btn dark btn-outline btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Filter Range
                    <span class="fa fa-angle-down"> </span>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="javascript:;"> Q1 2014
                            <span class="label label-sm label-default"> past </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;"> Q2 2014
                            <span class="label label-sm label-default"> past </span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:;"> Q3 2014
                            <span class="label label-sm label-success"> current </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;"> Q4 2014
                            <span class="label label-sm label-warning"> upcoming </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>-->
    </div>
    <div class="portlet-body">
        <div class="container">
            <div class="col-lg-6">
                <div id="orders-charts" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {

        getCharts(handleData);

        function getCharts(handleData) {
            $.ajax({
                type: "POST",
                url: "/dashboard",
                data: [],
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
            $('#orders-charts').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Thống kê trạng thái đơn tháng <?=date("m")?> năm <?=date("Y")?>'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                 name: 'Orders',
                 colorByPoint: true,
                     data: data
                 }]
            });
        }


    });
</script>
