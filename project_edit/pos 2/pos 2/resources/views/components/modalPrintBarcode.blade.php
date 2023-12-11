<div class="modal fade" id="modalPrintBarcode" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">จำนวนการพิมพ์</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="product_print_id" name="product_print_id">
                <select name="count_row_barcode" id="count_row_barcode" class="form-select">
                    <option value="1">1 แถว (3)</option>
                    <option value="2">2 แถว (6)</option>
                    <option value="3">3 แถว (9)</option>
                    <option value="4">4 แถว (12)</option>
                    <option value="5">5 แถว (15)</option>
                    <option value="6">6 แถว (18)</option>
                    <option value="7">7 แถว (21)</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="printBarcodeShow()">พิมบาร์โค้ดสินค้า</button>
            </div>
        </div>
    </div>
</div>

<script>
    function printBarcode(id) {
        $('#product_print_id').val(id)
        $('#modalPrintBarcode').modal('show')
    }

    function printBarcodeShow() {

        var productPrintId = $('#product_print_id').val();
        var countRowBarcode = $('#count_row_barcode').val();

        var url = '/barcodeProduct/' + productPrintId + '?count=' + countRowBarcode;

        window.open(url);
    }
</script>
