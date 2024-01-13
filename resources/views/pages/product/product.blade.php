@extends('layouts')
@section('bread')
<div class="col-12 d-flex no-block align-items-center">
    <h4 class="page-title">รายการสินค้า</h4>
    <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    รายการสินค้า
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row" id="product">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-4">

                    <div class="btn-group">
                        <button type="button" class="btn btn-success text-white" onclick="openModalExcel()">
                            นำสินค้าเข้า
                        </button>
                        <a href="#" onclick="printPdfProduct()" class="btn btn-secondary">
                            พิมพ์สต็อก <i class="fa-solid fa-print"></i>
                        </a>
                        <button type="button" class="btn btn-primary" onclick="openModal()">
                            เพิ่มสินค้า
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รูปภาพ</th>
                                <th>ชื่อสินค้า</th>
                                <th>หมวดหมู่</th>
                                <th>สต๊อก/ชิ้น</th>
                                <th>ราคา/บาท</th>
                                <th>หมดอายุ</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            $count_stock = 0;
                            @endphp
                            @foreach ($products as $product)
                            @php
                            if ($product->Expiry_Date !== null && $product->Expiry_Date != 'null') {
                            $date1 = date('Y-m-d');
                            $date2 = $product->Expiry_Date;

                            $dateTime1 = new DateTime($date1);
                            $dateTime2 = new DateTime($date2);

                            $interval = $dateTime1->diff($dateTime2);

                            $days = $interval->days;
                            }
                            if (count($product->features) >= 1) {
                            foreach ($product->features as $item) {
                            $count_stock += $item['stock'];
                            }
                            } else {
                            $count_stock = 0;
                            }

                            @endphp
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td><img class="img-fluid img-product" width="72" height="72"
                                        src="{{ asset($product->product_img != null ? 'storage/uploads/' . $product->product_img : 'storage/uploads/no-product.jpg') }}"
                                        alt="{{ $product->product_name }}"></td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->category ? $product->category->category_name : 'สินค้านำเข้า' }}

                                </td>

                                <td>
                                    <span
                                        class="{{ $product->stock + $count_stock == 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $product->stock + $count_stock == 0 ? 'สินค้าหมด' : number_format($product->stock + $count_stock) }}
                                    </span>
                                </td>
                                <td>{{ number_format($product->product_price, 2) }}</td>
                                <td>
                                    @php
                                    if (!isset($days)) {
                                    echo '<span class="badge bg-success">ปกติ</span>';
                                    } elseif ($days > 7) {
                                    echo '<span class="badge bg-success">ปกติ</span>';
                                    } elseif ($days <= 7 && $days> 0) {
                                        echo '<span class="badge bg-warning">ใกล้หมดอายุ</span>';
                                        } else {
                                        echo '<span class="badge bg-danger">หมดอายุ</span>';
                                        }
                                        @endphp
                                </td>
                                <td>
                                    @php
                                    if ($product->status == 1) {
                                    echo '<span class="badge bg-success">ใช้งาน</span>';
                                    } else {
                                    echo '<span class="badge bg-danger">ปิดใช้งาน</span>';
                                    }
                                    @endphp
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <form action="{{ url('/products/status', $product->id) }}" method="post"
                                            class="form_update_status">
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="toggleStatus({{ $product->id }},'{{ $product->product_name }}')">
                                                <i class="fa-solid fa-toggle-on"></i>
                                            </button>
                                        </form>
                                        <!-- <a class="btn btn-info" onclick="printBarcode({{ $product->id }})"><i
                                                        class="fa-solid fa-barcode"></i></a> -->
                                        <button class="btn btn-warning" type="button"
                                            v-on:click="EditProduct({{ $product->id }})"><i
                                                class="mdi mdi-pencil"></i></button>

                                        <form action="{{ route('products.destroy', $product->id) }}" method="post"
                                            class="form_delete_product">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="removeProduct({{ $product->id }},'{{ $product->product_name }}')">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                        เพิ่มสินค้าใหม่</h1>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form id="productForm" class="form-horizontal" method="post" action="{{ url('/products') }}">
                        @csrf

                        <input type="hidden" name="id_product" id="id_product">
                        <h4 class="card-title">รายละเอียดสินค้า</h4>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ภาพสินค้า</label>
                            <div class="col-sm-9">
                                <div class="d-flex justify-content-center">
                                    <img id="blah" src="#" alt="your image" width="90" height="70"
                                        class="rounded mb-2 d-none" />
                                </div>
                                <input v-on:change="handleFileChange" accept="image/*" name="image" type='file'
                                    id="imgInp" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อสินค้า</label>
                            <div class="col-sm-9">
                                <input type="text" v-model="form.product_name" class="form-control" id="product_name"
                                    name="product_name" placeholder="โปรดระบุชื่อสินค้า" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-end control-label col-form-label">
                                หมวดหมู่สินค้า</label>
                            <div class="col-sm-9">
                                <select v-model="form.category" class="form-select" name="category" id="category"
                                    v-on:change="findSubCategory">
                                    <option value="" disabled selected>เลือกหมวดหมู่</option>
                                    @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-sm-3 text-end control-label col-form-label">
                                ประเภทสินค้า</label>
                            <div class="col-sm-9">
                                <select v-model="form.sub_category" class="form-select" name="sub_category"
                                    id="sub_category">
                                    <option value="" disabled selected>เลือกประเภท</option>
                                    <div id="result_list_sub_category"></div>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email1" class="col-sm-3 text-end control-label col-form-label">สินค้า
                                SKU</label>
                            <div class="col-sm-9">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked" :checked="checkSku" v-on:click="toggleCheck">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">เปิดใช้งาน</label>
                                </div>
                                <div v-if="checkSku">
                                    <div class="card" v-for="(feature,indexKey) in features" :key="indexKey">
                                        <div class="card-body  rounded">
                                            <div class="d-flex justify-content-end">
                                                <button v-if="indexKey != 0" type="button" class="btn-close "
                                                    aria-label="Close" v-on:click="deleteFeature(indexKey)"></button>

                                            </div>
                                            <h5 class="card-title">คุณสมบัติ @{{ indexKey }}</h5>
                                            <select name="" id="" class="form-select mb-2"
                                                v-model="form.feature[indexKey]">
                                                <option value="" selected disabled>เลือกคุณสมบัติ</option>
                                                <option :value="sku.sku_name" v-for="(sku,indexSku) in arrayAllSkus"
                                                    :key="indexSku">@{{ sku.sku_name }}</option>
                                            </select>
                                            <label for="">ตัวเลือก</label>
                                            <div class="form-group" v-for="(feature,index) in features[indexKey]"
                                                :key="index">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" v-model="feature.text">
                                                    <span class="input-group-text text-white bg-danger"
                                                        id="basic-addon2" v-on:click="removeInput(index,indexKey)"><i
                                                            class="fa-solid fa-trash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary w-100"
                                            v-on:click="addFeature(indexKey)">+
                                            เพิ่มตัวเลือก</button>
                                    </div>


                                    <button type="button"
                                        :class="`btn btn-info w-100 my-3 ${countFeatures >=2 ? 'd-none' : 'd-block'}`"
                                        v-on:click="addFeatureMain">+
                                        เพิ่มคุณสมบัติ</button>

                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>คุณสมบัติ</th>
                                                <th>รหัส Sku</th>
                                                <th>ราคา</th>
                                                <th>จำนวน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="combinations != ''"
                                                v-for="(combination, comboIndex) in combinations" :key="comboIndex">
                                                <td>
                                                    <div>
                                                        <p>@{{ combination }}</p>
                                                    </div>
                                                </td>
                                                <td width="27%">
                                                    <input type="text" v-model="inputGroupSku[comboIndex]"
                                                        class="form-control">

                                                </td>
                                                <td width="27%">
                                                    <input type="number" v-model="inputGroupPrice[comboIndex]"
                                                        class="form-control">

                                                </td>

                                                <td width="27%">
                                                    <input type="number" v-model="inputGroupCount[comboIndex]"
                                                        class="form-control">

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email1"
                                class="col-sm-3 text-end control-label col-form-label">วันหมดอายุ</label>
                            <div class="col-sm-9">
                                <input v-model="form.Expiry_Date" type="date" class="form-control" id="Expiry_Date"
                                    name="Expiry_Date" placeholder="วันหมดอายุ" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email1"
                                class="col-sm-3 text-end control-label col-form-label">รหัสสินค้า*</label>
                            <div class="col-sm-9">
                                <input v-model="form.code" type="text" class="form-control" id="code" name="code"
                                    placeholder="โปรดระบุรหัสสินค้า" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cono1" class="col-sm-3 text-end control-label col-form-label">คลังสินค้า</label>
                            <div class="col-sm-9">
                                <input v-model="form.stock" type="text" class="form-control" id="stock" name="stock"
                                    placeholder="โปรดระบุจำนวนสินค้า" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cono1" class="col-sm-3 text-end control-label col-form-label">น้ำหนัก</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">กก</span>
                                    </div>
                                    <input v-model="form.weight" type="text" name="weight" id="weight"
                                        class="form-control" placeholder="น้ำหนัก" aria-label="Username"
                                        aria-describedby="basic-addon1" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cono1"
                                class="col-sm-3 text-end control-label col-form-label">ต้นทุนราคาสินค้า</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">฿</span>
                                    </div>
                                    <input v-model="form.product_cost" type="text" name="product_cost" id="product_cost"
                                        class="form-control" placeholder="โปรดระบุราคาต้นทุน" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cono1"
                                class="col-sm-3 text-end control-label col-form-label">ราคาขายสินค้า</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">฿</span>
                                    </div>
                                    <input v-model="form.product_price" type="text" name="product_price"
                                        id="product_price" class="form-control" placeholder="โปรดระบุราคาขาย"
                                        aria-label="Username" aria-describedby="basic-addon1" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cono1"
                                class="col-sm-3 text-end control-label col-form-label">รายละเอียดสินค้า</label>
                            <div class="col-sm-9">
                                <textarea v-model="form.description" class="form-control" name="description"
                                    id="description"></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">ยกเลิก</button>
                    <button type="button" v-on:click="submitForm" class="btn btn-primary"
                        id="submit_btn">บันทึก</button>
                </div>
                </form>
            </div>
        </div>
    </div>


