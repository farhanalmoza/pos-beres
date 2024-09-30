$(document).ready(function () {
    getStoreProducts();
});

function getStoreProducts() {
    const urlListStoreProducts = URL + "/admin/store/store-products/" + store_id
    const columns = [
        {data : 'product.code', name: 'product.code'},
        {data : 'product.name', name: 'product.name'},
        {data : 'quantity', name: 'quantity'},
        {data : 'product.price', name: 'product.price',
            render: function (data, type, row) {
                return Functions.prototype.formatRupiah(data);
            }
        },
    ]
    Functions.prototype.tableResult("#store-product-table", urlListStoreProducts, columns)
}