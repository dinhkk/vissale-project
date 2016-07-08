<html>
<head>
    <meta	http-equiv="Content-Type"	content="charset=utf-8" />

    <style type="text/css">
        * {
            font-family: "DejaVu Sans", Sans-Serif, sans-serif, Verdana;
            font-size: 12px;
        }
        body p{line-height: 1px;}

        table {
            width:90%;
            margin: 5px auto;
            border: 2px solid #000;
            border-radius: 4px;
        }

        thead {
            background-color: #eeeeee;
        }

        tbody {
            background-color: #fff;
        }

        th,td {
            padding: 3pt;
        }

        table.separate {
            border-collapse: separate;
            border-spacing: 5pt;
            border: 3pt solid #33d;
        }

        table.separate td {
            border: 2pt solid #33d;
        }

        table.collapse {
            border-collapse: collapse;
            border: 1pt solid black;
        }

        table.collapse td {
            border: 1pt solid black;
        }
    </style>

</head>

<body>

<table class="collapse" style="">
    <tbody>
    <tr>
        <td colspan="4">
            <div style="text-align:left;">
                <span style="font-size:2em; font-weight:bold;"><?=!empty($print['service_name'])?$print['service_name'] : '';?></span><br>
                <span>Website: <strong><?=!empty($print['website'])?$print['website'] : '';?></strong></span><br>
                <span>Hotline: <strong><?=!empty($print['hotline'])?$print['hotline'] : '';?></strong></span><br>
                <span>Địa chỉ: <strong><?=!empty($print['company_address'])?$print['company_address'] : '';?></strong></span>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width:50%">
            <span>Mã Đơn Hàng: <strong>#<?=$order['code'];?></strong></span><br>
            <span>Sản phẩm: <strong>
                    <?php
                    if (count($products) > 0) {
                        foreach ($products as $product) {
                            echo $product['name'];
                        }
                    }
                    ?></strong></span>
        </td>
        <td colspan="2" style="width:50%">
            <span>Người nhận: <strong><?=$order['customer_name'];?></strong></span><br>
            <span>Địa Chỉ: <strong><?=$order['address'];?></strong></span>
        </td>

    </tr>

    <tr>
        <td colspan="2" style="width:50%">
            <span>Tổng Thu: <strong><?=$this->Common->parseVietnameseCurrency( $order['total_price'] )?></strong></span>
        </td>
        <td colspan="2" style="width:50%">
            <span>
                Số Điện Thoại : <strong><?=$order['mobile'];?></strong>
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width:50%">
            <span><?=!empty($print['note1'])?$print['note1'] : '';?></span>
        </td>
        <td colspan="2" style="width:50%">
            <span><?=!empty($print['note2'])?$print['note2'] : '';?></span>
        </td>

    </tr>
    </tbody>

</table>

</body>
</html>
