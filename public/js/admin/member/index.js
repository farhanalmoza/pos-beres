$(document).ready(function() {
    getMembers();
    addMember();
});

function getMembers() {  
    const urlListMembers = URL_Role + "/member/get-all"    
    const columns = [
        {data : 'phone', name: 'phone'},
        {data : 'nik', name: 'nik'},
        {data : 'name', name: 'name'},
        {data : 'address', name: 'address'},
        {data : 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    Functions.prototype.tableResult("#memberTable", urlListMembers, columns)
}

function addMember() {
    $('#addMemberForm').validate({
        rules: {
            phone: {
                required: true,
                minlength: 10,
                maxlength: 12,
            },
            nik: {
                required: true,
                minlength: 16,
                maxlength: 16,
            },
            member_name: {
                required: true
            },
            born_place: {
                required: true
            },
            born_date: {
                required: true
            },
            gender: {
                required: true
            },
            address: {
                required: true
            },
            religion: {
                required: true
            },
            is_married: {
                required: true
            },
            profession: {
                required: true
            }
        },
        // custom message
        messages: {
            phone: {
                required: 'Nomor WhatsApp wajib diisi',
                minlength: 'Nomor WhatsApp minimal 11 angka',
                maxlength: 'Nomor WhatsApp maksimal 12 angka'
            },
            nik: {
                required: 'NIK wajib diisi',
                minlength: 'NIK harus 16 angka',
                maxlength: 'NIK harus 16 angka'
            },
            member_name: {
                required: 'Nama Lengkap wajib diisi'
            },
            born_place: {
                required: 'Tempat Lahir wajib diisi'
            },
            born_date: {
                required: 'Tanggal Lahir wajib diisi'
            },
            gender: {
                required: 'Gol wajib diisi'
            },
            address: {
                required: 'Alamat wajib diisi'
            },
            religion: {
                required: 'Agama wajib diisi'
            },
            is_married: {
                required: 'Status Perkawinan wajib diisi'
            },
            profession: {
                required: 'Pekerjaan wajib diisi'
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const data = {
                phone : $('#phone').val(),
                nik : $('#nik').val(),
                name : $('#member_name').val(),
                born_place : $('#born_place').val(),
                born_date : $('#born_date').val(),
                gender : $('#gender').val(),
                address : $('#address').val(),
                blood_type : $('#blood_type').val(),
                religion : $('#religion').val(),
                is_married : $('#is_married').val(),
                profession : $('#profession').val()
            }
            Functions.prototype.httpRequest(URL_Role + '/member', data, 'post')
            // hide modal
            $('#addMemberModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#memberTable')) {
                $('#memberTable').DataTable().destroy();
            }
            getMembers()
        }
    })
}