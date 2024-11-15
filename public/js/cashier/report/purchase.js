$(document).ready(function() {
	getPurchaseReport();
});

function getPurchaseReport() {
	const urlListPurchaseReport = URL_Role + "/report/purchase/get-all" + "?date=aaa"

    // ajax get data from urlListPurchaseReport
    $.ajax({
        url: urlListPurchaseReport,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
        }
    });

	// const columns = [
	// 	{data : 'product.name', name: 'product.name'},
	// 	{data : 'quantity', name: 'quantity'},
	// 	{data : 'date', name: 'date', orderable: false, searchable: false},
	// ]
	// Functions.prototype.tableResult("#purchaseReportTable", urlListPurchaseReport, columns)
}