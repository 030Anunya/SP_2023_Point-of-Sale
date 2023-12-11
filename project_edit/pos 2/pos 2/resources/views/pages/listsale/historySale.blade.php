@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">รายการขาย</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        รายการขาย
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
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
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
                                        <td>{{$listSale->order_code}}</td>
                                        <td>{{$listSale->users->first_name}} {{$listSale->users->last_name}}  </td>
                                        <td>{{date_format($listSale->created_at, 'd/m/Y H:i')}}</td>
                                        <td><a href="{{url('historysale/detail',$listSale->id)}}" class="btn btn-outline-info">รายละเอียด</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
