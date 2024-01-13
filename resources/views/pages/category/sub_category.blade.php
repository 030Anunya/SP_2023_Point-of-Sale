@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">ประเภทสินค้า</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        ประเภทสินค้า
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
                    <div class="d-flex justify-content-end mb-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary"onclick="showCategoryModal()">
                            เพิ่มประเภท
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>หมวดหมู่</th>
                                    <th>ประเภท</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($subcategorys as $subcategory)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $subcategory->category->category_name }}</td>
                                        <td>{{ $subcategory->sub_category_name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-warning"
                                                    onclick="showCategoryModal({{ $subcategory->id }}, '{{ $subcategory->sub_category_name }}',{{ $subcategory->category->id }})"><i
                                                        class="mdi mdi-pencil"></i></button>
                                                <form action="{{ route('subcategory.destroy', $subcategory->id) }}"
                                                    method="POST" class="deleteForm_subcategory">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" onclick="removeSubCategory({{ $subcategory->id }}, '{{ $subcategory->sub_category_name }}')"><i
                                                            class="mdi mdi-delete"></i></button>
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
    </div>
    @include('components.modalSubCategory')
    <script>
        function showCategoryModal(SubCategoryId = null, subCategoryName = "", idCategory = null) {
            const form_create = $('#subcategoryForm-create');
            const form_update = $('#subcategoryForm-update')

            const modal = $('#modalsubcategory');

            if (SubCategoryId === null) {
                form_create.removeClass('d-none')
                form_update.addClass('d-none')
                $('#sub_category_name').val("");
            } else {
                form_update.removeClass('d-none')
                form_create.addClass('d-none')
                form_update.attr('action', `{{ route('subcategory.update', ['subcategory' => ':subcategory_id']) }}`
                    .replace(
                        ':subcategory_id', SubCategoryId));
                $('#sub_category_name_edit').val(subCategoryName);
                $('#selct_category_sub').val(idCategory)
            }

            modal.modal('show');
        }

        function removeSubCategory(id, subcategory) {
            $('.deleteForm_subcategory').attr('action', `{{ route('subcategory.destroy', ['subcategory' => ':id']) }}`
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
                title: `คุณต้องการลบ ${subcategory}`,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.deleteForm_subcategory').submit()
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
