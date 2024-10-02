@extends('components.layout')
@section('title', 'Admin | Daftar Akun Gudang')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/datatable-bs4.css') }}">
  <style>
    .hide {
      display: none;
    }
  </style>
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
          <h5 class="card-title">Daftar Akun Gudang</h5>
          <div class="d-flex align-items-center">
            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
              <i class="tf-icon bx bx-plus"></i>
              Tambah Akun Gudang
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="warehouse-table">
              <thead>
                <tr class="text-nowrap">
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>No Telp</th>
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

  {{-- Add Modal --}}
  <div class="modal fade" id="addWarehouseModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Akun Gudang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addWarehouseForm" autocomplete="off">
          <input type="hidden" name="role" id="role" value="warehouse">
          <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" id="email" name="email" class="form-control">
            </div>
            <div class="mb-3">
              <label for="no_telp" class="form-label">No Telp</label>
              <input type="text" id="no_telp" name="no_telp" class="form-control">
            </div>
            <div class="alert alert-info">
              <h5 class="alert-heading">Perhatian!</h5>
              <p>Untuk staff baru, login menggunakan password: "<strong>password</strong>". Tolong ubah password setelah login.</p>
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

  {{-- Edit Modal --}}
  <div class="modal fade" id="editModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Akun Gudang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateWarehouseForm" autocomplete="off">
          <div class="modal-body">
            <input type="hidden" id="userId" name="userId">
            <div class="mb-3">
              <label for="update_name" class="form-label">Nama</label>
              <input type="text" class="form-control" id="update_name" name="update_name" readonly>
            </div>
            <div class="mb-3">
              <label for="update_email" class="form-label">Email</label>
              <input type="email" class="form-control" id="update_email" name="update_email" readonly>
            </div>
            <div class="mb-3">
              <label for="update_role" class="form-label">Role</label>
              <select class="form-select" id="update_role" name="update_role">
                <option value="warehouse">Gudang</option>
                <option value="cashier">Kasir</option>
              </select>
            </div>
            <div class="mb-3 hide" id="select-store">
              <label for="store_id" class="form-label">Store</label>
              <select class="form-select" id="store_id" name="store_id">
                @foreach ($stores as $store)
                  <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Delete Modal --}}
  <div class="modal fade" id="deleteModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Akun Gudang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yaking ingin menghapus akun gudang ini?</p>
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
  const URL = "{{ url('') }}"
</script>
{{-- Form Validate --}}
<script src="{{ asset('js/jquery-validate.js') }}" ></script>
<script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>
<script src="{{ asset('/js/admin/warehouse/index.js') }}"></script> 
@endsection