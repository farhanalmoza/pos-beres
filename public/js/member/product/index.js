$(document).ready(function() {
    getProduct();
});

function getProduct() {
    const urlListProducts = URL_Role + "/product/get-all"
    const columns = [
        {data : 'code', name: 'code'},
        {data : 'name', name: 'name'},
        {data : 'price', name: 'price', 
            render: function(data, type, row, meta) {
                return Functions.prototype.formatRupiah(data)
            }
        },
        {data: 'discount', name: 'discount',
            render: function(data, type, row, meta) {
                return Functions.prototype.formatRupiah(data)
            }
        },
    ]
    Functions.prototype.tableResult("#productTable", urlListProducts, columns)
}