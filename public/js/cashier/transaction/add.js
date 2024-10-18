// add product to cart
$('#product_code').on('keydown', function(e) {
  if(e.ctrlKey == false) {
    if(e.keyCode == 13) {
      const kode = $('#product_code').val()
      const no_invoice = noInvoice
      const data = {
        kode: kode,
        no_invoice: no_invoice
      }
      addDataCart.loadData = data
    }
  }
});

$(function () {
  getCarts.loadData = noInvoice
  $('#processPaymentBtn').on('click', processPayment)
  $('#cancelOrder').on('click', cancelOrder)
  deleteCart();
})

const addDataCart = {
  set loadData(data) {
    const url = URL_Role + "/transaction/add/cart"
    Functions.prototype.postRequest(addDataCart, url, data)
  },
  set successData(response) {
		$('.load-wrapper').addClass('hide-loader')
		$('.bs-toast').removeClass('bg-danger')
		$('.bs-toast').addClass('bg-success show')
		$('.toast-status').text('Berhasil')
		$('.toast-body').text(response.message)

    // reset input product_code
    $('#product_code').val('')

    getCarts.loadData = noInvoice
  },
  set errorData(err) {
    $('.bs-toast').removeClass('bg-success')
		$('.bs-toast').addClass('bg-danger show')
		$('.toast-status').text('Gagal')
		$('.toast-body').text(err.responseJSON.message)
    $('#product_code').val('')
  }
}

const getCarts = {
  set loadData(data) {
    const url = URL_Role + "/transaction/get/carts/" + data
    Functions.prototype.requestDetail(getCarts, url)
  },
  set successData(response) {
    var subTotal = 0,
        totalDiscount = 0
    $('#listCarts').empty()
    if (response.length > 0) {
      var x = 1;
      response.map((result, i) => {
        totalDiscount = result.product_discount * result.quantity
        var price = result.price,
            totalPrice = (result.price * result.quantity) - totalDiscount
        subTotal += totalPrice
        const total = subTotal
        const title = result.product.name.length > 20 ? result.product.name.substring(0, 20) + '...' : result.product.name

        $('#listCarts').append(`
          <tr>
            <td class="text-center" style="width: 10%">${x++}</td>
            <td>${title}</td>
            <td class="text-center" style="width: 15%">${result.quantity}</td>
            <td class="text-center" style="width: 25%">${Functions.prototype.formatRupiah(price)}</td>
            <td>
              <button class="btn btn-danger btn-xs delete" data-id="${result.id}" data-bs-toggle="modal" data-bs-target="#deleteCartModal"><i class='bx bx-x'></i></button>
            </td>
          </tr>
        `)
      })
    } else {
      $('#listCarts').html(`
        <tr>
          <td colspan="5" align="center">Keranjang masih kosong</td>
        </tr>
      `)
    }

    $('.subTotalBadge').text(Functions.prototype.formatRupiah(subTotal.toString()))
    $('#subTotal').val(subTotal)
    $('#diskonTrxLabel').text(Functions.prototype.formatRupiah(totalDiscount.toString()))
    $('#diskonValue').val(totalDiscount)
    $('.grand_total').text(Functions.prototype.formatRupiah(subTotal.toString()))
    $('#grandTotal').val(subTotal)
  },
  set errorData(err) {
    $('.bs-toast').removeClass('bg-success')
		$('.bs-toast').addClass('bg-danger show')
		$('.toast-status').text('Gagal')
		$('.toast-body').text(err.responseJSON.message)
  }
}

function deleteCart() {
  $('#listCarts').on('click', '.delete', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    
    $('#confirmDeleteCartBtn').on('click', function(e) {      
      e.preventDefault()
      const url = URL_Role + "/transaction/delete/cart/" + id
      Functions.prototype.deleteData(url)
      $('#deleteCartModal').modal('hide')
      getCarts.loadData = noInvoice
    })
  })
}

function processPayment(e) {
  e.preventDefault()
  const idUser = idUserInput
  // const customer = $('#customer').val() === '' ? '0' : $('#customer').val()
  const discount = $('#diskonValue').val()
  const grandTotal = $('#grandTotal').val()
  if (grandTotal < 1) {
    $('.bs-toast').removeClass('bg-success')
    $('.bs-toast').addClass('bg-danger show')
    $('.toast-status').text('Gagal')
    $('.toast-body').text('Isi barang terlebih dulu')
    setTimeout(function() {
      $('.bs-toast').removeClass('show')
    }, 5000)
  } else {
    $('#cashModalLabel').text(`Total belanja ${Functions.prototype.formatRupiah(grandTotal.toString())}`)
    $('#cashModal').modal('show')
    $('#confirmCashBtn').on('click', function(e) {
      e.preventDefault()
      const url = URL_Role + "/transaction/cash"
      const change = $("#cashAmount").val() - grandTotal
      const data = {
        no_invoice: noInvoice,
        store_id: storeId,
        created_by: idUser,
        transaction_discount: discount != "" ? discount : 0,
        total: grandTotal,
        cash: $("#cashAmount").val(),
        change: $("#cashAmount").val() - grandTotal,
        notes: ""
      }
      Functions.prototype.postRequest(addDataCart, url, data)
      $('#cashModal').modal('hide')
      
      // print receipt
      $('#printReceiptModal').modal('show')
      $('#printReceiptLabel').text(`Kembalian. ${Functions.prototype.formatRupiah(change.toString())}`)
      $('#printReceiptBtn').on('click', function(e) {
        e.preventDefault()
        const url = URL_Role + "/transaction/print/receipt/" + noInvoice
        // Functions.prototype.postRequest(addDataCart, url)
        $('#printReceiptModal').modal('hide')
        setTimeout(() => {
          window.location.reload()
        }, 500);
      })
      $('#noPrintReceiptBtn').on('click', function(e) {
        e.preventDefault()
        setTimeout(() => {
          window.location.reload()
        }, 500);
      })
    })
  }
}

function cancelOrder(e) {
  e.preventDefault();
  const grandTotal = $('#grandTotal').val()
  
  if (grandTotal < 1) {
    $('.bs-toast').removeClass('bg-success')
		$('.bs-toast').addClass('bg-danger show')
		$('.toast-status').text('Gagal')
		$('.toast-body').text('Isi barang terlebih dulu')
    setTimeout(function() {
      $('.bs-toast').removeClass('show')
    }, 5000)
  } else {
    $('#cancelTransactionModal').modal('show')

    $('#confirmCancelTransactionBtn').on('click', function(e) {
      e.preventDefault()
      const url = URL_Role + "/transaction/cancel/transaction/" + noInvoice
      Functions.prototype.deleteData(url)
      $('#cancelTransactionModal').modal('hide')
      getCarts.loadData = noInvoice
    })
  }
}