</div>
@include('components.modalPrintBarcode')
@include('components.modalExcel')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
imgInp.onchange = evt => {
    $('#blah').removeClass('d-none')
    const [file] = imgInp.files
    if (file) {
        blah.src = URL.createObjectURL(file)
    }
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function closeModal() {
    $('#id_product').val('');
    $('#blah').attr('src', '')
    $('#sub_category').html('<option value="" disabled selected>เลือกประเภท</option>')
    $('#staticBackdrop').modal('hide')
    document.getElementById('productForm').reset();
    $(".error-message").remove();
}

function findSubCategory(e) {

    $.ajax({
        url: '/subcategory/' + e.target.value,
        type: 'get',
        success: function(response) {
            let show_list = ''
            response.forEach(element => {
                show_list +=
                    `<option value="${element.id}">${element.sub_category_name}</option>`
            });

            $('#sub_category').html(show_list)
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
}



function openModal() {
    $('#submit_btn').text('บันทึก');
    $('#blah').addClass('d-none')
    $('#staticBackdrop').modal('show')
}

var app = new Vue({
    el: '#product',
    data() {
        return {
            message: "hello",
            checkSku: false,
            features: {
                0: [{
                    text: "",
                    value: "d"
                }]
            },
            inputGroupPrice: [""],
            inputGroupCount: [""],
            inputGroupSku: [""],
            arrayAllSkus: [],
            form: {
                id_product: "",
                imageInput: "",
                product_name: "",
                category: "",
                sub_category: "",
                Expiry_Date: "",
                code: "",
                stock: "",
                weight: "",
                product_cost: "",
                product_price: "",
                description: "",
                feature: [],

            },
            formData: new FormData(),

        };
    },

    methods: {
        findSubCategory(id = "") {
            const find_id = this.form.category != "" ? this.form.category : id
            $.ajax({
                url: '/subcategory/' + find_id,
                type: 'get',
                success: function(response) {
                    let show_list = ''
                    response.forEach(element => {
                        show_list +=
                            `<option value="${element.id}">${element.sub_category_name}</option>`
                    });

                    $('#sub_category').html(show_list)
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        },
        EditProduct(id) {
            $('#blah').removeClass('d-none')
            $('#id_product').val(id);
            $('#submit_btn').text('อัพเดต')

            axios.get(`/products/${id}/edit`).then(res => {
                const response = res.data;
                $('#blah').attr('src', 'storage/uploads/' + response.product_img)
                this.form.product_name = response.product_name
                this.form.category = response.category ? response.category.id : ''
                this.findSubCategory(response.category ? response.category.id : '')

                this.form.sub_category = response.subcategory ? response.subcategory.id : ''
                this.form.Expiry_Date = response.Expiry_Date
                this.form.code = response.code
                this.form.stock = response.stock
                this.form.weight = response.weight
                this.form.product_cost = response.product_cost
                this.form.product_price = response.product_price
                this.form.description = response.description
                this.form.id_product = response.id
                this.form.feature.push(response.sku_name1)
                if (response.sku_name2 != "undefined") {
                    this.form.feature.push(response.sku_name2)
                }
                $('#category').val()
                $('#sub_category').val()

                if (response.features.length >= 1) {
                    this.checkSku = true
                    const features1 = [];
                    const features2 = [];
                    const feature1 = [];
                    const feature2 = [];
                    const count = [];
                    const price = [];
                    const sku = [];
                    const uniqueFeatures1 = new Set();
                    const uniqueFeatures2 = new Set();

                    response.features.forEach(element => {
                        features1.push(element.feature1);
                        features2.push(element.feature2);
                        uniqueFeatures1.add(element.feature1);
                        uniqueFeatures2.add(element.feature2);
                        count.push(element.stock)
                        price.push(element.product_price)
                        sku.push(element.sku)
                    });
                    this.inputGroupCount = count
                    this.inputGroupPrice = price
                    this.inputGroupSku = sku

                    uniqueFeatures1.forEach(element => {
                        feature1.push({
                            text: element
                        });
                    });
                    this.features[0] = feature1;

                    const newIndex = Object.keys(this.features).length; // Calculate the next index
                    this.$set(this.features, +newIndex, [{
                        text: "",
                        value: ""
                    }]);


                    uniqueFeatures2.forEach(element => {
                        feature2.push({
                            text: element
                        });
                    });
                    console.log(feature2);
                    this.features[1] = feature2;

                } else {
                    this.checkSku = false
                }
                $('#staticBackdrop').modal('show')
                console.log(this.form);
            }).catch(e => {
                console.log(e);
            })
        },
        toggleCheck() {
            this.checkSku = !this.checkSku
        },
        addFeature(index) {
            this.inputGroupPrice.push("")
            this.inputGroupCount.push("")
            this.inputGroupSku.push("")
            this.features[index].push({
                text: "",
                value: ""
            });
        },
        deleteFeature(indexKey) {
            Vue.delete(this.form.feature, indexKey)
            Vue.delete(this.features, indexKey);
        },
        removeInput(index, indexKey) {

            this.features[indexKey].splice(index, 1);
        },
        addFeatureMain() {
            this.inputGroupPrice.push("")
            this.inputGroupCount.push("")
            this.inputGroupSku.push("")

            const newIndex = Object.keys(this.features).length;
            this.$set(this.features, +newIndex, [{
                text: "",
                value: ""
            }]);
        },
        handleFileChange(event) {
            this.form.imageInput = event.target.files[0];
        },
        allFeatures() {
            axios.get('feature').then(res => {
                res.data.forEach(element => {
                    this.arrayAllSkus.push(element)
                });
            }).catch(e => {
                console.log(e);
            })
        },
        submitForm() {
            const features1 = this.features["0"].map((color) => color.text);
            const features2 = this.features["1"] ? this.features["1"].map((letter) => letter.text) : [];
            const inputPrice = this.inputGroupPrice.map((data) => data);
            const inputCount = this.inputGroupCount.map((data) => data);
            const inputSku = this.inputGroupSku.map((data) => data);


            const combinations = [];

            features1.forEach((feature1, colorIndex) => {
                if (features2.length > 0) {
                    features2.forEach((feature2, sizeIndex) => {
                        const obj = {
                            feature1,
                            feature2,
                            price: inputPrice[colorIndex * features2.length +
                                sizeIndex],
                            count: inputCount[colorIndex * features2.length +
                                sizeIndex],
                            sku: inputSku[colorIndex * features2.length +
                                sizeIndex]
                        };
                        combinations.push(obj);
                    });
                } else {
                    const obj = {
                        feature1,
                        price: inputPrice[colorIndex],
                        count: inputCount[colorIndex],
                        sku:inputSku[colorIndex]
                    };
                    combinations.push(obj);
                }
            });

            this.formData.append('id_product', this.form.id_product);
            this.formData.append('image', this.form.imageInput);
            this.formData.append('product_name', this.form.product_name);
            this.formData.append('category', this.form.category);
            this.formData.append('sub_category', this.form.sub_category);
            this.formData.append('Expiry_Date', this.form.Expiry_Date);
            this.formData.append('code', this.form.code);
            this.formData.append('stock', this.form.stock);
            this.formData.append('weight', this.form.weight);
            this.formData.append('product_cost', this.form.product_cost);
            this.formData.append('product_price', this.form.product_price);
            this.formData.append('description', this.form.description);
            if (this.checkSku) {
                this.formData.append('combinations', JSON.stringify(combinations))
                this.formData.append('sku_name1', this.form.feature[0])

                this.formData.append('sku_name2', this.form.feature[1] ? this.form.feature[1] : '')
            } else {
                this.formData.append('combinations', null)
            }

            axios({
                    method: 'post',
                    url: 'products',
                    data: this.formData,
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                })
                .then(response => {
                    // Handle success
                    console.log(response.data);

                    // Show success message (you can use a notification library)
                    // this.showSuccessMessage('บันทึกสินค้าสำเร็จ');

                    // Reset form and image input
                    this.formData = new FormData();
                    $('#submit_btn').attr('disabled', '')
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: response.data.type,
                        title: response.data.data
                    })

                    setTimeout(() => {
                        location.reload()
                    }, 900);
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        // Validation error response
                        const errors = error.response.data.errors;

                        // Handle validation errors
                        Object.keys(errors).forEach(field => {
                            const errorMessages = errors[field];
                            const errorHtml = '<div class="error-message text-danger">' +
                                errorMessages.join(', ') + '</div>';
                            $("#" + field).closest(".col-sm-9").append(errorHtml);
                        });
                    } else {
                        console.error("Form submission failed");
                    }
                })
        }

    },
    computed: {
        countFeatures() {
            return Object.keys(this.features).length;
        },
        combinations() {
            const colors = this.features["0"].map((color) => color.text);
            const letters = this.features["1"] ? this.features["1"].map((letter) => letter.text) : [];
            const result = [];
            for (const color of colors) {
                if (letters.length !== 0) {
                    for (const letter of letters) {
                        result.push(`${color}/${letter}`);
                    }
                } else {
                    result.push(`${color}`);
                }
            }
            return result;
        },
    },
    mounted() {
        this.allFeatures()

    },
})
</script>
<script>
function printPdfProduct() {
    const printWindow = window.open(`/generate-pdfProduct`, '',
        'width=900,height=900');
    printWindow.onload = function() {
        printWindow.print();
        // printWindow.close();

    };
}

function openModalExcel() {
    $('file').val('')
    $('#modalExcel').modal('show')
}

function removeProduct(id, product) {
    $('.form_delete_product').attr('action', `{{ route('products.destroy', ['product' => ':id']) }}`
        .replace(
            ':id', id))

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: `คุณต้องการลบ ${product}`,
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $('.form_delete_product').submit()
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'ยกเลิกแล้ว',
                '',
                'error'
            )
        }
    })

}

function toggleStatus(id, product) {
    $('.form_update_status').attr('action', `{{ url('/products/status/${id}') }}`)
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: `เปลี่ยนสถานะการใช้งาน ${product}`,
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $('.form_update_status').submit()
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'ยกเลิกแล้ว',
                '',
                'error'
            )
        }
    })

}
</script>
@endsection