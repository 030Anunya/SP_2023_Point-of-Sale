<!-- Modal -->
<div class="modal fade" id="modalExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    เพิ่มหมวดหมู่ใหม่</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/products/import') }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="file" name="file" class="form-control" required
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        <p class="mt-3"><b>ตัวอย่างการนำเข้า </b>   <a href="storage/excel/product.xlsx" download="product_import.xlsx">ดาน์โหลด Excel</a></p>
                        <img src="storage/uploads/example_excel.png" alt="" class="w-100">
                        <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary w-100">บันทึก</button>
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
