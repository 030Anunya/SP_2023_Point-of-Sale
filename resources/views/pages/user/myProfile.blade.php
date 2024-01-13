@extends('layouts')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center alert alert-dark">ข้อมูลส่วนตัว</h5>
            <br>
            <form action="{{ route('myprofile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-4">
                        <img class="rounded-circle" id="blah"
                            width="100%"
                            height="250px"
                            style="object-fit: cover;"
                            src="{{ $user->img === null ? 'storage/uploads/avatar.webp' : 'storage/uploads/' . $user->img }}" alt="">

                        <input accept="image/*" type="file" name="image" id="imgInp" class="form-control mt-4">
                    </div>
                    <div class="col-8">

                    
                        <p class="card-text"><strong>ชื่อ : </strong><input name="first_name" type="text"
                                class="form-control" value="{{ $user->first_name }}" required></p>
                        <p class="card-text"><strong>นามสกุล : </strong><input name="last_name" type="text"
                                class="form-control" value="{{ $user->last_name }}" required></p>
                        <p class="card-text"><strong>เบอร์โทร : </strong><input name="phone" type="text" maxlength="10" placeholder="เบอร์โทร"
                                class="form-control" value="{{ $user->phone }}" required></p>
                        <hr>
                        <p class="card-text"><strong>เงินเดือน : </strong>{{ number_format($user->salary, 2) }} บาท</p>
                        <p class="card-text"><strong>ตำแหน่ง : </strong>{{ !empty($user->department) ? $user->department->department_name : "Admin" }}</p>
                        <p class="card-text"><strong>อีเมลล์ผู้ใช้ : </strong>{{ $user->email }}</p>
                        <p class="card-text"><strong>เข้าใช้งานเมื่อ : </strong>{{ date('d/m/Y H:i', strtotime($user->created_at)) }} น.</p>
                        <button type="submit" class="btn btn-outline-primary">บันทึก</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
