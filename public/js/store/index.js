$(document).ready(function() {
    getStores();
    addStore();
    showDetail();
    updateData();
    deleteStore();
});

function getStores() {  
    const urlListStores = URL + "/admin/store/get-all"    
    const columns = [
        {data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
        {data : 'name', name: 'name'},
        {data : 'address', name: 'address'},
        {data : 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#storeTable", urlListStores, columns)
}

function addStore() {  
    $('#addStoreForm').validate({
        rules: {
            store_name: {
                required: true
            },
            store_address: {
                required: true
            }
        },
        // custom message
        messages: {
            store_name: {
                required: 'Nama toko wajib diisi'
            },
            store_address: {
                required: 'Alamat wajib diisi'
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const data = {
                name : $('#store_name').val(),
                address : $('#store_address').val()
            }
            Functions.prototype.httpRequest(URL + '/admin/store', data, 'post')
            // hide modal
            $('#addStoreModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#storeTable')) {
                $('#storeTable').DataTable().destroy();
            }
            getStores()
        }
    })
}

function showDetail() {  
    $('#storeTable').on('click', '.update', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        getDetail.loadData = id
    })
    const getDetail = {
        set loadData(data) {
            const urlDetail = URL + "/admin/store/show/" + data
            Functions.prototype.requestDetail(getDetail, urlDetail)
        },
        set successData(response) {
            $('#update_store_name').val(response.data.name);
            $('#update_store_address').val(response.data.address);
            $('#id_store').val(response.data.id)
        },
        set errorData(err) {
            $('.bs-toast').addClass('bg-danger show')
            $('.toast-status').text('Gagal')
            $('.toast-body').text(err.responseJSON.message)
        }
    }
}

function updateData() {  
    $('#updateStoreForm').validate({
        rules: {
            update_store_name: {
                required: true
            },
            update_store_address: {
                required: true
            }
        },
        // custom message
        messages: {
            update_store_name: {
                required: 'Nama toko wajib diisi'
            },
            update_store_address: {
                required: 'Alamat wajib diisi'
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const id = $('#id_store').val()
            const urlUpdate = URL + "/admin/store/update/" + id
            const data = {
                name : $('#update_store_name').val(),
                address : $('#update_store_address').val()
            }
            Functions.prototype.httpRequest(urlUpdate, data, 'put')
            // hide modal
            $('#editModal').modal('hide')
            $('#updateStoreForm').trigger('reset')
            // Hancurkan DataTables jika sudah diinisialisasi
            if ($.fn.DataTable.isDataTable('#storeTable')) {
                $('#storeTable').DataTable().destroy();
            }
            getStores()
        }
    })
}

function deleteStore() {
    $('#storeTable').on('click', '.delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        const urlDelete = URL + '/admin/store/delete/' + id;
        
        // Tangani klik tombol konfirmasi hapus di modal
        $('#confirmDeleteBtn').on('click', function(e) {
            e.preventDefault()
            Functions.prototype.deleteData(urlDelete)
            $('#deleteModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#storeTable')) {
                $('#storeTable').DataTable().destroy();
            }
            getStores()
        })
    })
}