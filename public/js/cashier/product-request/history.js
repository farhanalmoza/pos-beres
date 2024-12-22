$(document).ready(function() {
  getHistories();
});

function getHistories() {
  const url = URL_Role + "/product-request/history/get-all"
  const columns = [
    {data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
    {data : 'request_number', name: 'request_number'},
    {data : 'created_by.name', name: 'created_by.name'},
    {data : 'status', name: 'status'},
    {data : 'created', name: 'created'},
    {data : 'changed', name: 'changed'},
    {data : 'actions', name: 'actions', orderable : false, searchable : false },
  ]
  Functions.prototype.tableResult("#productRequestHistoryTable", url, columns)
}