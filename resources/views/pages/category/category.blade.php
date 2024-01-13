@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">หมวดหมู่สินค้า</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        หมวดหมู่สินค้า
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
                        <button type="button" class="btn btn-primary"onclick="showCategoryModal()">
                            เพิ่มหมวดหมู่
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>ชื่อหมวดหมู่</th>
                                    <th>จัดการ</th>
                                </tr>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($categorys as $category)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-warning"
                                                    onclick="showCategoryModal({{ $category->id }}, '{{ $category->category_name }}')"><i
                                                        class="mdi mdi-pencil"></i></button>
                                                <form action="{{ route('categorys.destroy', $category->id) }}"
                                                    method="POST" class="deleteForm_category">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" onclick="removeCategory({{$category->id}}, '{{ $category->category_name }}')"><i
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
    @include('components.modalCategory')
    <script>
        function showCategoryModal(categoryId = null, categoryName = "") {
            console.log(categoryName);
            const form_create = $('#categoryForm-create');
            const form_update = $('#categoryForm-update')

            const modal = $('#modalcategory');

            if (categoryId === null) {
                form_create.removeClass('d-none')
                form_update.addClass('d-none')
                $('#category_name').val("");
            } else {
                form_update.removeClass('d-none')
                form_create.addClass('d-none')
                form_update.attr('action', `{{ route('categorys.update', ['category' => ':category_id']) }}`.replace(
                    ':category_id', categoryId));
                $('#category_name_edit').val(categoryName);
            }

            modal.modal('show');
        }

        function removeCategory(id, category) {
            $('.deleteForm_category').attr('action', `{{ route('categorys.destroy', ['category' => ':id']) }}`
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
                title: `คุณต้องการลบ ${category}`,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.deleteForm_category').submit()
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
