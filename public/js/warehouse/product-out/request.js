$(document).ready(function() {
  getRequestedProductList();
});

function getRequestedProductList() {
  const urlListProductOut = URL_Role + "/product-out/request/get-all"
  const columns = [
    {data : 'DT_RowIndex', name : 'DT_RowIndex', orderable : false, searchable : false },
    {data : 'request_number', name: 'request_number'},
    {data : 'store.name', name: 'store.name'},
    {data : 'created_by.name', name: 'created_by.name'},
    {data : 'status', name: 'status'},
    {data : 'created', name: 'created'},
    {data : 'updated', name: 'updated'},
    {data : 'actions', name: 'actions', orderable : false, searchable : false },
  ]
  Functions.prototype.tableResult("#productOutTable", urlListProductOut, columns)
}