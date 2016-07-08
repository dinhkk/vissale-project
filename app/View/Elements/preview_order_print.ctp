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
                <span style="font-size:2em; font-weight:bold;"><?=!empty($data['service_name'])?$data['service_name'] : '';?></span><br>
                <span>Website: <strong><?=!empty($data['website'])?$data['website'] : '';?></strong></span><br>
                <span>Hotline: <strong><?=!empty($data['hotline'])?$data['hotline'] : '';?></strong></span><br>
                <span>Địa chỉ: <strong><?=!empty($data['company_address'])?$data['company_address'] : '';?></strong></span>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width:50%">
            <span>Mã Đơn Hàng: <strong>#0987654</strong></span><br>
            <span>Sản phẩm: <strong> Túi Xách Gucci A300</strong></span>
        </td>
        <td colspan="2" style="width:50%">
            <span>Người nhận: <strong>Nguyễn Văn A</strong></span><br>
            <span>Địa Chỉ: <strong>Ngách 200, Ngõ 100, Đường Nguyễn Trãi, Thanh Xuân, Hà Nội</strong></span>
        </td>

    </tr>

    <tr>
        <td colspan="2" style="width:50%">
            <span>Tổng Thu: <strong><?=$this->Common->parseVietnameseCurrency(1000000)?></strong></span>
        </td>
        <td colspan="2" style="width:50%">
            <span>
                Số Điện Thoại : <strong>098 888 888</strong>
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width:50%">
            <span><?=!empty($data['note1'])?$data['note1'] : '';?></span>
        </td>
        <td colspan="2" style="width:50%">
            <span><?=!empty($data['note2'])?$data['note2'] : '';?></span>
        </td>

    </tr>
    </tbody>

</table>

</body>
</html>
