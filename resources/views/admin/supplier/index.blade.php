@extends('components.layout')
@section('title', 'Admin | Daftar Supplier')

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
    <div class="col-md-12 mb-3">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title">Daftar Supplier</h5>
          <div class="d-flex align-items-center">
            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
              <i class="tf-icon bx bx-plus"></i>
              Tambah Supplier
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="supplierTable">
              <thead>
                <tr class="text-nowrap">
                  <th>Supplier</th>
                  <th>Penanggungjawab</th>
                  <th>No Telepon</th>
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
  <div class="modal fade" id="addSupplierModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addSupplierForm" autocomplete="off">
          <div class="modal-body">
            <div class="mb-3">
              <label for="supplier_name" class="form-label">Nama</label>
              <input type="text" id="supplier_name" name="supplier_name" class="form-control">
            </div>
            <div class="mb-3">
              <label for="person_responsible" class="form-label">Penanggung Jawab</label>
              <input type="text" id="person_responsible" name="person_responsible" class="form-control">
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">No Telepon</label>
              <input type="text" id="phone" name="phone" class="form-control">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Alamat</label>
							<textarea id="address" name="address" class="form-control" rows="3"></textarea>
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
          <h5 class="modal-title">Edit Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateSupplierForm" autocomplete="off">
          <div class="modal-body">
            <input type="hidden" name="id" id="id_supplier">
            <div class="mb-3">
							<label for="update_supplier_name" class="form-label">Nama</label>
							<input type="text" id="update_supplier_name" name="update_supplier_name" class="form-control">
						</div>
						<div class="mb-3">
							<label for="update_person_responsible" class="form-label">Penanggung Jawab</label>
							<input type="text" id="update_person_responsible" name="update_person_responsible" class="form-control">
						</div>
						<div class="mb-3">
							<label for="update_phone" class="form-label">No Telepon</label>
							<input type="text" id="update_phone" name="update_phone" class="form-control">
						</div>
						<div class="mb-3">
							<label for="update_address" class="form-label">Alamat</label>
							<textarea id="update_address" name="update_address" class="form-control" rows="3"></textarea>
						</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" class="btn btn-primary" id="updateProductBtn">Simpan</button>
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
          <h5 class="modal-title">Hapus Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yaking ingin menghapus supplier ini?</p>
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
<script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>

<script src="{{ asset('/js/supplier/index.js') }}"></script>
@endsection