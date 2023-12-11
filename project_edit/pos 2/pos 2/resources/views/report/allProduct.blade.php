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
    </style>
</header>

<body>
    @php
        $date = date_create();
    @endphp
    <h4 style="text-align:center;">รายการสินค้าในระบบ</h4>
    <span style="text-align: right;">{{date_format($date, 'm/d/Y H:i')}} น.</span>
    <table>
        <thead>
            <tr>
                <th>รหัส</th>
                <th>ชื่อสินค้า</th>
                <th>ประเภท</th>
                <th>ราคาต้นทุน</th>
                <th>ราคาขาย</th>
                <th>สต็อก</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $product)
                <tr>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category ? $product->category->category_name : 'สินค้านำเข้า' }}</td>
                    <td>{{ $product->product_cost }}</td>
                    <td>{{ $product->product_price }}</td>
                    <td>{{ $product->stock }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
