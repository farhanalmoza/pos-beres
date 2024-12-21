$(document).ready(function() {
  getProductOutList();
});

function getProductOutList() {
  const urlListProductOut = URL_Role + "/product-out/get-all"
  const columns = [
    {data : 'no_invoice', name: 'no_invoice'},
    {data : 'store.name', name: 'store.name'},
    {data : 'total', name: 'total',
      render: function (data, type, row) {
        return Functions.prototype.formatRupiah(data);
      }
    },
    {data : 'date', name: 'date'},
    {data : 'actions', name: 'actions', orderable : false, searchable : false },
  ]
  Functions.prototype.tableResult("#productOutTable", urlListProductOut, columns)
}