

function addCategory(){
    console.log('sadf');
}
    let categoryId = 0;

    function createCategory() {
        $('#saveCategory').addClass('d-none')
        $('#updateCategory').removeClass('d-none')
    }

    console.log('sadf');
    

    function showEditModal(id, categoryName) {
        categoryId = id;
        $('#saveCategory').addClass('d-none')
        $('#updateCategory').removeClass('d-none')
        $('#category_name').val(categoryName);
        $('#modalcategory').modal('show');
    }

    function updateCategory() {
        console.log('hello');
        // const newCategoryName = $('#editCategoryName').val();

        // $.ajax({
        //     type: 'PUT',
        //     url: `/categorys/${categoryId}`,
        //     data: {
        //         category_name: newCategoryName,
        //     },
        //     success: function(response) {
        //         $('#categoryModal').modal('hide');
        //         $(`#categoryName-${categoryId}`).text(response.category_name);
        //     },
        //     error: function(error) {
        //         console.error(error);
        //     }
        // });
    }

    function saveChanges() {
        const newCategoryName = $('#category_name').val();

        $.ajax({
            type: 'PUT',
            url: `categorys/${categoryId}`,
            data: {
                category_name: newCategoryName,
            },
            success: function(response) {
                $('#editModal').modal('hide');
                $(`#categoryName-${categoryId}`).text(response.category_name);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })


    function confirmRemove(categoryId) {
        Swal.fire({
            title: 'คุณต้องการลบข้อมูลนี้?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm-' + categoryId);
                form.submit();
            } else {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("ยกเลิกการลบข้อมูล");
            }
        });
    }