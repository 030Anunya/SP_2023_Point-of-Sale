@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">ยอดขายรายเดือน</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        ยอดขายรายเดือน
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
                    @php
                        $currentYear = date('Y');
                    @endphp
                    <h1 class="text-center">ยอดขายประจำเดือน {{ $yearShow }}</h1>

                    <form action="{{ url('/historySaleMonth') }}" method="get">
                        @csrf
                        <select name="year" id="year" class="form-select">
                            <option value="" disabled selected>เลือกดูยอดการขาย</option>
                            @for ($year = $currentYear; $year <= $currentYear + 1; $year++)
                                <option value="{{ $year }}">{{ $year + 543 }}</option>
                            @endfor
                        </select>
                        <button type="submit" class="btn btn-success w-100 my-2 text-white">ค้นหา</button>
                    </form>
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
                                            <th>เดือน</th>
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
        console.log(labels);
        var data = @json($data);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'ยอดขายรายเดือน',
                    data: data,
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
