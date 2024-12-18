$(function () {
    getCarts.loadData = noInvoice;
    $('#sendProductBtn').on('click', processSendProduct)
    addToCart();
});
$(document).ready(function() {
    deleteCart();
});

var total = 0;
var isPPN = false;
var ppn = 0;
var grandTotal = 0;

function addToCart() {
    $("#addProductForm").validate({
        rules: {
            product: {
                required: true,
            },
            quantity: {
                required: true,
                number: true,
            },
        },
        messages: {
            product: {
                required: "Barang tidak boleh kosong",
            },
            quantity: {
                required: "Jumlah tidak boleh kosong",
                number: "Jumlah harus berupa angka",
            },
        },
		errorClass: "is-invalid",
		validClass: "is-valid",
		errorElement: "small",
        submitHandler: function (form, e) {
            e.preventDefault();
            const data = {
                noInvoice: noInvoice,
                product: $("#product").val(),
                quantity: $("#quantity").val(),
            };
            Functions.prototype.httpRequest(URL_Role + "/product-out/add-to-cart", data, 'post');
            $('#product').val('');
            $('#quantity').val('');
            getCarts.loadData = noInvoice;
        },
    });
}

const getCarts = {
    set loadData(data) {
        const url = URL_Role + "/product-out/get-carts/" + data;
        Functions.prototype.requestDetail(getCarts, url);
    },
    set successData(response) {
        $("#cartProductTable tbody").empty();
        if (response.length > 0) {
            total = 0;
            ppn = 0;
            grandTotal = 0;
            response.map((result, i) => {
                total += result.product.price * result.quantity;
                $("#cartProductTable tbody").append(`
                    <tr>
                        <td>${i + 1}</td>
                        <td>${result.product.code}</td>
                        <td>${result.product.name}</td>
                        <td class="text-end">${result.quantity}</td>
                        <td class="text-end">${Functions.prototype.formatNumber(
                            result.product.price
                        )}</td>
                        <td class="text-end">${Functions.prototype.formatNumber(
                            result.product.price * result.quantity
                        )}</td>
                        <td>
                            <button class="btn btn-danger btn-xs delete" data-id="${
                                result.id
                            }" data-bs-toggle="modal" data-bs-target="#deleteCartModal"><i class='bx bx-x'></i></button>
                        </td>
                    </tr>
                `);
            });
            updateTotal();
        } else {
            $("#cartProductTable tbody").append(`
                <tr>
                    <td colspan="8" align="center">Keranjang masih kosong</td>
                </tr>
            `);
        }
    },
    set errorData(err) {
        $(".bs-toast").removeClass("bg-success");
        $(".bs-toast").addClass("bg-danger show");
        $(".toast-status").text("Gagal");
        $(".toast-body").text(err.responseJSON.message);
    },
};

$('#ppnCheck').on('change', function() {
    if ($(this).is(':checked')) {
        isPPN = true;        
    } else {
        isPPN = false;
    }
    updateTotal();
})

function updateTotal() {
    if (isPPN) {
        ppn = total * ppnPercentage / 100;
    }
    
    grandTotal = total + ppn;
    $("#total").text(Functions.prototype.formatNumber(total));
    $("#ppn").text(Functions.prototype.formatNumber(ppn));
    $("#grandTotal").text(Functions.prototype.formatNumber(grandTotal));
}

function deleteCart() {
    $('#listCarts').on('click', '.delete', function (e) {
        e.preventDefault();
        const id = $(this).data('id');

        $('#confirmDeleteCartBtn').on('click', function (e) {
            e.preventDefault();
            
            const url = URL_Role + "/product-out/delete-cart/" + id;
            Functions.prototype.deleteData(url);
            $('#deleteCartModal').modal('hide');
            getCarts.loadData = noInvoice;
        });
    });
}

function processSendProduct(e) {
    e.preventDefault();
    
    // check store
    if($('#store').val() == '') {
        $('.bs-toast').removeClass('bg-success')
        $('.bs-toast').addClass('bg-danger show')
        $('.toast-status').text('Gagal')
        $('.toast-body').text('Silakan pilih toko dulu')
        setTimeout(function() {
            $('.bs-toast').removeClass('show')
        }, 5000)
        return;
    }

    if (grandTotal < 1) {
        $('.bs-toast').removeClass('bg-success')
        $('.bs-toast').addClass('bg-danger show')
        $('.toast-status').text('Gagal')
        $('.toast-body').text('Isi barang terlebih dulu')
        setTimeout(function() {
        $('.bs-toast').removeClass('show')
        }, 5000)
    } else {
        $("#confirmSendProductModal").modal('show')

        $('#confirmSendBtn').on('click', function(e) {
            e.preventDefault()
            const data = {
                no_invoice: noInvoice,
                store_id : $('#store').val(),
                total_item: total,
                ppn: ppn,
                total: grandTotal
            }
            Functions.prototype.httpRequest(URL_Role + '/product-out/send', data, 'post')
            setTimeout(() => {
                window.location.reload()
            }, 500);
        })
    }
}