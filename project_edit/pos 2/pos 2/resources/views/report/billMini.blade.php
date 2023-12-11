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
    </style>
</header>

<body>
    <div>
        <table>
            <tbody>
                <tr>
                    <td colspan="2" style="text-align:center;">
                        @if (!empty($data['shop_img']))
                        <img style="margin-bottom:4px;" src="{{ asset('storage/uploads/' . $data['shop_img']) }}"
                            alt="7-Eleven" width="60">
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;">
                        <h1>ใบเสร็จรับเงิน/รายการสินค้า</h1>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;">
                        ชื่อร้าน : {{ $data['shop_name'] }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr style="border: 1px dashed black;">
                    </td>
                </tr>
                <tr>
                    <th>Qty</th>
                    <th style="text-align:start;">สินค้า</th>
                    <th>ราคา/หน่วย</th>
                    <th>ราคารวม</th>
                </tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($data['order'] as $product)
                    <tr>
                        <td style="text-align:center;">x {{ $product['product_qty'] }}</td>
                        <td>{{ $product['product_name'] }}</td>
                        <td>@ {{ number_format($product['product_price'], 2) }}</td>
                        <td>{{ number_format($product['product_price'] * $product['product_qty'], 2) }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="4">
                        <hr style="border: 1px dashed black;">
                    </td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td style="text-align:right;">รวมเป็นเงิน:</td>
                    <td colspan="2" style="text-align:right;">{{ $data['total_price'] }} บาท</td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td style="text-align:right;">ภาษีมูลค่าเพิ่ม 7%:</td>
                    <td colspan="2" style="text-align:right;">{{ $data['vat'] }} บาท</td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td style="text-align:right;">รวมทั้งสิ้น:</td>
                    <td colspan="2" style="text-align:right;">{{ $data['total_price_vat'] }} บาท</td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td style="text-align:right;">วันที่:</td>
                    <td colspan="2" style="text-align:right;">{{ date('d/m/Y H:i', strtotime($data['by_date'])) }}</td>
                </tr>
            </tbody>
        </table>
</body>

</html>
