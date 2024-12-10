$(document).ready(function() {
  getProductOut();
  addProductOut();
  toggelPPN();
});

function getProductOut() {
    const urlListProductOut = URL_Role + "/product-out/get-all"
    const columns = [
        {data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
        {data : 'product.name', name: 'product.name'},
        {data : 'store.name', name: 'store.name'},
        {data : 'quantity', name: 'quantity'},
        {data : 'total', name: 'total',
          render: function (data, type, row) {
            return Functions.prototype.formatRupiah(data);
          }
        },
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
        quantity : $('#quantity').val(),
        total_price: subtotal,
        ppn: plusPPN
      }
      Functions.prototype.httpRequest(URL_Role + '/product-out', data, 'post')
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

var qty_product = $('#quantity').val();
var product_id = $('#product_id').val();
var isPPN = false;
var product_price = 0;
var subtotal = 0;
var plusPPN = 0;
var total = 0;

$('#quantity').on('keyup', function() {
  qty_product = $('#quantity').val();
  product_id = $('#product_id').val();
  calculatePayment(product_id, qty_product, isPPN);
});

function toggelPPN() {
  $('#ppnCheck').on('change', function() {
    if ($(this).is(':checked')) {
      isPPN = true;
      plusPPN = subtotal * PPN / 100;
    } else {
      isPPN = false;
      plusPPN = 0;
    }

    calculatePayment(product_id, qty_product, isPPN);
  })
}

function calculatePayment(product_id, qty, isPPN) {
  const urlWarehouseProductPrice = URL_Role + "/product/warehouse-price/" + product_id
  $.ajax({
    type: "get",
    url: urlWarehouseProductPrice,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'Authorization' : "Bearer " + sessionStorage.getItem('token')
    },
    success: function (response) {
      product_price = response.data;
      if (qty > 0) {
        subtotal = product_price * qty;
        if (isPPN) {
          plusPPN = subtotal * PPN / 100;
          total = subtotal + plusPPN;
        } else {
          plusPPN = 0;
          total = subtotal;
        }
      } else {
        subtotal = 0;
        plusPPN = 0;
        total = 0;
      }

      $('#subtotal').text(subtotal);
      $('#ppn').text(plusPPN);
      $('#total').text(total);
    },
    error: function(err) {
      $('.bs-toast').removeClass('bg-success')
      $('.bs-toast').addClass('bg-danger show')
      $('.toast-status').text('Gagal')
      $('.toast-body').text(err.responseJSON.message)
    }
  })
}