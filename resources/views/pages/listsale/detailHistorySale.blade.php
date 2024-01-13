@extends('layouts')
@section('content')
    @php
        $i = 1;
        $total_price = 0;
        $total_price_sum_vat = 0;
        $vat = 0;
        $order_code = '';
        $sale_date = '';
        $customer_name = '';
        $phone = '';
        $id = '';
    @endphp
    @foreach ($associatedProducts as $item)
        @php
            $id = $item['id'];
            $total_price += $item['product_price'] * $item['product_qty'];
            $total_price_sum_vat = $item['product_total_price'];
            $vat = $item['vat'];
            $order_code = $item['order_code'];
            $sale_date = $item['sale_date'];
            $customer_name = $item['customer_name'];
            $phone = !empty($item['phone']) ? $item['phone'] : '';
        @endphp
    @endforeach
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <a href="{{ Auth::user()->is_amin ? url('historysale') : route('home') }}"
                            class="btn btn-secondary">กลับ</a>
                        <div>
                            <a href="#" onclick="printMini({{ $id }})" class="btn btn-success text-white"><i
                                    class="fa-solid fa-print"></i> ใบเสร็จย่อ</a>
                            <a href="#" onclick="printFull({{ $id }})" class="btn btn-info"><i
                                    class="fa-solid fa-print"></i>
                                ใบเสร็จเต็ม</a>
                        </div>
                    </div>
                    <hr>

                    <div id="resultDetail">
                        <style>
                            table {
                                width: 100%;
                                font-size: 14px;
                            }

                            th.show,
                            td.show {
                                color: black;
                                padding: 8px;
                                text-align: left;
                                border: 1px solid #ddd;
                            }

                            .text-span {
                                color: black;
                                border-bottom: 1px dotted black;
                            }
                        </style>

                        <table style="margin-bottom:12px;">
                            <tbody>
                                <tr>
                                    <td style="text-align:center;">วันที่ขาย
                                        &nbsp;<span>{{ date('d/m/Y H:i', strtotime($sale_date)) }} น.</span></td>
                                    <td style="text-align:center;">รหัสการขาย &nbsp;<span>{{ $order_code }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>ชื่อพนักงานขาย <span class="text-span">&nbsp;{{ $customer_name }}</span></p>
                        <p>เบอร์โทร <span class="text-span">&nbsp;{{ $phone }}</span></p>
                        <div class="box"></div>
                        <table>
                            <thead>
                                <tr>
                                    <th class="show" style="text-align:center;">ลำดับ</th>
                                    <th class="show">รายการ</th>
                                    <th class="show" style="text-align:center;">จำนวน</th>
                                    <th class="show" style="text-align:right;">ราคา/หน่วย</th>
                                    <th class="show" style="text-align:right;">จำนวนเงิน/บาท</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($associatedProducts as $item)
                                    <tr>
                                        <td class="show" style="text-align:center;">{{ $i++ }}</td>
                                        <td class="show" style="text-align:left;">{{ $item['product_name'] }} ({{$item['features']}})</td>
                                        <td class="show" style="text-align:center;">
                                            {{ number_format($item['product_qty']) }}</td>
                                        <td class="show" style="text-align:right;">
                                            {{ number_format($item['product_price'], 2) }}</td>
                                        <td class="show" style="text-align:right;">
                                            {{ number_format($item['product_price'] * $item['product_qty'], 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="show" colspan="4" style="text-align:right;">มูลค่ารวมก่อนเสียถาษี
                                    </td>
                                    <td class="show" style="text-align:right;">{{ number_format($total_price, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="show" colspan="4" style="text-align:right;">ภาษีมูลค่าเพิ่ม (VAT 7%)
                                    </td>
                                    <td class="show" style="text-align:right;">{{ number_format($vat, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="show" colspan="4" rowspan="2" style="text-align:right;">ยอดรวม
                                    </td>
                                    <td class="show" style="text-align:right;">
                                        {{ number_format($total_price_sum_vat, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function printMini(id) {
            const printWindow = window.open(`/generate-pdfmini/${id}`, '',
                'width=900,height=900');
            printWindow.onload = function() {
                printWindow.print();
                // printWindow.close();

            };
        }

        function printFull(id) {
            const printWindow = window.open(`/generate-pdffull/${id}`, '',
                'width=900,height=900');
            printWindow.onload = function() {
                printWindow.print();
                // printWindow.close();

            };
        }
    </script>
@endsection
