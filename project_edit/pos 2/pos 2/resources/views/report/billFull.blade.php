<html>
<header>
    <title>pdf</title>
    <meta http-equiv="Content-Language" content="th" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'sarabun', sans-serif;
            font-size: 20px;
        }

        table {
            width: 100%;
            font-size: 14px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table#header tr td {
            border: 0;
        }

        p {
            margin: 1px 0px;
        }

        span {
            border-bottom: 1px dotted black;
        }

        .box {
            margin: 8px 0px;
        }

        .text-show {
            font-size: 12px;
        }

        .border-none {
            border: none;
        }
    </style>
</header>

<body>
    <table id="header">
        <tr>
            <td id="ht">
                @if (!empty($data['shop_img']))
                    <div style="display: flex;justify-content-center">
                        <img src="{{ asset('storage/uploads/' . $data['shop_img']) }}" alt="Shop Image" width="60">
                    </div>
                @endif
            </td>
            <td id="ht" style="text-align:right;">
                <h1 style="text-align:right;">ใบเสร็จรับเงิน/ใบกำกับภาษี</h1>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="border-none" width="25%">
                <p class="text-show">ร้าน : {{ $data['shop_name'] }}</p>
            </td>
            <td class="border-none" width="70%">
                <p class="text-show">ที่อยู่ร้าน : {{ $data['shop_address'] }}</p>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="border-none" width="25%">
                <p class="text-show">วันที่ : {{ date('d/m/Y H:i', strtotime($data['by_date'])) }} น.</p>
            </td>
            <td class="border-none" width="70%">
                <p class="text-show">ชื่อผู้ขาย : {{ $data['user_sale'] }}<span>&nbsp;</span></p>
            </td>
        </tr>
    </table>




    <table>
        <thead>
            <tr>
                <th style="text-align:center;">ลำดับ</th>
                <th>รายการ</th>
                <th style="text-align:center;">จำนวน</th>
                <th style="text-align:right;">ราคา/หน่วย</th>
                <th style="text-align:right;">จำนวนเงิน/บาท</th>
            </tr>
        </thead>
        <tbody>


            @php
                $i = 1;
            @endphp
            @foreach ($data['order'] as $product)
                <tr>
                    <td style="text-align:center;">{{ $i++ }}</td>
                    <td style="text-align:left;">{{ $product['product_name'] }}</td>
                    <td style="text-align:center;">{{ $product['product_qty'] }}</td>
                    <td style="text-align:right;">{{ number_format($product['product_price'], 2) }}</td>
                    <td style="text-align:right;">
                        {{ number_format($product['product_price'] * $product['product_qty'], 2) }}</td>
                </tr>
            @endforeach


            <tr>
                <td colspan="4" style="text-align:right;">มูลค่ารวมก่อนเสียถาษี</td>
                <td style="text-align:right;">{{ $data['total_price'] }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">ภาษีมูลค่าเพิ่ม (VAT %):</td>
                <td style="text-align:right;">{{ $data['vat'] }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">ยอดรวม</td>
                <td style="text-align:right;">{{ $data['total_price_vat'] }}</td>
            </tr>

        </tbody>
    </table>
</body>

</html>
