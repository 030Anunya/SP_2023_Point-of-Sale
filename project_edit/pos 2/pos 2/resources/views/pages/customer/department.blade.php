@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">ตำแหน่ง</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        ตำแหน่ง
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
                        <button type="button" class="btn btn-primary" onclick="addDepartment()">
                            เพิ่มตำแหน่ง
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>ตำแหน่ง</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($departments as $department)
                                    <tr>
                                        <td width="15%">{{ $i++ }}</td>
                                        <td>{{ $department->department_name }}</td>
                                        <td width="7%">
                                            <div class="btn-group">
                                                <button class="btn btn-warning"
                                                    onclick="editDepartment({{ $department->id }})"><i
                                                        class="mdi mdi-pencil"></i></button>
                                                <form action="{{ route('department.destroy', $department->id) }}"
                                                    id="form_delete" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeDepartment({{ $department->id }},'{{ $department->department_name }}')"><i
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
    @include('components.modalDepartment')
    <script>
        function saveDepartment() {
            if ($('#department_name').val().length === 0) {
                $('#show_error').removeClass('d-none')
                if ($('#department_name_edit').val().length === 0) {
                    $('#show_error_edit').removeClass('d-none')
                }else{
                    $('#department-update').submit()
                }
            } else {
                $('#department-create').submit()
            }
        }

        function editDepartment(id) {
            $('#text-status').text('แก้ไขตำแหน่ง')
            $('#department-create').removeClass('d-block')
            $('#department-create').addClass('d-none')
            $('#department-update').removeClass('d-none')
            $('#department-update').addClass('d-block')

            $.ajax({
                url: '/department/' + id,
                type: 'get',
                success: function(response) {
                    $('#department-update').attr('action',
                        `{{ route('department.update', ['department' => ':department_id']) }}`.replace(
                            ':department_id', response.id));
                    $('#department_name_edit').val(response.department_name)
                    $('#modaldepartment').modal('show')
                },
                error: function(xhr) {
                    console.log(xhr.status);
                }
            })
        }

        function addDepartment(categoryId = null) {
            $('#text-status').text('เพิ่มตำแหน่งใหม่')
            $('#department-create').removeClass('d-none')
            $('#department-create').addClass('d-block')
            $('#department-update').removeClass('d-block')
            $('#department-update').addClass('d-none')
            $('#modaldepartment').modal('show')
            $('#show_error').addClass('d-none')
        }

        function removeDepartment(id, department) {
            $('#form_delete').attr('action', `{{ route('department.destroy', ['department' => ':department_id']) }}`
                .replace(
                    ':department_id', id))

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: `คุณต้องการลบ ${department}`,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form_delete').submit()
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
