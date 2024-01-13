@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">หน้าหลัก</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        สรุปผล
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Sales Cards  -->
    <!-- ============================================================== -->
    @if (Auth::user()->is_admin)
        <div class="row">
            <!-- Column -->
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white">
                            <i class="mdi mdi-view-dashboard"></i>
                        </h1>
                        <h1></h1>
                        <h6 class="text-white">สินค้าในระบบ</h6>
                        <span class="text-white">{{ number_format($product_count) }} รายการ</span>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white">
                            <i class="mdi mdi-chart-areaspline"></i>
                        </h1>
                        <h6 class="text-white">พนักงานในระบบ</h6>
                        <span class="text-white">{{ number_format($coustomer_count) }} คน</span>
                    </div>
                </div>
            </div> -->
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-warning text-center">
                        <h1 class="font-light text-white">
                            <i class="mdi mdi-collage"></i>
                        </h1>
                        <h6 class="text-white">รายการขายวันนี้</h6>
                        <span class="text-white">{{ number_format($listsale_count_day) }} รายการ</span>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white">
                            <i class="mdi mdi-border-outside"></i>
                        </h1>
                        <h6 class="text-white">รายการขายเดือนนี้</h6>
                        <span class="text-white">{{ number_format($listsale_count_month) }} รายการ</span>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">
                            <i class="mdi mdi-arrow-all"></i>
                        </h1>
                        <h6 class="text-white">รายการขายทั้งหมด</h6>
                        <span class="text-white">{{ number_format($listsale_count) }} รายการ</span>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white">
                            <i class="mdi mdi-receipt"></i>
                        </h1>
                        <h6 class="text-white">ยอดขายวันนี้</h6>
                        <span class="text-white">{{ number_format($totalProductPriceDay, 2) }} บาท</span>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">
                            <i class="mdi mdi-relative-scale"></i>
                        </h1>
                        <h6 class="text-white">ยอดขายเดือนนี้</h6>
                        <span class="text-white">{{ number_format($totalProductPriceMonth, 2) }} บาท</span>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white">
                            <i class="mdi mdi-pencil"></i>
                        </h1>
                        <h6 class="text-white">ยอดขายทั้งหมด</h6>
                        <span class="text-white">{{ number_format($totalProductPriceAll, 2) }} บาท</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- column -->
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-12">
                                    <h5>รายการขายวันนี้</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="zero_config" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>รหัสการขาย </th>
                                                            <th>พนักงานขาย</th>
                                                            <th>วันที่ขาย</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($listSales as $listSale)
                                                            <tr>
                                                                <td>{{ $listSale->order_code }}</td>
                                                                <td>{{ $listSale->users->first_name }}
                                                                    {{ $listSale->users->last_name }} </td>
                                                                <td>{{ date_format($listSale->created_at, 'd/m/Y H:i') }} น.
                                                                </td>
                                                                <td><a href="{{ route('detial_history', $listSale->id) }}"
                                                                        class="btn btn-outline-info">รายละเอียด</a></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="col-lg-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="bg-dark p-10 text-white text-center">
                                        <i class="mdi mdi-account fs-3 mb-1 font-16"></i>
                                        <h5 class="mb-0 mt-1">2540</h5>
                                        <small class="font-light">Total Users</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-dark p-10 text-white text-center">
                                        <i class="mdi mdi-plus fs-3 font-16"></i>
                                        <h5 class="mb-0 mt-1">120</h5>
                                        <small class="font-light">New Users</small>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="bg-dark p-10 text-white text-center">
                                        <i class="mdi mdi-cart fs-3 mb-1 font-16"></i>
                                        <h5 class="mb-0 mt-1">656</h5>
                                        <small class="font-light">Total Shop</small>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="bg-dark p-10 text-white text-center">
                                        <i class="mdi mdi-tag fs-3 mb-1 font-16"></i>
                                        <h5 class="mb-0 mt-1">9540</h5>
                                        <small class="font-light">Total Orders</small>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="bg-dark p-10 text-white text-center">
                                        <i class="mdi mdi-table fs-3 mb-1 font-16"></i>
                                        <h5 class="mb-0 mt-1">100</h5>
                                        <small class="font-light">Pending Orders</small>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="bg-dark p-10 text-white text-center">
                                        <i class="mdi mdi-web fs-3 mb-1 font-16"></i>
                                        <h5 class="mb-0 mt-1">8540</h5>
                                        <small class="font-light">Online Orders</small>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- column -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
@endsection
