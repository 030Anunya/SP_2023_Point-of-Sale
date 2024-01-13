@extends('layouts')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="text-title border-bottom">รายละเอียดร้าน</h3>
                <form action="{{ url('/myshop/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="d-flex justify-content-center">
                            <img width="72" height="72"
                                src="{{ !empty($shop->shop_img) ? asset('storage/uploads/' . $shop->shop_img) : asset('storage/uploads/no-product.jpeg') }}"
                                alt="">
                        </div>
                        <hr>
                        <input type="hidden" name="id" value="{{ !empty($shop->id) ? $shop->id : '' }}">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 my-3">
                                <label for="shop_name">ชื่อร้าน</label>
                                <input type="text" name="shop_name"
                                    value="{{ !empty($shop->shop_name) ? $shop->shop_name : '' }}" id=""
                                    class="form-control" placeholder="ชื่อร้าน">
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-3">
                                <label for="shop_name">เบอร์โทรร้าน</label>
                                <input type="text" name="phone" value="{{ !empty($shop->phone) ? $shop->phone : '' }}"
                                    id="" class="form-control" placeholder="เบอร์โทรร้าน">
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-3">
                                <label for="shop_name">logo ร้าน</label>
                                <input type="file" name="image"
                                    value="{{ !empty($shop->shop_img) ? $shop->shop_img : '' }}" id=""
                                    class="form-control" placeholder="logo ร้าน">
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-3">
                                <label for="shop_name">ไลน์ Token</label>
                                <input type="text" name="line_token"
                                    value="{{ !empty($shop->line_token) ? $shop->line_token : '' }}" id=""
                                    class="form-control" placeholder="ไลน์ Token">
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 mb-3">
                                <label for="shop_name">ที่อยู่ร้าน</label>
                                <textarea name="shop_address" cols="10" rows="5" class="form-control" placeholder="ที่อยู่ร้าน">{{ !empty($shop->shop_address) ? $shop->shop_address : '' }}</textarea>
                            </div>
                        </div>
                    <button class="btn btn-primary w-100">บันทึก</button>
                </form>

            </div>
        </div>
    </div>
@endsection
