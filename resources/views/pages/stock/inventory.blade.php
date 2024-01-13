@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">รายการสต็อกสินค้า</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        รายการสต็อกสินค้า
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
                    <h5 class="card-title">สต๊อกสินค้า</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table  table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>รูปภาพ</th>
                                    <th width="20%">ชื่อสินค้า</th>
                                    <th>มีสินค้า</th>
                                    <th>สั่งซื้อแล้ว/ชิ้น</th>
                                    <th>พร้อมขาย/ชิ้น</th>
                                    <th>จัดการ</th>
                                </tr>
                            <tbody>

                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($products as $product)
                                    <tr>
                                        <td width="20%"><img class="img-fluid img-product" width="72" height="72"
                                                src="{{ asset($product->product_img !== null ? 'storage/uploads/' . $product->product_img : 'storage/uploads/no-product.jpeg') }}"
                                                alt="{{ $product->product_name }}"></td>
                                        <td><a onclick="showCategoryModal({{ $product->id }}, '{{ $product->category_name }}')"
                                                href="#">{{ $product->product_name }}</a></td>
                                        <td>{{ $product->stock + $product->total_qty }}</td>
                                        <td>{{ $product->total_qty }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td width="10%">
                                            <button onclick="showCategoryModal({{ $product->id }})"
                                                class="btn btn-outline-primary w-100">อัพเดต</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modalInventory')
    <script>
        function showCategoryModal(categoryId = null) {
            $('#input_update_stock').val('')
            $('#input_increase_stock').val('')
            $('#input_decrease_stock').val('')
            var btn_update = $('.btn-update')
            const modal = $('#modalInventory');
            btn_update.addClass('active')

            axios.get(`inventory/${categoryId}`)
                .then(res => {
                    const product = res.data.product;
                    const qty_sale = !isNaN(product.total_qty) ? parseInt(product.total_qty) : 0;
                    $('#id_product').val(product.id)
                    $('#stock_count').val(parseInt(product.stock))
                    $('#count_quantify').text(parseInt(product.stock) + qty_sale + ' -> ')
                    $('#old_count_quantify').val(parseInt(product.stock) + qty_sale)
                    $('#sale_prdouct').text(qty_sale)
                    $('#ready_sale').text(product.stock + ' -> ')
                    $('#success_ready_sale').text(product.stock)
                    $('#resout_count_quantity').text(parseInt(product.stock) + qty_sale)
                    $('#old_resout_count_quantity').text(parseInt(product.stock) + qty_sale)
                    $('#old_sale_prdouct').text(product.stock)
                    $('#product_name').text(product.product_name);
                    // $('#product_category').text(product.category.category_name);
                    $('#product_code').text(product.code);

                    modal.modal('show');
                })
                .catch(e => {
                    console.log(e);
                });


        }
    </script>
    <style>
        /* .img-product {
            height: 80px;
            width: 80px;
            object-fit: cover
        } */
    </style>
@endsection
