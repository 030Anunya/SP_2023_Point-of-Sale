<!-- Modal -->
<div class="modal fade" id="modaldepartment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="text-status">
                    เพิ่มตำแหน่งใหม่</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" id="department-create" action="{{ route('department.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                            ชื่อตำแหน่ง</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="department_name" name="department_name"
                                placeholder="โปรดระบุตำแหน่ง" />
                                <div id="show_error" class="text-danger d-none">กรุณาระบุตำแหน่ง</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary " onclick="saveDepartment()">บันทึก</button>
                </div>
            </form>
            <form class="form-horizontal d-none" id="department-update" action="{{ route('department.update', 45) }}"
                method="POST">
                <div class="modal-body">
                    <div id="create-category">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อตำแหน่ง</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="department_name_edit"
                                    name="department_name_edit" placeholder="โปรดระบุหมวดหมู่สินค้า" />
                                    <div id="show_error_edit" class="text-danger d-none">กรุณาระบุตำแหน่ง</div>
                                </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" onclick="saveDepartment()">อัพเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>
