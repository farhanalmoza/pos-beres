$(document).ready(function() {
    getPurchaseReport();
})

function getPurchaseReport(startDate = null, endDate = null) {
    var urlListPurchaseReport = URL_Role + "/warehouse/report/purchase/get-all"
    if (startDate && endDate) {
        urlListPurchaseReport += "?start_date=" + startDate + "&end_date=" + endDate
    }
    const columns = [
        {data : 'product_code_name', name: 'product'},
        {data : 'supplier.name', name: 'supplier'},
        {data : 'total', name: 'total', 
            render: function(data, type, row, meta) {
                return Functions.prototype.formatRupiah(data)
            }
        },
        {data : 'product.quantity', name: 'quantity'},
        {data : 'product.price', name: 'price', 
            render: function(data, type, row, meta) {
                return Functions.prototype.formatRupiah(data)
            }
        },
        {data : 'created_at', name: 'created_at', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#purchaseReportTable", urlListPurchaseReport, columns)
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
        // Destroy table
        if ($.fn.DataTable.isDataTable('#purchaseReportTable')) {
            $('#purchaseReportTable').DataTable().destroy();
        }
        getPurchaseReport(start_date, end_date)
    }
}

function resetFilterDate() {
    $("#start_date").val(null)
    $("#end_date").val(null)
    checkToggleDisabled()

    // Destroy table
    if ($.fn.DataTable.isDataTable('#purchaseReportTable')) {
        $('#purchaseReportTable').DataTable().destroy();
    }
    getPurchaseReport()
}