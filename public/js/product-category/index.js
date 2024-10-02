$(document).ready(function() {
    updateData();
    getCategories();
    showDetail();
    deleteCategory();
});

function getCategories() {  
    const urlListCategories = URL_Role + "/product-category/get-all"    
    const columns = [
        {data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
        {data : 'name', name: 'name'},
        {data : 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#categoryTable", urlListCategories, columns)
}

function showDetail() {  
    $('#categoryTable').on('click', '.update', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        getDetail.loadData = id
    })
    const getDetail = {
        set loadData(data) {
            const urlDetail = URL_Role + "/product-category/show/" + data
            Functions.prototype.requestDetail(getDetail, urlDetail)
        },
        set successData(response) {
            $('#update_name').val(response.data.name);
            $('#id_category').val(response.data.id)
        },
        set errorData(err) {
            $('.bs-toast').addClass('bg-danger show')
            $('.toast-status').text('Gagal')
            $('.toast-body').text(err.responseJSON.message)
        }
    }
}

function updateData() {  
    $('#updateCategoryForm').validate({
        rules: {
            update_name: {
                required: true
            }
        },
        // custom message
        messages: {
            update_name: {
                required: 'Kategori barang wajib diisi'
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const id = $('#id_category').val()
            const urlUpdate = URL_Role + "/product-category/update/" + id
            const data = {
                name : $('#update_name').val()
            }
            Functions.prototype.httpRequest(urlUpdate, data, 'put')
            // hide modal
            $('#editModal').modal('hide')
            $('#updateCategoryForm').trigger('reset')
            // Hancurkan DataTables jika sudah diinisialisasi
            if ($.fn.DataTable.isDataTable('#categoryTable')) {
                $('#categoryTable').DataTable().destroy();
            }
            getCategories()
        }
    })
}

function deleteCategory() {
    $('#categoryTable').on('click', '.delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        const urlDelete = URL_Role + '/product-category/delete/' + id;
        
        // Tangani klik tombol konfirmasi hapus di modal
        $('#confirmDeleteBtn').on('click', function(e) {
            e.preventDefault()
            Functions.prototype.deleteData(urlDelete)
            $('#deleteModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#categoryTable')) {
                $('#categoryTable').DataTable().destroy();
            }
            getCategories()
        })
    })
}