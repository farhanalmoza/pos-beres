$(document).ready(function() {
  getCashier();
  addCashier();
  getDetail();
  updateCashier();
  deleteCashier();
});

// jika user role diubah ke warehouse, sembunyikan select store
$('#update_role').on('change', function() {
  if ($(this).val() == 'warehouse') {
    $('#select-store').addClass('hide');
  } else {
    $('#select-store').removeClass('hide');
  }
});

function getCashier() {
  const urlListCashier = URL + "/admin/cashier/get-cashier"
  const columns = [
    {data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
    {data : 'name', name: 'name'},
    {data : 'store.name', name: 'store.name'},
    {data : 'email', name: 'email'},
    {data : 'no_telp', name: 'no_telp'},
    {data : 'actions', name: 'actions', orderable: false, searchable: false},
  ]
  Functions.prototype.tableResult("#cashier-table", urlListCashier, columns)
}

function addCashier() {
  $('#addCashierForm').validate({
    rules: {
      name: {
        required: true
      },
      store_id: {
        required: true
      },
      email: {
        required: true
      },
      no_telp: {
        required: true
      }
    },
    // custom message
    messages: {
      name: {
        required: 'Nama wajib diisi'
      },
      store_id: {
        required: 'Pilih Toko'
      },
      email: {
        required: 'Email wajib diisi'
      },
      no_telp: {
        required: 'No Telp wajib diisi'
      }
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "small",
    submitHandler: function(form, e) {
      e.preventDefault()
      const data = {
        name : $('#name').val(),
        store_id : $('#store_id').val(),
        email : $('#email').val(),
        role : $('#role').val(),
        no_telp : $('#no_telp').val()
      }
      Functions.prototype.httpRequest(URL + '/admin/user', data, 'post')
      // hide modal
      $('#addCashierModal').modal('hide')
      if ($.fn.DataTable.isDataTable('#warehouse-table')) {
        $('#warehouse-table').DataTable().destroy();
      }
      getCashier()
    }
  })
}

function getDetail() {
  $('#cashier-table').on('click', '.update', function(e) {
    e.preventDefault()
    const id = $(this).data('id')
    getDetail.loadData = id
  })
  const getDetail = {
    set loadData(data) {
      const urlDetail = URL + "/admin/user/show/" + data
      Functions.prototype.requestDetail(getDetail, urlDetail)
    },
    set successData(response) {
      $('#userId').val(response.data.id)
      $('#update_name').val(response.data.name);
      $('#update_email').val(response.data.email);
      $('#update_role').val(response.data.role);
    },
    set errorData(err) {
      $('.bs-toast').removeClass('bg-success')
      $('.bs-toast').addClass('bg-danger show')
      $('.toast-status').text('Gagal')
      $('.toast-body').text(err.responseJSON.message)
    }
  }
}

function updateCashier() {  
  $('#updateCashierForm').validate({
    rules: {
      update_role: {
        required: true
      }
    },
    // custom message
    messages: {
      update_role: {
        required: 'Role wajib diisi'
      }
    },
    errorClass: "is-invalid",
    validClass: "is-valid",
    errorElement: "small",
    submitHandler: function(form, e) {
      e.preventDefault()
      const id = $('#userId').val()
      const urlUpdate = URL + "/admin/user/update/" + id
      const data = {
        role : $('#update_role').val(),
        store_id : $('#store_id').val() ? $('#store_id').val() : null
      }
      Functions.prototype.httpRequest(urlUpdate, data, 'put')
      // hide modal
      $('#editModal').modal('hide')
      $('#updateCashierForm').trigger('reset')
      // Hancurkan DataTables jika sudah diinisialisasi
      if ($.fn.DataTable.isDataTable('#cashier-table')) {
        $('#cashier-table').DataTable().destroy();
      }
      getCashier()
    }
  })
}

function deleteCashier() {
  $('#cashier-table').on('click', '.delete', function(e) {
    e.preventDefault()
    const id = $(this).data('id');
    const urlDelete = URL + '/admin/user/delete/' + id;
    
    // Tangani klik tombol konfirmasi hapus di modal
    $('#confirmDeleteBtn').on('click', function(e) {
      e.preventDefault()
      Functions.prototype.deleteData(urlDelete)
      $('#deleteModal').modal('hide')
      if ($.fn.DataTable.isDataTable('#cashier-table')) {
        $('#cashier-table').DataTable().destroy();
      }
      getCashier()
    })
  })
}