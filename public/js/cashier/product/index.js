$(document).ready(function() {
    getProduct()
})

function getProduct() {
    const urlListProducts = URL_Role + "/product/get-all"
    const columns = [
        {data : 'product.code', name: 'code'},
        {data : 'product.name', name: 'name'},
        {data : 'quantity', name: 'quantity'},
        {data : 'product.price', name: 'price', 
            render: function(data, type, row, meta) {
                return data.toFixed(2)
            }
        },
    ]
    Functions.prototype.tableResult("#productTable", urlListProducts, columns)
}