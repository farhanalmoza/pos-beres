$(document).ready(function() {
	getSalesReport();
});

function getSalesReport() {
	const urlListSalesReport = URL_Role + "/report/sale/get-all"
	const columns = [
		{data : 'product_name', name: 'product_name'},
		{data : 'product_code', name: 'product_code'},
		{data : 'product_category', name: 'product_category'},
		{data : 'sold_quantity', name: 'sold_quantity'},
		{data : 'revenue', name: 'revenue',
			render: function (data, type, row) {
				return Functions.prototype.formatRupiah(data);
			}
		},
		{data : 'remaining_stock', name: 'remaining_stock'},
	]
	Functions.prototype.tableResult("#salesReportTable", urlListSalesReport, columns)
}