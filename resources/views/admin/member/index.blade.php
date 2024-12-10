@extends('components.layout')
@section('title', 'Admin | Daftar Member')

@section('css')
<link rel="stylesheet" href="{{ asset('css/datatable-bs4.css') }}">
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0"
    role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
    <div class="toast-header">
      <div class="me-auto fw-medium toast-status"></div>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body"></div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5>Daftar Member</h5>
          <div class="d-flex align-items-center">
            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
              <i class="tf-icon bx bx-plus"></i>
              Tambah Member Baru
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="memberTable">
              <thead>
                <tr class="text-nowrap">
                  <th>Telegram</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Add Member Modal --}}
  <div class="modal fade" id="addMemberModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Member</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addMemberForm" autocomplete="off" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="mb-3">
              <label for="phone" class="form-label">No Telegram <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text" id="phone-addon">+62</span>
                <input type="number" name="phone" id="phone" class="form-control" placeholder="81234567890" aria-label="Phone" aria-describedby="phone-addon">
              </div>
            </div>
            <div class="mb-3">
              <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
              <input type="number" id="nik" name="nik" class="form-control">
            </div>
            <div class="mb-3">
              <label for="member_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" id="member_name" name="member_name" class="form-control">
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="born_place" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" id="born_place" name="born_place" class="form-control">
              </div>
              <div class="col-md-6">
                <label for="born_date" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" id="born_date" name="born_date" class="form-control">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="blood_type" class="form-label">Gol. Darah</label>
                <select id="blood_type" name="blood_type" class="form-control">
                  <option value="">golongan darah</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="AB">AB</option>
                  <option value="O">O</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="religion" class="form-label">Agama <span class="text-danger">*</span></label>
                <select id="religion" name="religion" class="form-control">
                  <option value="">agama</option>
                  <option value="islam">Islam</option>
                  <option value="kristen">Kristen</option>
                  <option value="katolik">Katolik</option>
                  <option value="hindu">Hindu</option>
                  <option value="budha">Budha</option>
                  <option value="konghucu">Konghucu</option>
                  <option value="other">Lainnya</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="is_married" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                <select id="is_married" name="is_married" class="form-control">
                  <option value="0">Belum menikah</option>
                  <option value="1">Sudah menikah</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select id="gender" name="gender" class="form-control">
                  <option value="male">Laki-laki</option>
                  <option value="female">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label for="profession" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
              <input type="text" id="profession" name="profession" class="form-control">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
              <textarea name="address" id="address" rows="2" class="form-control"></textarea>
            </div>
            <div class="mb-3">
              <label for="ktp" class="form-label">Foto KTP <span class="text-danger">*</span></label>
              <input type="file" id="ktp" name="ktp" class="form-control" accept="image/*">
            </div>
            <div class="alert alert-info">
              <h5 class="alert-heading">Perhatian!</h5>
              <p>Untuk member baru, login menggunakan password: "<strong>password</strong>". Tolong ubah password setelah login.</p>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Show Ktp Modal --}}
  <div class="modal fade" id="showKtpModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showKtpModalTitle">Detail KTP</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div style="height: 250px; overflow: hidden;">
            <img class="img-fluid d-flex mx-auto rounded" src="{{ asset('/img/elements/4.jpg') }}" alt="Card image cap" id="KtpImage">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete Modal --}}
  <div class="modal fade" id="deleteModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Member</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yaking ingin menghapus member ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('/admin') }}"
</script>
{{-- Form Validate --}}
<script src="{{ asset('js/jquery-validate.js') }}" ></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>

<script src="{{ asset('/js/admin/member/index.js') }}"></script>
@endsection