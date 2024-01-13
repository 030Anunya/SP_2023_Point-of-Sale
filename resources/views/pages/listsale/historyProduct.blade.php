@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">ยอดการขายสินค้า</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        ยอดการขายสินค้า
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                    <div class="table-responsive">

                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>สินค้า</th>
                                    <th>จำนวนขาย</th>
                                    <th>รายรับ</th>
                                    <th>ต้นทุน</th>
                                    <th>กำไร/ขาดทุน</th>
                                    <th>ROI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($productPrices as $productSumPrice)
                                @php
                                    if($productSumPrice['sum_price'] > 0 && $productSumPrice['product_cost'] > 0){
                                        $productSumPriceShow = $productSumPrice['sum_price'] / $productSumPrice['product_cost'] * 100;
                                    }else{
                                        $productSumPriceShow = 0;
                                    }
                                @endphp
                                {{-- {{$productSumPrice['product_cost']}} --}}
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $productSumPrice['product']->product_name }}</td>
                                        <td>{{ number_format($productSumPrice['sale_qty']) }}</td>
                                        <td>{{ number_format($productSumPrice['sum_price'], 2) }}
                                        </td>
                                        <td>{{ number_format($productSumPrice['product_cost'], 2) }}</td>
                                        <td>{{ number_format($productSumPrice['sum_price'] - $productSumPrice['product_cost'], 2) }}</td>
                                        <td>{{ number_format($productSumPriceShow, 2) }} %</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Get product data from Laravel and initialize empty arrays
        var productNames = [];
        var productPrices = [];

        // Loop through the products and populate the arrays
        @foreach ($productPrices as $product)
            productNames.push('{{ $product['product']->product_name }}');
            productPrices.push('{{ $product['sum_price'] }}');
        @endforeach

        // Create a Chart.js chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'ยอดขายสินค้า',
                    data: productPrices,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
