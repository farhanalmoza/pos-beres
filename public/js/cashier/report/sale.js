$(document).ready(function() {
	getSalesReport();
});

var startDate = null;
var endDate = null;

function getSalesReport(startDate = null, endDate = null) {
	var urlListSalesReport = URL_Role + "/report/sale/get-all"
	if (startDate && endDate) {
		urlListSalesReport += "?start_date=" + startDate + "&end_date=" + endDate
	}

	const columns = [
		{data : 'no_invoice', name: 'no_invoice'},
		{data : 'product_name', name: 'product_name'},
		{data : 'product_quantity', name: 'product_quantity'},
		{data : 'product_price', name: 'product_price',
			render: function (data, type, row) {
				return Functions.prototype.formatRupiah(data);
			}
		},
		{data : 'total', name: 'total',
			render: function (data, type, row) {
				return Functions.prototype.formatRupiah(data);
			}
		},
		{data : 'member', name: 'member'},
		{data : 'date', name: 'date', orderable: false, searchable: false},
	]
	Functions.prototype.tableResult("#salesReportTable", urlListSalesReport, columns)
}

function checkToggleDisabled() {
	const start_date = $("#start_date").val()
	const end_date = $("#end_date").val()

	if (start_date && end_date) {
		$("#filterDateBtn").removeAttr("disabled")
	} else {
		$("#filterDateBtn").attr("disabled", "disabled")
	}
}

function submitFilterDate() {
	const start_date = $("#start_date").val()
	const end_date = $("#end_date").val()

	// check end date is bigger than start date
	if (start_date > end_date) {
		$('.bs-toast').removeClass('bg-success')
		$('.bs-toast').addClass('bg-danger show')
		$('.toast-status').text('Alert')
		$('.toast-body').text('Tanggal Awal tidak boleh lebih besar dari Tanggal Akhir')
		setTimeout(function() {
			$('.bs-toast').removeClass('show')
		}, 10000)
		return;
	} else {
		startDate = start_date;
		endDate = end_date;
		// Destroy table
		if ($.fn.DataTable.isDataTable('#salesReportTable')) {
			$('#salesReportTable').DataTable().destroy();
		}
		getSalesReport(start_date, end_date)
	}
}

function resetFilterDate() {
	$("#start_date").val(null)
	$("#end_date").val(null)
	checkToggleDisabled()

	startDate = null;
	endDate = null;

	// Destroy table
	if ($.fn.DataTable.isDataTable('#salesReportTable')) {
		$('#salesReportTable').DataTable().destroy();
	}
	getSalesReport()
}

function exportExcel() {
	const urlExport = URL_Role + "/report/sale/export"
	
	if (startDate != null && endDate != null) {
		const data = {
			start_date: startDate,
			end_date: endDate
		}
		window.location.href = urlExport + "?" + $.param(data)
	} else {
		window.location.href = urlExport
	}
}