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
                return data.toFixed(2)
            }
        },
    ]
    Functions.prototype.tableResult("#productTable", urlListProducts, columns)
}