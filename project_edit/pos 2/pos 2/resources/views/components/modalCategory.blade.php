<!-- Modal -->
<div class="modal fade" id="modalcategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    เพิ่มหมวดหมู่ใหม่</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="categoryForm-create" action="{{ route('categorys.store') }}"
                method="POST">
                <div class="modal-body">
                    <div id="create-category">
                        @csrf
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อหมวดหมู่</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="category_name" name="category_name"
                                    placeholder="โปรดระบุหมวดหมู่สินค้า" required />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary " id="saveCategory">บันทึก</button>
                </div>
            </form>
            <form class="form-horizontal d-none" id="categoryForm-update" action="{{ route('categorys.update', 45) }}"
                method="POST">
                <div class="modal-body">
                    <div id="create-category">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                แก้ไขชื่อหมวดหมู่</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="category_name_edit"
                                    name="category_name_edit" placeholder="โปรดระบุหมวดหมู่สินค้า" required />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary " id="saveCategory">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
