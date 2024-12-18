class Functions {
    getRequest(process, url) {
        $.ajax({
            type: "get",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
            beforeSend: function() {
                $('.load-wrapper').removeClass('hide-loader')
            },
            success: function (response) {
                $('.load-wrapper').addClass('hide-loader')
                process.successData = response
            },
            error: function(err) {
                $('.load-wrapper').addClass('hide-loader')
                process.errorData = err
            }
        });
    }

    postRequest(process, url, data) {
        $.ajax({
            type: "post",
            url: url,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
            beforeSend: function() {
                $('.load-wrapper').removeClass('hide-loader')
            },
            success: function (response) {
                $('.load-wrapper').addClass('hide-loader')
                process.successData = response;
            },
            error: function(err) {
                $('.load-wrapper').addClass('hide-loader')
                process.errorData = err
            }
        });
    }

    uploadFile(url = null, data = null, method = null, process) {
        $.ajax({
            type: method,
            url: url,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
            data: data,
            beforeSend: function() {
                $('.load-wrapper').removeClass('hide-loader')
            },
            success: function (response) {
                $('.load-wrapper').addClass('hide-loader')
                $('.bs-toast').removeClass('bg-danger')
                $('.bs-toast').addClass('bg-success show')
                $('.toast-status').text('Berhasil')
                $('.toast-body').text(response.message)
                process.successData = response
            },
            error: function(err) {
                $('.load-wrapper').addClass('hide-loader')
                if(err.status == 413) {
                    $('.bs-toast').removeClass('bg-success')
                    $('.bs-toast').addClass('bg-danger show')
                    $('.toast-status').text('Gagal')
                    $('.toast-body').text(err.responseText)
                } else {
                    $('.bs-toast').removeClass('bg-success')
                    $('.bs-toast').addClass('bg-danger show')
                    $('.toast-status').text('Gagal')
                    $('.toast-body').text(err.responseJSON.message)
                }
            }
        });
    }

    requestDetail(process, url, data = null) {
        $.ajax({
            type: "get",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
            data: data,
            beforeSend: function() {
                $('.load-wrapper').removeClass('hide-loader')
            },  
            success: function (response) {
                $('.load-wrapper').addClass('hide-loader')
                process.successData = response
            },
            error: function(err) {
                $('.load-wrapper').addClass('hide-loader')
                process.errorData = err
            }
        });
    }

    putRequest(process, url, data) {
        $.ajax({
            type: "put",
            url: url,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
            beforeSend: function() {
                $('.load-wrapper').removeClass('hide-loader')
            },
            success: function (response) {
                $('.load-wrapper').addClass('hide-loader')
                process.successData = response;
            },
            error: function(err) {
                $('.load-wrapper').addClass('hide-loader')
                process.errorData = err
            }
        });
    }

    httpRequest(url = null, data = null, method = null) {
        $.ajax({
            type: method,
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
            data: data,
            beforeSend: function() {
                $('.load-wrapper').removeClass('hide-loader')
            },
            success: function (response) {
                $('.load-wrapper').addClass('hide-loader')
                $('.bs-toast').removeClass('bg-danger')
                $('.bs-toast').addClass('bg-success show')
                $('.toast-status').text('Berhasil')
                $('.toast-body').text(response.message)
                setTimeout(function() {
                    $('.bs-toast').removeClass('show')
                }, 5000)
            },
            error: function(err) {
                $('.load-wrapper').addClass('hide-loader')
                $('.bs-toast').removeClass('bg-success')
                $('.bs-toast').addClass('bg-danger show')
                $('.toast-status').text('Gagal')
                $('.toast-body').text(err.responseJSON.message)
                setTimeout(function() {
                    $('.bs-toast').removeClass('show')
                }, 5000)
            }
        });
    }

    tableResult(field = "#dataTables", url = "", columns = []) {
        $(field).DataTable({
            processing: true,
            serverSide: true,
            ajax: url, // URL ke method getAll di controller
            columns: columns,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Menampilkan _PAGE_ dari _PAGES_ halaman",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)"
            }
        });
    }

    deleteData(url) {
        $.ajax({
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization' : "Bearer " + sessionStorage.getItem('token')
            },
            url: url,
            beforeSend: function() {
                $('.load-wrapper').removeClass('hide-loader')
            },
            success: function(response) {
                $('.load-wrapper').addClass('hide-loader')
                $('.bs-toast').removeClass('bg-danger')
                $('.bs-toast').addClass('bg-success show')
                $('.toast-status').text('Berhasil')
                $('.toast-body').text(response.message)
                setTimeout(function() {
                    $('.bs-toast').removeClass('show')
                }, 5000)
            },
            error: function(err) {
                $('.load-wrapper').addClass('hide-loader')
                $('.bs-toast').removeClass('bg-success')
                $('.bs-toast').addClass('bg-danger show')
                $('.toast-status').text('Gagal')
                console.log(err);
                $('.toast-body').text(err.responseJSON.message)
                
                setTimeout(function() {
                    $('.bs-toast').removeClass('show')
                }, 5000)
            }
        })
    }

    formatRupiah(value) {
        var number_string = value.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah ? 'Rp. ' + rupiah : '';
    }

    formatNumber(value) {
        var number_string = value.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
}