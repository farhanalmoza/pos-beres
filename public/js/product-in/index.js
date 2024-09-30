$(document).ready(function() {
  getProductIn();
  addProductIn();
});

function getProductIn() {
    const urlListProductIn = URL + "/admin/product-in/get-all"
    const columns = [
        {data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
        {data : 'product.name', name: 'product.name'},
        {data : 'purchase_price', name: 'purchase_price'},
        {data : 'quantity', name: 'quantity'},
        {data : 'total', name: 'total'},
        {data : 'date_in', name: 'date_in'},
    ]
    Functions.prototype.tableResult("#product-in-table", urlListProductIn, columns)
}

function getProduct() {
    $('#product_id').select2({
        theme:'bootstrap4',
        ajax: {
          url: URL + '/admin/product/get-all',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization' : "Bearer " + sessionStorage.getItem('token')
          },
          data: function (params) {
            return {
              search_product: params.term,
            }
          },
          processResults: function(data, params) {
            return {
              results: data.data.map(result => {
                return {
                  text: result.name,
                  id: result.id
                }
              })
            }
          },
        }
    })
}

function addProductIn() {  
    $('#addProductInForm').validate({
        rules: {
            product: {
                required: true
            },
            purchase_price: {
                required: true
            },
            quantity: {
                required: true
            }
        },
        // custom message
        messages: {
            product: {
                required: 'Pilih Barang'
            },
            purchase_price: {
                required: 'Harga Beli wajib diisi'
            },
            quantity: {
                required: 'Jumlah wajib diisi'
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const data = {
                product_id : $('#product_id').val(),
                purchase_price : $('#purchase_price').val(),
                quantity : $('#quantity').val()
            }
            Functions.prototype.httpRequest(URL + '/admin/product-in', data, 'post')
            // hide modal
            $('#addProductModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#product-in-table')) {
                $('#product-in-table').DataTable().destroy();
            }
            getProductIn()
        }
    })
}