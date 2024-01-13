@extends('layouts')
@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary"onclick="showCategoryModal()">
                Launch static backdrop modal
            </button>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Basic Datatable</h5>
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
                                                    method="POST" id="deleteForm-{{ $category->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
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
                form_update.attr('action', `{{ route('categorys.update', ['category' => ':category_id']) }}`.replace(':category_id', categoryId));
                $('#category_name_edit').val(categoryName);
            }

            modal.modal('show');
        }
    </script>
@endsection
