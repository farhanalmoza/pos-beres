$(document).ready(function() {
    getProduct();
})

function getProduct() {
    const urlListProducts = URL_Role + "/product/get-warehouse-products"
    const columns = [
        {data : 'code', name: 'code'},
        {data : 'name', name: 'name'},
        {data : 'quantity', name: 'quantity', className: 'text-end'},
        {data : 'price', name: 'price', className: 'text-end',
            render: function(data, type, row, meta) {
                return Functions.prototype.formatNumber(data)
            }
        },
    ]
    Functions.prototype.tableResult("#productTable", urlListProducts, columns)
}