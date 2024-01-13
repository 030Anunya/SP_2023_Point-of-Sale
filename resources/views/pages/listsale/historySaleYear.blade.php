@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">ยอดขายรายปี</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        ยอดขายรายปี
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
                    <h1 class="text-center">ยอดขายประจำปี</h1>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ปี</th>
                                            <th>ยอดขาย / บาท</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @for ($i = 0; $i < count($labels); $i++)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $labels[$i] }}</td>
                                                <td>{{ $data[$i] }}</td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('myChart');
        var labels = @json($labels);
        var dataCartJs = @json($data);
        const data = {
            labels: labels,
            datasets: [{
                label: 'ยอดการขาย',
                data: dataCartJs,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
            }]
        };
        const config = {
            type: 'line',
            data: data,
            options: {
                transitions: {
                    show: {
                        animations: {
                            x: {
                                from: 0
                            },
                            y: {
                                from: 0
                            }
                        }
                    },
                    hide: {
                        animations: {
                            x: {
                                to: 0
                            },
                            y: {
                                to: 0
                            }
                        }
                    }
                }
            }
        };
        new Chart(ctx, config);
    </script>
@endsection
