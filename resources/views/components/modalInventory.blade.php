<!-- Modal -->
<div class="modal fade" id="modalInventory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    อัปเดตสต็อกสินค้า</h1>
            </div>
            <form class="form-horizontal" action="{{ url('/update_stock') }}" method="POST">
                @csrf
                <input type="hidden" name="id_product" id="id_product">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2">
                            <img width="72" height="72"
                                src="https://jimlimid.com/wp-content/uploads/2022/10/AnyConv.com__9113474dec8f3ec86efabed5539cb275.jpg"
                                alt="">
                        </div>
                        <div class="col-10">
                            <span class="d-block ms-2" id="product_name"></span>
                            <span class="d-block ms-2" id="product_category"></span>
                            <span class="d-block ms-2" id="product_code"></span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="fs-5 my-2">มีสินค้า</span>
                            <span class="fs-5 mb-2">
                                <span class="text-secondary" id="count_quantify"></span>
                                <span id="resout_count_quantity"></span>
                                <span class="d-none" id="old_resout_count_quantity"></span>
                            </span>
                        </div>
                        {{-- input hidden --}}

                        <input type="hidden" id="old_count_quantify" class="d-none" />
                        <input id="stock_count" type="hidden" class="d-none" />

                        <div class="d-flex justify-content-between">
                            <span class="fs-5 mb-2">สินค้าที่ขายแล้ว</span>
                            <span class="fs-5 mb-2" id="sale_prdouct"></span>
                            <span class="fs-5 mb-2 d-none" id="old_sale_prdouct"></span>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fs-5 mb-2">สินค้าที่พร้อมขาย</span>

                            <span class="fs-5 mb-2">
                                <span class="text-secondary" id="ready_sale"></span>
                                <span id="success_ready_sale"></span>
                            </span>

                        </div>

                        <div class="btn-group d-flex justify-content-between my-3">
                            <button type="button" class="btn btn-outline-primary btn-update"
                                onclick="showinput(1)">ยอดรวม</button>
                            <button type="button" class="btn btn-outline-primary btn-increase"
                                onclick="showinput(2)">เพิ่ม</button>
                            <button type="button" class="btn btn-outline-primary btn-drease"
                                onclick="showinput(3)">ลด</button>
                        </div>
                        <div id="" class="d-block updatestock">
                            <p>อัปเดตจำนวนสินค้า*</p>
                            <input id="input_update_stock" name="qty[]" type="number" min="1" class="form-control"
                                placeholder="โปรดระบุ" onkeyup="updateValue(event)">
                        </div>
                        <div class="d-none increasestock">
                            <p>เพิ่มจำนวนสินค้า*</p>
                            <input type="number" min="1" id="input_increase_stock" onkeyup="addValue(event)"
                                class="form-control" name="qty[]" placeholder="โปรดระบุ">
                        </div>
                        <div id="" class="d-none dreasestock">
                            <p>ลดจำนวนสินค้า*</p>
                            <input type="number" min="1" onkeyup="delValue(event)" id="input_decrease_stock"
                                class="form-control" name="qty[]" placeholder="โปรดระบุ">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    function updateValue(e) {
        var resoutCountQuantity = $('#resout_count_quantity');
        var successCountQuantify = $('#success_ready_sale')
        if (e.target.value === "") {
            successCountQuantify.text($('#stock_count').val())
            resoutCountQuantity.text($('#old_count_quantify').val());
        } else {
            resoutCountQuantity.text(e.target.value);
            successCountQuantify.text(+e.target.value - +$('#sale_prdouct').text())
        }
    }

    function addValue(e) {
        let resoutCountQuantity = $('#resout_count_quantity');
        let stockCount = parseInt($('#stock_count').val());
        if (e.target.value === "") {
            resoutCountQuantity.text($('#old_count_quantify').val());
            $('#success_ready_sale').text(stockCount)
        } else {
            const result_value_show = +$('#old_sale_prdouct').text() + +e.target.value;
            console.log(result_value_show);
            $('#success_ready_sale').text(result_value_show);
            resoutCountQuantity.text(result_value_show + +$('#sale_prdouct').text())
        }
    }

    function delValue(e) {
        let resoutCountQuantity = $('#resout_count_quantity');
        let stockCount = parseInt($('#stock_count').val());
        if (e.target.value === "") {
            resoutCountQuantity.text($('#old_count_quantify').val());
            $('#success_ready_sale').text(stockCount)
        } else {
            const result_value_show = +$('#old_sale_prdouct').text() - +e.target.value;
            $('#success_ready_sale').text(result_value_show);
            resoutCountQuantity.text(+$('#old_resout_count_quantity').text() - +e.target.value)
        }
    }



    function showinput(choice) {
        status = choice;
        var updatestock = $('.updatestock')
        var increasestock = $('.increasestock')
        var dreasestock = $('.dreasestock')
        var btn_update = $('.btn-update')
        var btn_crease = $('.btn-increase')
        var btn_drease = $('.btn-drease')
        increasestock.addClass('d-none')
        dreasestock.addClass('d-none')
        btn_update.addClass('active')

        if (choice === 1) {
            $('#resout_count_quantity').text($('#old_resout_count_quantity').text())
            $('#input_increase_stock').attr('required', false)
            $('#input_decrease_stock').attr('required', false)
            $('#input_update_stock').attr('required', true)
            $('#input_update_stock').val('')
            $('#input_increase_stock').val('')
            $('#input_decrease_stock').val('')
            btn_update.addClass('active')
            btn_crease.removeClass('active')
            btn_drease.removeClass('active')
            updatestock.removeClass('d-none')
            updatestock.addClass('d-block')
            increasestock.removeClass('d-block')
            increasestock.addClass('d-none')
            dreasestock.removeClass('d-block')
            dreasestock.addClass('d-none')

        } else if (choice == 2) {
            $('#resout_count_quantity').text($('#old_resout_count_quantity').text())
            $('#input_increase_stock').attr('required', true)
            $('#input_decrease_stock').attr('required', false)
            $('#input_update_stock').attr('required', false)
            $('#input_update_stock').val('')
            $('#input_increase_stock').val('')
            $('#input_decrease_stock').val('')
            btn_crease.addClass('active')
            btn_update.removeClass('active')
            btn_drease.removeClass('active')
            updatestock.removeClass('d-block')
            updatestock.addClass('d-none')
            increasestock.removeClass('d-none')
            increasestock.addClass('d-block')

        } else if (choice == 3) {
            $('#resout_count_quantity').text($('#old_resout_count_quantity').text())
            $('#input_increase_stock').attr('required', false)
            $('#input_decrease_stock').attr('required', true)
            $('#input_update_stock').attr('required', false)

            $('#input_update_stock').val('')
            $('#input_increase_stock').val('')
            $('#input_decrease_stock').val('')
            btn_drease.addClass('active')
            btn_crease.removeClass('active')
            btn_update.removeClass('active')
            updatestock.removeClass('d-block')
            updatestock.addClass('d-none')
            increasestock.removeClass('d-block')
            increasestock.addClass('d-none')
            dreasestock.removeClass('d-none')
            dreasestock.addClass('d-block')
        }
    }

    function closeModal() {
        $('#modalInventory').modal('hide')
        var updatestock = $('.updatestock')
        var increasestock = $('.increasestock')
        var dreasestock = $('.dreasestock')
        var btn_update = $('.btn-update')
        var btn_crease = $('.btn-increase')
        var btn_drease = $('.btn-drease')

        updatestock.removeClass('d-none')
        updatestock.addClass('d-block')
        increasestock.removeClass('d-block')
        increasestock.addClass('d-none')
        dreasestock.removeClass('d-block')
        dreasestock.addClass('d-none')
        btn_update.addClass('active')
        btn_crease.removeClass('active')
        btn_drease.removeClass('active')
    }
</script>
