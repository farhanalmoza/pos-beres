$(document).ready(function() {
  getProductOut();
  addProductOut();
});

function getProductOut() {
    const urlListProductOut = URL + "/admin/product-out/get-all"
    const columns = [
        {data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
        {data : 'product.name', name: 'product.name'},
        {data : 'store.name', name: 'store.name'},
        {data : 'quantity', name: 'quantity'},
        {data : 'date_out', name: 'date_out'},
    ]
    Functions.prototype.tableResult("#product-out-table", urlListProductOut, columns)
}

function addProductOut() {  
  $('#addProductOutForm').validate({
    rules: {
      store_id: {
        required: true
      },
      product_id: {
        required: true
      },
      quantity: {
        required: true
      }
    },
    // custom message
    messages: {
      store_id: {
        required: 'Pilih Toko'
      },
      product_id: {
        required: 'Pilih Barang'
      },
      quantity: {
        required: 'Jumlah harus diisi'
      }
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "small",
    submitHandler: function(form, e) {
      e.preventDefault()
      const data = {
        store_id : $('#store_id').val(),
        product_id : $('#product_id').val(),
        quantity : $('#quantity').val()
      }
      Functions.prototype.httpRequest(URL + '/admin/product-out', data, 'post')
      // hide modal
      $('#addProductOutModal').modal('hide')
      // reset form
      $('#addProductOutForm')[0].reset();
      if ($.fn.DataTable.isDataTable('#product-out-table')) {
        $('#product-out-table').DataTable().destroy();
      }
      getProductOut()
    }
  });
}