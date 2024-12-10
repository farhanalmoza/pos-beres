$(document).ready(function() {
    getMembers();
    addMember();
    showKtpMember();
    deleteMember();
});

function getMembers() {  
    const urlListMembers = URL_Role + "/member/get-all"    
    const columns = [
        {data : 'whatsapp', name: 'whatsapp'},
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
            },
            ktp: {
                required: true,
            }
        },
        // custom message
        messages: {
            phone: {
                required: 'Nomor Telegram wajib diisi',
                minlength: 'Nomor Telegram minimal 11 angka',
                maxlength: 'Nomor Telegram maksimal 12 angka'
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
            },
            ktp: {
                required: 'Foto KTP wajib diisi',
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "small",
        submitHandler: function(form, e) {
            e.preventDefault()
            const urlPostAddMember = URL_Role + "/member"
            const formData = new FormData()
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

            const files = $('#ktp')[0].files
            formData.append('phone', data.phone)
            formData.append('nik', data.nik)
            formData.append('name', data.name)
            formData.append('born_place', data.born_place)
            formData.append('born_date', data.born_date)
            formData.append('gender', data.gender)
            formData.append('address', data.address)
            formData.append('blood_type', data.blood_type)
            formData.append('religion', data.religion)
            formData.append('is_married', data.is_married)
            formData.append('profession', data.profession)
            for (let i = 0; i < files.length; i++) {
                const element = files[i];
                formData.append('files[]', element)
            }
            Functions.prototype.uploadFile(urlPostAddMember, formData, 'post', postMember)
        }
    })

    const postMember = {
        set successData(response) {
            if(window.location.search != "") {
                const urlParams = new URLSearchParams(window.location.search)
                if(urlParams.get('redirect') != "") {
                    setTimeout(() => {
                        window.location.href = urlParams.get('redirect')
                    }, 1500);
                }
            } else {
                // hide modal
                $('#addMemberForm').trigger('reset')
                $('#addMemberModal').modal('hide')
                if ($.fn.DataTable.isDataTable('#memberTable')) {
                    $('#memberTable').DataTable().destroy();
                }
                getMembers()    
            }
        }
    }
}

function showKtpMember() {
    $('#memberTable').on('click', '.show-ktp', function(e) {
        e.preventDefault()
        const path = $(this).data('path');
        const id = $(this).data('id');
        $('#showKtpModalTitle').text('Detail KTP ' + id)
        $('#KtpImage').attr('src', path)
    })
}

function deleteMember() {
    $('#memberTable').on('click', '.delete', function(e) {
        e.preventDefault()
        const id = $(this).data('id');
        const urlDelete = URL_Role + '/member/delete/' + id;
        
        // Tangani klik tombol konfirmasi hapus di modal
        $('#confirmDeleteBtn').on('click', function(e) {
            e.preventDefault()
            Functions.prototype.deleteData(urlDelete)
            $('#deleteModal').modal('hide')
            if ($.fn.DataTable.isDataTable('#memberTable')) {
                $('#memberTable').DataTable().destroy();
            }
            getMembers()
        })
    })
}