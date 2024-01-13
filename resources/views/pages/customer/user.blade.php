@extends('layouts')
@section('bread')
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">รายชื่อผู้ใช้งาน</h4>
        <div class="ms-auto text-end">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        รายชื่อผู้ใช้งาน
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
                        <button type="button" class="btn btn-primary" onclick="openModalUser()">
                            เพิ่มพนักงาน
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รูปภาพ</th>
                                    <th>ชื่อ</th>
                                    <th>อีเมลล์</th>
                                    <th>ตำแหน่ง</th>
                                    <th>เงินเดือน</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <img style="max-width: 110px;max-height:80px;"
                                                src="{{ asset($user->img === null ? 'storage/uploads/avatar.webp' : 'storage/uploads/' . $user->img) }}"
                                                alt="">
                                        </td>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->departments !== null ? $user->departments->department_name : 'ผู้ดูแลระบบ' }}
                                        </td>
                                        <td>{{ number_format($user->salary, 2) }}</td>
                                        <td>
                                            @php
                                                if ($user->status == 1) {
                                                    echo '<span class="badge bg-success">ใช้งาน</span>';
                                                } else {
                                                    echo '<span class="badge bg-danger">ปิดใช้งาน</span>';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            {{-- <div> --}}
                                            <div class="btn-group">
                                                <form action="{{ url('/users/status', $user->id) }}" method="post"
                                                    class="form_user_update_status">
                                                    @csrf
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="toggleStatus({{ $user->id }},'{{ $user->first_name }}')">
                                                        <i class="fa-solid fa-toggle-on"></i>
                                                    </button>
                                                </form>
                                                <button class="btn btn-warning" onclick="editUser({{ $user->id }})"><i
                                                        class="mdi mdi-pencil"></i></button>
                                                <form action="" class="form_user_delete" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="removeUser({{ $user->id }},'{{ $user->first_name }}')"
                                                        class="btn btn-danger"><i class="mdi mdi-delete"></i></button>
                                                </form>
                                            </div>
                                            {{-- </div> --}}
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
    @include('components.modalUser')
    <script>
        $('#UserForm_update').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'users',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#btn-add-user').attr('disabled', '')
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal
                                .stopTimer);
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer);
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: "บันทึกสินผู้ใช้งานสำเร็จ"
                    });

                    setTimeout(() => {
                        location.reload()
                    }, 1000);

                },
                error: function(xhr) {

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;

                        $(".error-message").remove();

                        $.each(errors, function(field, errorMessages) {
                            var errorHtml =
                                '<div class="error-message text-danger">' +
                                errorMessages.join(', ') + '</div>';
                            $("#" + field).closest(".col-sm-9").append(errorHtml);
                        });
                    } else {
                        console.error("Form submission failed");
                    }
                }
            });
        })
        $("#UserForm").submit(function(event) {
            event.preventDefault();


            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#btn-add-user').attr('disabled', '')
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal
                                .stopTimer);
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer);
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: "บันทึกผู้ใช้งานสำเร็จ"
                    });

                    setTimeout(() => {
                        location.reload()
                    }, 1000);

                },
                error: function(xhr) {

                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;

                        $(".error-message").remove();

                        $.each(errors, function(field, errorMessages) {
                            var errorHtml =
                                '<div class="error-message text-danger">' +
                                errorMessages.join(', ') + '</div>';
                            $("#" + field).closest(".col-sm-9").append(errorHtml);
                        });
                    } else {
                        console.error("Form submission failed");
                    }
                }
            });
        })

        function openModalUser() {
            $(".error-message").remove();
            $('#textShowStatus').text('เพิ่มผู้ใช้งานใหม่')
            $('#id_user').attr('disabled', '')
            $('#UserForm')[0].reset();
            $('#modalUser').modal('show')
        }

        function editUser(id) {
            $('#textShowStatus').text('แก้ไขผู้ใช้งาน')
            $('#id_user').removeAttr('disabled', '')
            $(".error-message").remove();

            $.ajax({
                url: '/users/' + id + '/edit',
                type: 'get',
                success: function(response) {
                    $('#UserForm_update').attr('action', `{{ route('users.update', ['user' => ':user_id']) }}`
                        .replace(
                            ':user_id', id))
                    $('#first_name').val(response.first_name)
                    $('#last_name').val(response.last_name)
                    $('#department').val(response.department_id)
                    $('#salary').val(response.salary)
                    $('#email').val(response.email)
                    $('#phone').val(response.phone)
                    $('#id_user').val(response.id)

                    $('#modalUser').modal('show')
                },
                error: function(xhr) {
                    console.log(xhr.status);
                }
            })
        }

        function removeUser(id, user) {
            $('.form_user_delete').attr('action', `{{ route('users.destroy', ['user' => ':user_id']) }}`
                .replace(
                    ':user_id', id))

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: `คุณต้องการลบ ${user}`,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.form_user_delete').submit()
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

        function toggleStatus(id, user) {
            $('.form_user_update_status').attr('action', `{{ url('/users/status/${id}') }}`)
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: `เปลี่ยนสถานะการใช้งาน ${user}`,
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('.form_user_update_status').submit()
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
