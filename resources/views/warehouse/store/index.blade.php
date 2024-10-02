@extends('components.layout')
@section('title', 'Gudang | Daftar Toko')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/datatable-bs4.css') }}">
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title">Daftar Toko</h5>
          <div class="d-flex align-items-center">
            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStoreModal">
              <i class="tf-icon bx bx-plus"></i>
              Tambah Toko Baru
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="storeTable">
              <thead>
                <tr class="text-nowrap">
                  <th>No.</th>
                  <th>Nama Toko</th>
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

  {{-- Add Modal --}}
  <div class="modal fade" id="addStoreModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Toko</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addStoreForm" autocomplete="off">
          <div class="modal-body">
            <div class="mb-3">
              <label for="store_name" class="form-label">Nama Toko</label>
              <input type="text" id="store_name" name="store_name" class="form-control">
            </div>
            <div class="mb-3">
              <label for="store_address" class="form-label">Alamat</label>
              <textarea id="store_address" name="store_address" class="form-control" rows="3"></textarea>
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
          <h5 class="modal-title">Edit Toko</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateStoreForm" autocomplete="off">
          <div class="modal-body">
            <input type="hidden" name="id" id="id_store">
            <div class="mb-3">
              <label for="update_store_name" class="form-label">Nama Toko</label>
              <input type="text" id="update_store_name" name="update_store_name" class="form-control">
            </div>
            <div class="mb-3">
              <label for="update_store_address" class="form-label">Alamat</label>
              <textarea id="update_store_address" name="update_store_address" class="form-control" rows="3"></textarea>
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
          <h5 class="modal-title">Hapus Toko</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yaking ingin menghapus toko ini?</p>
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
  const URL_Role = "{{ url('/warehouse') }}"
</script>
{{-- Form Validate --}}
<script src="{{ asset('js/jquery-validate.js') }}" ></script>
<script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>
<script src="{{ asset('/js/store/index.js') }}"></script>
@endsection