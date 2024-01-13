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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-7">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="3%">ลำดับ</th>
                                    <th>คุณสมบัติ</th>
                                    <th width="15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($allSku as $sku)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $sku->sku_name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <form action="{{ route('feature.edit', $sku->id) }}" method="get">
                                                    @csrf
                                                    <button class="btn btn-warning">แก้ไข</button>
                                                </form>
                                                <form action="{{ route('feature.destroy', $sku->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger">ลบ</button>
                                                </form>


                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-5 ">
                    <p>ฟอร์มเพิ่มคุณสมบัติ</p>


                    @if (isset($skuEdit))
                        <form action="{{ route('feature.update',$skuEdit->id) }}" method="post">
                            @csrf
                            @method("PUT")
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="my-addon">คุณสมบัติ</span>
                                </div>
                                <input value="{{ $skuEdit->sku_name }}" class="form-control" required type="text"
                                    name="sku" placeholder="กรุณาระบุ" aria-label="Recipient's text"
                                    aria-describedby="my-addon">
                            </div>

                            <button type="submit" class="btn btn-outline-warning mt-3">อัพเดต</button>
                            <a href="{{ route('feature.index') }}" class="btn btn-secondary mt-3">ยกเลิก</a>
                        </form>
                    @else
                        <form action="{{ route('feature.store') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="my-addon">คุณสมบัติ</span>
                                </div>
                                <input class="form-control" required type="text" name="sku" placeholder="กรุณาระบุ"
                                    aria-label="Recipient's text" aria-describedby="my-addon">
                            </div>

                            <button type="submit" class="btn btn-outline-success mt-3">เพิ่มคุณสมัติ</button>

                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
