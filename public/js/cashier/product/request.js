$(document).ready(function() {
  getProductRequest();
	addRequestProduct();
})

function getProductRequest() {
	const urlListProductRequest = URL_Role + "/product/request/get-all"
	const columns = [
		{data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
		{data : 'product.code', name: 'product.code'},
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
	]
	Functions.prototype.tableResult("#product-request-table", urlListProductRequest, columns)
}

function addRequestProduct() {
	$('#addRequestProductForm').validate({
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
				required: 'Pilih Barang'
			},
			quantity: {
				required: 'Masukan Jumlah'
			}
		},
		errorClass: "is-invalid",
		validClass: "is-valid",
		errorElement: "small",
		submitHandler: function(form, e) {
			e.preventDefault()
			const data = {
				product_id : $('#product_id').val(),
				quantity : $('#quantity').val()
			}
			Functions.prototype.httpRequest(URL_Role + '/product/request', data, 'post')
			// hide modal
			$('#requestStockModal').modal('hide')
			if ($.fn.DataTable.isDataTable('#product-request-table')) {
				$('#product-request-table').DataTable().destroy();
			}
			getProductRequest()
		}
	})
}