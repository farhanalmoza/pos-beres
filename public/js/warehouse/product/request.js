$(document).ready(function() {
  getProductRequest();
	prosesProductRequest();
})

function getProductRequest() {
	const urlListProductRequest = URL_Role + "/product/request/get-all"
	const columns = [
		{data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
		{data : 'store.name', name: 'store.name'},
		{data : 'product.name', name: 'product.name'},
		{data : 'quantity', name: 'quantity'},
		{data : 'date', name: 'date',	},
		{data : 'status', name: 'status', searchable : false,
			render: function (data, type, row) {
				if (data == 'pending') {
					return '<span class="badge bg-warning">diproses</span>';
				} else if (data == 'approved') {
					return '<span class="badge bg-success">selesai</span>';
				} else if (data == 'rejected') {
					return '<span class="badge bg-danger">ditolak</span>';
				}
			}
		 },
		 {data : 'actions', name: 'actions', orderable : false, searchable : false },
	]
	Functions.prototype.tableResult("#product-request-table", urlListProductRequest, columns)
}

$('#product-request-table').on('click', '.process-request-modal-btn', function(e) {
	e.preventDefault()
	const id = $(this).data('id')
	getDetail.loadData = id
})
const getDetail = {
	set loadData(data) {
		const urlDetail = URL_Role + "/product/request/get-request-product/" + data
		Functions.prototype.requestDetail(getDetail, urlDetail)
	},
	set successData(response) {		
		$('#request_product_id').val(response.id)
		$('#store_id').val(response.store_id)
		$('#product_id').val(response.product_id)
		$('#quantity').val(response.quantity)
	},
	set errorData(err) {
		$('.bs-toast').addClass('bg-danger show')
		$('.toast-status').text('Gagal')
		$('.toast-body').text(err.responseJSON.message)
	}
}

function prosesProductRequest() {
	$('#processRequestProductForm').validate({
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
				required: 'Toko wajib diisi'
			},
			product_id: {
				required: 'Barang wajib diisi'
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
				id: $('#request_product_id').val(),
				store_id : $('#store_id').val(),
				product_id : $('#product_id').val(),
				quantity : $('#quantity').val()
			}
			Functions.prototype.httpRequest(URL_Role + '/product/request/process', data, 'post')
			// hide modal
			$('#processRequestModal').modal('hide')
			if ($.fn.DataTable.isDataTable('#product-request-table')) {
				$('#product-request-table').DataTable().destroy();
			}
			getProductRequest()
		}
	})
}