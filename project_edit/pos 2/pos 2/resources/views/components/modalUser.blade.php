<!-- Modal -->
<div class="modal fade" id="modalUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="textShowStatus">
                    เพิ่มผู้ใช้งานใหม่</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-horizontal" method="POST" id="UserForm" action="{{ route('users.store') }}">
                @csrf
                <input type="hidden" id="id_user" name="id_user">
                <div class="modal-body">
                    <div id="create-category">
                        @csrf
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อ *</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="โปรดระบุชื่อ" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                นามสกุล *</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="โปรดระบุนามสกุล" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                เบอร์โทร *</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="ระบุเบอร์โทร" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ตำแหน่ง *</label>
                            <div class="col-sm-9">
                                <select name="department" id="department" class="form-select">
                                    <option value="" disabled selected>เลือกตำแหน่ง</option>
                                    @foreach ($departments_all as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                เงินเดือน *</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="salary" name="salary"
                                    placeholder="โปรดระบุเงินเดือน" />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                อีเมลล์ผู้ใช้ *</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="โปรดระบุอีเมลล์ผู้ใช้" />
                            </div>
                        </div>
                        <div class="form-group row" id="input_password">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                รหัสผ่าน *</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="โปรดระบุรหัสผ่าน" />
                            </div>
                        </div>
                        <div class="form-group row" id="input_cpassword">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ยืนยันรหัสผ่าน *</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="โปรดยืนยันรหัสผ่าน" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary " id="btn-add-user">บันทึก</button>
                </div>
            </form>

            {{-- <form class="form-horizontal" method="PUT" id="UserForm_update" action="">
                @csrf
                <div class="modal-body">
                    <div id="create-category">
                        @csrf
                  
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ชื่อ</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="first_name_edit" name="first_name"
                                    placeholder="โปรดระบุชื่อ" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                นามสกุล</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="last_name_edit" name="last_name"
                                    placeholder="โปรดระบุนามสกุล" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ตำแหน่ง</label>
                            <div class="col-sm-9">
                                <select name="department" id="department_edit" class="form-select">
                                    <option value="" disabled selected>เลือกตำแหน่ง</option>
                                    @foreach ($departments_all as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                เงินเดือน</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="salary_edit" name="salary"
                                    placeholder="โปรดระบุเงินเดือน" />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                อีเมลล์ผู้ใช้</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email_edit" name="email"
                                    placeholder="โปรดระบุอีเมลล์ผู้ใช้" />
                            </div>
                        </div>
                        <div class="form-group row" id="input_password">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                รหัสผ่าน</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_edit" name="password"
                                    placeholder="โปรดระบุรหัสผ่าน" />
                            </div>
                        </div>
                        <div class="form-group row" id="input_cpassword">
                            <label for="fname" class="col-sm-3 text-end control-label col-form-label">
                                ยืนยันรหัสผ่าน</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_confirmation_edit"
                                    name="password_confirmation" placeholder="โปรดยืนยันรหัสผ่าน" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary ">บันทึก</button>
                </div>
            </form> --}}
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

