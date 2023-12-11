@extends('layouts')
@section('bread')
<div class="col-12 d-flex no-block align-items-center">
    <h4 class="page-title">ขายสินค้า</h4>
    <div class="ms-auto text-end">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    ขายสินค้า
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row" id="sale">
    <div class="col-7">
        <div class="card">
            <div class="card-body">
                <ul class="pagination">
                    <li v-if="currentPage > 1" v-on:click="prevPage">
                        &laquo;
                    </li>
                    <li v-for="page in visiblePageRange" :key="page" v-on:click="changePage(page)"
                        :class="{ active: currentPage === page }">
                        @{{ page }}
                    </li>
                    <li v-if="shouldShowEndEllipsis">
                        <span>...</span>
                    </li>
                    <li v-if="currentPage < totalPages" v-on:click="nextPage">
                        &raquo;
                    </li>
                </ul>
                <div class="row">
                    <div class="col-4">
                        <select v-model="selectedCategory" class="form-select">
                            <option value="">หมวดหมู่ทั้งหมด</option>
                            <option v-bind:value="category.id" v-for="(category, index) in allCategory" :key="index">
                                @{{ category.category_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-8">

                        <input v-model="searchQuery" v-on:input="searchProducts" type="text" class="form-control"
                            placeholder="ค้นหาสินค้า">


                    </div>


                    <div class="col-4 col-lg-4 col-xl-3 shadow mt-2 mb-1 " v-for="(product,index) in displayedProducts"
                        :key="index" v-on:click="addCart(product)">
                        <div class="card">
                            <img :src="product.product_img !== null ? `storage/uploads/${product.product_img}` :
                                    'storage/uploads/no-product.jpg'" class="card-img-top"
                                style="width: 100%; height: 150px; object-fit: contain;" alt="">

                            <div class="card-body">
                                <h6 class="card-title text-center text-success">@{{ product.product_name }}</h6>
                                <p class="card-text text-center">
                                <div v-if="displayedProducts[index].features.length >= 1">
                                    <div v-for="(feature,index) in displayedProducts[index].features" :key="index">
                                        <span class=" border-bottom border-2">@{{feature.feature2}} / @{{feature.feature1}}</span>
                                    </div>
                                </div>
                                <div class="text-center" v-else>
                                    <span >@{{formatPrice(product.product_price)}} บาท</span>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-if="displayedProducts.length === 0" class="no-products">
                        <h3 class="text-center mt-3">ไม่มีสินค้า @{{ searchQuery }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="get" v-on:submit.prevent="searchProduct">
                        @csrf
                        <div class="input-group">
                            <input v-model="searchProductInput" type="text" class="form-control"
                                placeholder="รหัสสินค้า">
                            <button type="submit" class="input-group-text bg-info text-white"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                    <p>*
                        <span
                            :class="successSearchInput === 'เพิ่มสินค้าสำเร็จ' ? 'text-success' : 'text-danger'">@{{ successSearchInput }}</span>
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">สินค้า</th>
                                    <th scope="col">จำนวน</th>
                                    <th scope="col">รวม/บาท</th>
                                    <th scope="col">ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(cart,index) in MyCart" :key="index">
                                    <td scope="row">@{{ cart.product_name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between">

                                        </div>
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="col text-start btn-decrease"
                                                v-on:click="decreaseQuantity(cart)">-</div>
                                            <div class="col text-center">@{{ cart.quantity }}</div>
                                            <div class="col text-end btn-increase" v-on:click="increaseQuantity(cart)">+
                                            </div>
                                        </div>
                                    </td>
                                    <td>@{{ formatPrice(cart.totalPrice) }}</td>
                                    <td><button class="btn btn-danger"
                                            v-on:click="removeProductFromCart(cart)">ลบ</button></td>
                                </tr>
                                <tr v-if="MyCart.length <=0">
                                    <td colspan="4" class="text-center">ไม่มีสินค้า</td>
                                </tr>
                                <tr v-if="showVat">
                                    <td colspan="1">ราคา Vat</td>
                                    <td colspan="3" class="text-end">
                                        @{{ formatPrice(calculatePriceWithVAT(totalCart)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <h4>ราคารวม</h4>
                            <button v-on:click="toggleVat"
                                :class="`btn  ${!showVat ? 'btn-info': 'btn-primary'}`">@{{ !showVat ? 'เพิ่ม VAT 7%' : 'ปิด VAT 7 %' }}</button>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <h4>฿ @{{ formatPrice(totalCartPrice) }}</h4>
                            <span>@{{ MyCart.length }} รายการ</span>
                        </div>
                        <button class="btn btn-success w-100 text-white" v-on:click="showCals">ชำระเงิน</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                        คิดเงิน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">

                            <h5 class=" alert alert-primary w-100 text-center">ข้อมูลชำระเงิน</h5>
                            <div class="row p-2" style="text-align: right;">
                                <div class="col-5 mb-2">จำนวนเงิน</div>
                                <div class="col-7 mb-2">
                                    <input type="text" v-model="formatPrice(totalCartPrice)" disabled="disabled"
                                        class="form-control" style="text-align: right;">
                                </div>
                                <div class="col-5 mb-2">รับเงิน</div>
                                <div class="col-7 mb-2">
                                    <input type="text" disabled="disabled" v-bind:value="formatPrice(currentInput)"
                                        class="form-control" style="text-align: right;" />
                                </div>
                                <div class="col-5 mb-2">ทอนเงิน</div>
                                <div class="col-7 mb-2">
                                    <input v-model="formatPrice(changeMoneyPay)" type="text" disabled="disabled"
                                        class="form-control" style="text-align: right;" />
                                </div>
                                <div class="col-5 mb-2">การรับเงิน</div>
                                <div class="col-7 mb-2">
                                    <select name="" id="" v-model="choicePayment" class="form-select"
                                        v-on:change="checkStatusPay">
                                        <option value="1">เงินสด</option>
                                        <option value="2">โอนเงิน/พร้อมเพย์</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="calculator">
                                <div class="buttons">
                                    <button v-for="button in buttons" :key="button.value"
                                        v-on:click="handleButtonClick(button)">@{{ button.label }}</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer w-100">
                        <button type="button" class="btn btn-primary w-100" v-on:click="checkout"
                            id="btn-checkout">ยันยืนการชำระเงิน</button>
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalPrint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                        ปริ้นใบเสร็จ</h1>
                    <button type="button" class="btn-close" v-on:click="closeCheckOut" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>สินค้า</th>
                                <th style="text-align: right;">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(cart,index) in MyCart" :key="index">
                                <td>@{{ cart.product_name }}</td>
                                <td style="text-align: right;">@{{ cart.quantity }}</td>
                            </tr>
                        </tbody>
                        <tr>
                            <td>รวมเงินทั้งสิ้น</td>
                            <td style="text-align: right;">@{{ formatPrice(totalCartPrice) }}</td>
                        </tr>
                        <tr>
                            <td>รับเงิน</td>
                            <td style="text-align: right;">@{{ formatPrice(currentInput) }}</td>
                        </tr>
                        <tr style="border-bottom: none">
                            <td>เงินทอน</td>
                            <td style="text-align: right;">@{{ formatPrice(changeMoneyPay) }}</td>
                        </tr>
                    </table>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-primary" v-on:click="printMini">ใบเสร็จย่อ</button>
                        <button type="button" class="btn btn-secondary" v-on:click="printFull">ใบเสร็จเต็ม</button>
                    </div>

                </div>
            </div>
        </div>


    </div>
    <!-- Modal -->
    <div class="modal fade" id="selectFeature" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                        เลือกคุณสมบัติสินค้า</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">สินค้า : @{{ productName }}</h3>
                    <hr>
                    <p v-if="successSearchInput != ''"
                        :class=" successSearchInput === 'เพิ่มสินค้าสำเร็จ' ? 'alert alert-success col-12' : 'alert alert-danger'">
                        * @{{ successSearchInput }}</p>
                    <div class="d-flex justify-content-center row">

                        <div class="btn-group  col-3 mb-3" v-for="(productFeature,index) in productFeatures"
                            :key="index">
                            <button v-on:click="addCartFeature(productFeature)"
                                class="btn btn-outline-primary mx-2">@{{ productFeature.feature1 }}/@{{ productFeature.feature2 }}
                                ฿@{{ productFeature.product_price }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>





<script>
var app = new Vue({
    el: '#sale',
    data: {
        allProduct: [],
        allCategory: [],
        MyCart: [],
        currentPage: 1,
        productsPerPage: 9,
        visiblePages: 5,
        searchQuery: '',
        selectedCategory: '',
        showVat: false,
        currentInput: 0,
        priceCart: 0,
        changeMoneyPay: 0,
        choicePayment: 1,
        vat: 0,
        print_id: null,
        searchProductInput: '',
        successSearchInput: '',
        productFeatures: [],
        productName: "",
        buttons: [{
                label: '1',
                value: '1'
            },
            {
                label: '2',
                value: '2'
            },
            {
                label: '3',
                value: '3'
            },

            {
                label: '4',
                value: '4'
            },
            {
                label: '5',
                value: '5'
            },
            {
                label: '6',
                value: '6'
            },
            {
                label: '7',
                value: '7'
            },
            {
                label: '8',
                value: '8'
            },
            {
                label: '9',
                value: '9'
            },
            {
                label: 'C',
                value: 'C'
            },
            {
                label: '0',
                value: '0'
            },

        ],
    },
    computed: {
        displayedProducts() {
            let products = this.allProduct;
            if (this.selectedCategory) {
                products = products.filter(product => product.category_id == this.selectedCategory);
            }
            const startIndex = (this.currentPage - 1) * this.productsPerPage;
            const endIndex = startIndex + this.productsPerPage;
            return products.slice(startIndex, endIndex);

        },
        totalPages() {
            return Math.ceil(this.allProduct.length / this.productsPerPage);
        },
        startPage() {
            let start = this.currentPage - Math.floor(this.visiblePages / 2);
            if (start < 1) {
                start = 1;
            }
            return start;
        },
        endPage() {
            let end = this.startPage + this.visiblePages - 1;
            if (end > this.totalPages) {
                end = this.totalPages;
            }
            return end;
        },
        shouldShowStartEllipsis() {
            return this.startPage > 1;
        },
        shouldShowEndEllipsis() {
            return this.endPage < this.totalPages;
        },
        visiblePageRange() {
            const range = [];
            for (let i = this.startPage; i <= this.endPage; i++) {
                range.push(i);
            }
            return range;
        },
        totalCartPrice() {
            const rawTotal = this.MyCart.reduce((total, cartItem) => total + parseFloat(cartItem
                .totalPrice), 0);
            this.priceCart = rawTotal;
            if (!this.showVat) {
                return rawTotal;
            } else {
                const totalWithVAT = parseFloat(rawTotal) + parseFloat(this.calculatePriceWithVAT(
                    rawTotal));
                return totalWithVAT;
            }
        },
        totalCart() {
            const totalPrice = this.MyCart.reduce((total, cartItem) => total + parseFloat(cartItem
                .totalPrice), 0);
            return totalPrice.toFixed(2);
        },

    },
    methods: {
        async searchProduct() {
            const formData = new FormData();
            formData.append('inputSearchProduct', this.searchProductInput);

            try {
                let response = await axios.post('/searchProduct', formData);

                if (response.status === 200) {



                    const product = response.data;

                    const existingCartItem = this.MyCart.find(item => item.id === product.id);

                    if (existingCartItem) {
                        existingCartItem.quantity++;
                        existingCartItem.totalPrice = existingCartItem.quantity * existingCartItem
                            .product_price;
                    } else {
                        const cartProduct = {
                            ...product,
                            quantity: 1,
                            totalPrice: product.product_price
                        };
                        this.MyCart.push(cartProduct);
                    }
                    app.successSearchInput = 'เพิ่มสินค้าสำเร็จ';
                }
                this.searchProductInput = ''
            } catch (error) {
                app.successSearchInput = error.response.data.error
                this.searchProductInput = ''
                console.error('Error:', error);
            }
        },


        printMini() {
            const printWindow = window.open(`/generate-pdfmini/${this.print_id}`, '',
                'width=900,height=900');
            printWindow.onload = function() {
                printWindow.print();
                // printWindow.close();

            };
        },
        printFull() {
            const printWindow = window.open(`/generate-pdffull/${this.print_id}`, '',
                'width=900,height=900');
            printWindow.onload = function() {
                printWindow.print();
                // printWindow.close();
            };
        },
        checkStatusPay() {
            if (this.choicePayment == 1) {
                this.currentInput = 0
                this.changeMoneyPay = 0
            } else {
                this.currentInput = this.totalCartPrice
                this.changeMoneyPay = this.totalCartPrice - this.totalCartPrice
            }
        },
        closeCheckOut() {
            this.MyCart = []
            this.showVat = false
            this.choicePayment = 1
            this.currentInput = 0
            $('#modalPrint').modal('hide')
        },
        async checkout() {
            $('#btn-checkout').text('ยันยืนการชำระเงิน...')
            $('#btn-checkout').attr('disabled', '')
            if (parseFloat(app.currentInput, 10) <= 0) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'กรุณากรอกจำนวนรับเงิน',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if (parseFloat(app.currentInput, 10) < app.totalCartPrice) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'จำนวนเงินต้องมากกว่าราคาสินค้า',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if (parseFloat(app.changeMoneyPay, 10) > 1000) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'ไม่สามารถทอนเงินเกิน 1,000 บาท',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                const formData = new FormData();
                formData.append('changeMoney', app.changeMoneyPay);
                formData.append('getMoney', parseFloat(app.currentInput, 10));
                formData.append('totalPrice', app.priceCart)
                formData.append('totalPriceVat', app.totalCartPrice)
                formData.append('vat', app.vat)
                const cart = this.MyCart;
                for (let i = 0; i < cart.length; i++) {
                    const cartItem = cart[i];
                    formData.append(`cart[${i}][product_id]`, cartItem.id);
                    formData.append(`cart[${i}][quantity]`, cartItem.quantity);
                    formData.append(`cart[${i}][product_price]`, cartItem.product_price);
                    formData.append(`cart[${i}][product_cost]`, cartItem.product_cost);
                    formData.append(`cart[${i}][product_name]`, cartItem.product_name);
                    formData.append(`cart[${i}][feature]`, cartItem.feature);
                }
                try {
                    let response = await axios.post('listsale', formData);
                    this.print_id = response.data.Print_id
                    this.successSearchInput = ''
                    $('#modalCal').modal('hide');
                    $('#modalPrint').modal('show');
                } catch (e) {
                    console.log(e);
                }
            }

        },

        showCals() {
            if (this.MyCart.length <= 0) {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'กรุณาเลือกสินค้าก่อน',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                $('#btn-checkout').text('ยันยืนการชำระเงิน')
                $('#btn-checkout').removeAttr('disabled', '')
                $('#modalCal').modal('show')
            }
        },
        handleButtonClick(button) {
            if (button.value === '=') {
                this.calculate();
            } else if (button.value === 'C') {
                this.currentInput = 0;
                this.changeMoneyPay = 0
            } else {
                this.currentInput += button.value;
                if (this.choicePayment == 1 && this.currentInput <= this.totalCartPrice) {
                    this.changeMoneyPay = this.totalCartPrice - this.currentInput
                } else if ((this.currentInput - this.totalCartPrice) + (this.currentInput - this
                        .totalCartPrice)) {
                    // Swal.fire({
                    //     position: 'center',
                    //     icon: 'error',
                    //     title: 'ท่านกรอกรับ',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // })
                    this.changeMoneyPay = (this.currentInput - this.totalCartPrice)
                } else {
                    this.priceCart = this.currentInput
                    this.changeMoneyPay = this.priceCart
                }
            }
        },
        calculate() {
            try {
                this.result = eval(this.currentInput);
            } catch (error) {
                this.result = 'Error';
            }
        },
        clear() {
            this.currentInput = 0;
            this.result = '';
        },
        toggleVat() {
            this.showVat = !this.showVat
        },
        calculatePriceWithVAT(price) {
            const vatAmount = (price * 7) / 100;
            this.vat = vatAmount
            return vatAmount.toFixed(2);
        },
        searchProducts() {
            if (this.searchQuery.trim() === '') {
                this.currentPage = 1;
                this.getProduct();
            } else {
                const filteredProducts = this.allProduct.filter(product =>
                    product.product_name.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
                this.currentPage = 1;
                this.allProduct = filteredProducts;
            }
        },
        async getProduct() {
            try {
                let response = await axios.get('/products')
                this.allProduct = response.data.products
                console.log(this.allProduct);
            } catch (e) {
                console.log(e);
            }
        },
        async getCategory() {
            try {
                let response = await axios.get('/categorys')
                this.allCategory = response.data.category
            } catch (e) {
                console.log(e);
            }
        },
        addCartFeature(product) {
            const existingCartItem = this.MyCart.find(item => item.id === product.product_id);

            if (existingCartItem) {
                const check_id = this.MyCart.find(item => item.feature_id === product.id);

                if (check_id) {
                    if (check_id.quantity < check_id.stock) {
                        check_id.quantity++;
                        check_id.totalPrice = check_id.quantity * check_id
                            .product_price;
                    } else {
                        this.successSearchInput = "สต็อกสินค้าไม่เพียงพอ"
                    }
                } else {
                    const find_product_name = this.allProduct.find(item => item.id === product.product_id);
                    const feature2 = product.feature2 ? '/' + product.feature2 : '';
                    const cartProduct = {
                        id: product.product_id,
                        feature_id: product.id,
                        stock: product.stock,
                        feature: product.feature1 + feature2,
                        product_price: product.product_price,
                        product_name: find_product_name.product_name + " (" + product.feature1 + '/' +
                            product
                            .feature2 + ")",
                        quantity: 1,
                        totalPrice: product.product_price
                    };
                    this.MyCart.push(cartProduct);
                    app.successSearchInput = 'เพิ่มสินค้าสำเร็จ';
                }


            } else {
                const find_product_name = this.allProduct.find(item => item.id === product.product_id);
                const feature2 = product.feature2 ? '/' + product.feature2 : '';
                const cartProduct = {
                    id: product.product_id,
                    feature_id: product.id,
                    stock: product.stock,
                    feature: product.feature1 + feature2,
                    product_price: product.product_price,
                    product_name: find_product_name.product_name + " (" + product.feature1 + '/' +
                        product.feature2 + ")",
                    quantity: 1,
                    totalPrice: product.product_price
                };
                this.MyCart.push(cartProduct);
                app.successSearchInput = 'เพิ่มสินค้าสำเร็จ';
            }
        },
        addCart(product) {
            if (product.features.length > 0) {
                $('#selectFeature').modal('show')
                this.productFeatures = product.features
                this.productName = product.product_name
            } else {
                const existingCartItem = this.MyCart.find(item => item.id === product.id);

                if (existingCartItem) {
                    if (existingCartItem.quantity < existingCartItem.stock) {
                        existingCartItem.quantity++;
                        existingCartItem.totalPrice = existingCartItem.quantity * existingCartItem
                            .product_price;
                    } else {
                        this.successSearchInput = "สต็อกสินค้าไม่เพียงพอ"
                    }

                } else {
                    const cartProduct = {
                        ...product,
                        quantity: 1,
                        feature: null,
                        totalPrice: product.product_price
                    };
                    this.MyCart.push(cartProduct);
                }
            }

        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        changePage(page) {
            this.currentPage = page;
        },
        increaseQuantity(cartItem) {
            cartItem.quantity++;
            cartItem.totalPrice = cartItem.quantity * cartItem.product_price;
        },

        decreaseQuantity(cartItem) {
            if (cartItem.quantity > 1) {
                cartItem.quantity--;
                cartItem.totalPrice = cartItem.quantity * cartItem.product_price;
            }
        },
        removeProductFromCart(cartItem) {
            const index = this.MyCart.indexOf(cartItem);
            if (index !== -1) {
                this.MyCart.splice(index, 1);
            }

            app.successSearchInput = 'ลบสินค้าสำเร็จ';
        },
        formatPrice(value) {
            return parseFloat(value).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
    },
    mounted() {
        this.getProduct()
        this.getCategory()
    },
})
</script>

<style>
.pagination {
    list-style: none;
    display: flex;
    justify-content: center;

}

.pagination li {
    margin: 0 5px;
    cursor: pointer;
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    background-color: #f9f9f9;
}

.pagination li.active {
    background-color: #3490dc;
    color: white;
}

.pagination li.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination button {
    padding: 5px 10px;
    background-color: #3490dc;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin: 0 5px;
}

.pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

ul li {
    list-style: none
}

.btn-decrease,
.btn-increase {
    cursor: pointer;
}

.calculator {
    /* width: 300px; */
    /* margin: 50px auto; */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.display {
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
    font-size: 20px;
}

.buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 10px;
}

button {
    padding: 10px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.result {
    font-size: 20px;
    font-weight: bold;
}
</style>
@endsection