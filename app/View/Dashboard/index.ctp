<?php
    echo $this->Html->script(array(
    '/assets/global/plugins/highcharts/js/highcharts.js',
));
?>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

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
            $('#container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Thống kê trạng thái đơn hàng năm <?=date("Y")?>'
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
