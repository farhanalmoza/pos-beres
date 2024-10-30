$(document).ready(function() {
    getSuppliers();
    addSupplier();
    showSupplier();
    updateSupplier();
    deleteSupplier();
});

function getSuppliers() {
    const urlListSuppliers = URL_Role + "/supplier/get-all"
    const columns = [
        {data : 'name', name: 'name'},
        {data : 'person_responsible', name: 'person_responsible'},
        {data : 'phone', name: 'phone'},
        {data : 'address', name: 'address'},
        {data : 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#supplierTable", urlListSuppliers, columns)
}

function addSupplier() {
    $('#addSupplierForm').validate({
        rules: {
            supplier_name: {
                required: true,
            },
            person_responsible: {
                required: true,
            },
            phone: {
                required: true,
            },
            address: {
                required: true,
            },
        },
        messages: {
            supplier_name: {
                required: "Nama supplier wajib diisi",
            },
            person_responsible: {
                required: "Penanggung jawab wajib diisi",
            },
            phone: {
                required: "No telepon wajib diisi",
            },
            address: {
                required: "Alamat wajib diisi",
            },
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault();
            const data = {
                supplier_name: $('#supplier_name').val(),
                person_responsible: $('#person_responsible').val(),
                phone: $('#phone').val(),
                address: $('#address').val(),
            }
            Functions.prototype.httpRequest(URL_Role + "/supplier/", data, 'post')
            // hide modal
            $('#addSupplierModal').modal('hide');
            if ($.fn.DataTable.isDataTable('#supplierTable')) {
                $('#supplierTable').DataTable().destroy();
            }
            getSuppliers();
        }
    });
}

function showSupplier() {
    $('#supplierTable').on('click', '.update', function(e) {
        e.preventDefault();
        const id = $(this).data('id')
        getDetail.loadData = id
    })

    const getDetail = {
        set loadData(data) {
            const urlDetail = URL_Role + "/supplier/show/" + data
            Functions.prototype.requestDetail(getDetail, urlDetail)
        },
        set successData(response) {
            $('#id_supplier').val(response.data.id)
            $('#update_supplier_name').val(response.data.name)
            $('#update_person_responsible').val(response.data.person_responsible)
            $('#update_phone').val(response.data.phone)
            $('#update_address').val(response.data.address)
        },
        set errorData(err) {
            $('.bs-toast').addClass('bg-danger show')
            $('.toast-status').text('Gagal')
            $('.toast-body').text(err.responseJSON.message)
        }
    }
}

function updateSupplier() {  
    $('#updateSupplierForm').validate({
        rules: {
            update_supplier_name: {
                required: true,
            },
            update_person_responsible: {
                required: true,
            },
            update_phone: {
                required: true,
            },
            update_address: {
                required: true,
            },
        },
        messages: {
            update_supplier_name: {
                required: "Nama supplier wajib diisi",
            },
            update_person_responsible: {
                required: "Penanggung jawab wajib diisi",
            },
            update_phone: {
                required: "No telepon wajib diisi",
            },
            update_address: {
                required: "Alamat wajib diisi",
            },
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const id = $('#id_supplier').val()
            const urlUpdate = URL_Role + "/supplier/update/" + id
            const data = {
                supplier_name: $('#update_supplier_name').val(),
                person_responsible: $('#update_person_responsible').val(),
                phone: $('#update_phone').val(),
                address: $('#update_address').val(),
            }
            Functions.prototype.httpRequest(urlUpdate, data, 'put')
            // hide modal
            $('#editModal').modal('hide')
            $('#updateSupplierForm').trigger('reset')
            // Hancurkan DataTables jika sudah diinisialisasi
            if ($.fn.DataTable.isDataTable('#supplierTable')) {
                $('#supplierTable').DataTable().destroy();
            }
            getSuppliers()
        }
    })
}

function deleteSupplier() {
    $('#supplierTable').on('click', '.delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        const urlDelete = URL_Role + '/supplier/delete/' + id;
        
        // Tangani klik tombol konfirmasi hapus di modal
        $('#confirmDeleteBtn').on('click', function(e) {
            e.preventDefault()
            Functions.prototype.deleteData(urlDelete)
            $('#deleteModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#supplierTable')) {
                $('#supplierTable').DataTable().destroy();
            }
            getSuppliers()
        })
    })
}