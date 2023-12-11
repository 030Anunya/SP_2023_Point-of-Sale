<!-- Modal -->
<div class="modal fade" id="modalsubcategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    เพิ่มหมวดหมู่ใหม่</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="subcategoryForm-create" action="{{ route('subcategory.store') }}"
                method="POST">
                <div class="modal-body">
                    <div id="create-category">
                        @csrf
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อหมวดหมู่</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="selct_category" id="selct_category" required>
                                    <option value="" disabled selected>เลือกหมวดหมู่</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อหมวดหมู่</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sub_category_name"
                                    name="sub_category_name" placeholder="โปรดระบุหมวดหมู่สินค้า" required />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary " id="saveCategory">บันทึก</button>
                </div>
            </form>
            <form class="form-horizontal d-none" id="subcategoryForm-update"
                action="{{ route('subcategory.update', 45) }}" method="POST">
                <div class="modal-body">
                    <div id="create-category">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อหมวดหมู่</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="selct_category_sub" id="selct_category_sub" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อหมวดหมู่แก้ไข</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sub_category_name_edit"
                                    name="sub_category_name_edit" placeholder="โปรดระบุหมวดหมู่สินค้า" required />
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
