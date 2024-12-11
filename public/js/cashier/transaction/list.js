$(document).ready(function() {
	getListTransaction();
});

function getListTransaction() {
	const urlListTransaction = URL_Role + "/transaction/get-all"
	const columns = [
		{data : 'no_invoice', name: 'no_invoice', orderable : false, searchable : false },
		{data : 'created_by.name', name: 'created_by'},
		{data : 'memberName', name: 'memberName'},
		{data : 'date', name: 'date',	},
		{data : 'total', name: 'total',
			render: function (data, type, row) {
				return Functions.prototype.formatRupiah(data);
			}
		},
		{data : 'actions', name: 'actions', orderable : false, searchable : false },
	]
	Functions.prototype.tableResult("#transactionTable", urlListTransaction, columns)
}