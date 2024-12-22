$(document).ready(function() {
  getCarts.loadData = requestNumber;
  addProductToCart();
  deleteCart();
  addProductRequest();
});

const getCarts = {
  set loadData(data) {
    const url = URL_Role + "/product-request/cart/get-carts/" + data
    Functions.prototype.requestDetail(getCarts, url)
  },
  set successData(response) {
    $('#productRequestList').empty()
    if (response.length > 0) {
      var x = 1;
      $('#addProductRequestModalBtn').prop('disabled', false);
      response.map((result, i) => {
        const title = result.product.name.length > 40 ? result.product.name.substring(0, 40) + '...' : result.product.name

        $('#productRequestList').append(`
          <tr>
            <td class="text-center">${x++}</td>
            <td>${result.product.code}</td>
            <td>${title}</td>
            <td class="text-end" style="width: 5%">${result.quantity}</td>
            <td>
              <button class="btn btn-danger btn-xs delete" data-id="${result.id}" data-bs-toggle="modal" data-bs-target="#deleteCartModal"><i class='bx bx-x'></i></button>
            </td>
          </tr>
        `)
      })
    } else {
      $('#productRequestList').html(`
        <tr>
          <td colspan="5" align="center">Data masih kosong</td>
        </tr>
      `)
      $('#addProductRequestModalBtn').prop('disabled', true);
    }
  },
  set errorData(err) {
    $('.bs-toast').removeClass('bg-success')
		$('.bs-toast').addClass('bg-danger show')
		$('.toast-status').text('Gagal')
		$('.toast-body').text(err.responseJSON.message)
  }
}

function addProductToCart() {  
  $('#addProductForm').validate({
    rules: {
      product_id: {
        required: true
      },
      quantity: {
        required: true
      }
    },
    // custom message
    messages: {
      product_id: {
        required: 'Silakan pilih barang'
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
        request_number : requestNumber,
        product_id : $('#product_id').val(),
        quantity : $('#quantity').val(),
      }
      postDataCart.loadData = data
    }
  })
}

const postDataCart = {
  set loadData(data) {
    const url = URL_Role + "/product-request/cart/add"
    Functions.prototype.postRequest(postDataCart, url, data)
  },
  set successData(response) {
		$('.load-wrapper').addClass('hide-loader')
		$('.bs-toast').removeClass('bg-danger')
		$('.bs-toast').addClass('bg-success show')
		$('.toast-status').text('Berhasil')
		$('.toast-body').text(response.message)

    // reset input product_code
    $('#product_id').val('')
    $('#quantity').val('')

    getCarts.loadData = requestNumber

    setTimeout(function() {
      $('.bs-toast').removeClass('show')
    }, 5000);
  },
  set errorData(err) {
    $('.bs-toast').removeClass('bg-success')
		$('.bs-toast').addClass('bg-danger show')
		$('.toast-status').text('Gagal')
		$('.toast-body').text(err.responseJSON.message)
    $('#product_code').val('')
    setTimeout(function() {
      $('.bs-toast').removeClass('show')
    }, 5000);
  }
}

function deleteCart() {
  $('#productRequestList').on('click', '.delete', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    
    $('#confirmDeleteCartBtn').on('click', function(e) {      
      e.preventDefault()
      const url = URL_Role + "/product-request/cart/delete/" + id
      Functions.prototype.deleteData(url)
      $('#deleteCartModal').modal('hide')
      getCarts.loadData = requestNumber
    })
  })
}

function addProductRequest() {
  $('#addProductRequestBtn').on('click', function(e) {
    e.preventDefault()
    const url = URL_Role + "/product-request/store"
    const data = {
      request_number : requestNumber,
    }
    Functions.prototype.httpRequest(url, data, 'post');
    setTimeout(() => {
      window.location.reload()
    }, 500);
  })
}