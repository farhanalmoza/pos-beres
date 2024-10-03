$(document).ready(function() {
    getProducts();
    addProduct();
    showDetailForPrint();
    showDetailForEdit();
    updateProduct();
    deleteProduct();
});

function getProducts() {  
    const urlListProducts = URL_Role + "/product/get-all"    
    const columns = [
        {data : 'code', name: 'code'},
        {data : 'name', name: 'name'},
        {data : 'quantity', name: 'quantity'},
        {data : 'price', name: 'price',
            render: function (data, type, row) {
                return Functions.prototype.formatRupiah(data);
            }
        },
        {data : 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#productTable", urlListProducts, columns)
}

function addProduct() {  
    $('#addProductForm').validate({
        rules: {
            product_code: {
                required: true
            },
            product_name: {
                required: true
            },
            product_category_id: {
                required: true
            },
            product_quantity: {
                required: true
            },
            product_price: {
                required: true
            }
        },
        // custom message
        messages: {
            product_code: {
                required: 'Kode barang wajib diisi'
            },
            product_name: {
                required: 'Nama barang wajib diisi'
            },
            product_category_id: {
                required: 'Kategori barang wajib diisi'
            },
            product_quantity: {
                required: 'Stok barang wajib diisi'
            },
            product_price: {
                required: 'Harga barang wajib diisi'
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const data = {
                code : $('#product_code').val(),
                name : $('#product_name').val(),
                category_id : $('#product_category_id').val(),
                quantity : $('#product_quantity').val(),
                price : $('#product_price').val()
            }
            Functions.prototype.httpRequest(URL_Role + '/product', data, 'post')
            // hide modal
            $('#addProductModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#productTable')) {
                $('#productTable').DataTable().destroy();
            }
            getProducts()
        }
    })
}

function showDetailForPrint() {  
    $('#productTable').on('click', '.detail', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        getDetail.loadData = id
    })
    const getDetail = {
        set loadData(data) {
            const urlDetail = URL_Role + "/product/show/" + data
            Functions.prototype.requestDetail(getDetail, urlDetail)
        },
        set successData(response) {
            $('#product_code').val(response.data.code);
            $('#product_name').val(response.data.name);
            $('#product_category').val(response.data.category_id);
            $('#product_price').val(response.data.price);
            $('#product_stock').val(response.data.quantity);
        },
        set errorData(err) {
            $('.bs-toast').addClass('bg-danger show')
            $('.toast-status').text('Gagal')
            $('.toast-body').text(err.responseJSON.message)
        }
    }
}

function showDetailForEdit() {  
    $('#productTable').on('click', '.update', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        getDetail.loadData = id
    })
    const getDetail = {
        set loadData(data) {
            const urlDetail = URL_Role + "/product/show/" + data
            Functions.prototype.requestDetail(getDetail, urlDetail)
        },
        set successData(response) {
            $('#id_product').val(response.data.id)
            $('#update_code').val(response.data.code);
            $('#update_name').val(response.data.name);
            $('#update_category_id').val(response.data.category_id);
            $('#update_price').val(response.data.price);
        },
        set errorData(err) {
            $('.bs-toast').addClass('bg-danger show')
            $('.toast-status').text('Gagal')
            $('.toast-body').text(err.responseJSON.message)
        }
    }
}

function updateProduct() {  
    $('#updateProductForm').validate({
        rules: {
            update_code: {
                required: true
            },
            update_name: {
                required: true
            },
            update_category_id: {
                required: true
            },
            update_price: {
                required: true
            }
        },
        // custom message
        messages: {
            update_code: {
                required: 'Kode barang wajib diisi'
            },
            update_name: {
                required: 'Nama barang wajib diisi'
            },
            update_category_id: {
                required: 'Kategori barang wajib diisi'
            },
            update_price: {
                required: 'Harga barang wajib diisi'
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const id = $('#id_product').val()
            const urlUpdate = URL_Role + "/product/update/" + id
            const data = {
                code : $('#update_code').val(),
                name : $('#update_name').val(),
                category_id : $('#update_category_id').val(),
                price : $('#update_price').val()
            }
            Functions.prototype.httpRequest(urlUpdate, data, 'put')
            // hide modal
            $('#editModal').modal('hide')
            $('#updateProductForm').trigger('reset')
            // Hancurkan DataTables jika sudah diinisialisasi
            if ($.fn.DataTable.isDataTable('#productTable')) {
                $('#productTable').DataTable().destroy();
            }
            getProducts()
        }
    })
}

function deleteProduct() {
    $('#productTable').on('click', '.delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        const urlDelete = URL_Role + '/product/delete/' + id;
        
        // Tangani klik tombol konfirmasi hapus di modal
        $('#confirmDeleteBtn').on('click', function(e) {
            e.preventDefault()
            Functions.prototype.deleteData(urlDelete)
            $('#deleteModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#productTable')) {
                $('#productTable').DataTable().destroy();
            }
            getProducts()
        })
    })
}