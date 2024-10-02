@extends('components.layout')
@section('title', 'Gudang | Daftar Kategori Barang')

@section('css')
<link rel="stylesheet" href="{{ asset('css/datatable-bs4.css') }}">
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Toast -->
  <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 @if (session()->has('success')) bg-success show @endif"
    role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
    <div class="toast-header">
      <div class="me-auto fw-medium toast-status">
        @if (session()->has('success')) Berhasil @endif
        @if (session()->has('error')) Gagal @endif
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @if (session()->has('success'))
        {{ session('success') }}
      @endif
      @if (session()->has('error'))
        {{ session('error') }}
      @endif
    </div>
  </div>

  <div class="row">
    <div class="col-md-7 mb-3">
      <div class="card">
        <h5 class="card-header">Daftar Kategori Barang</h5>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="categoryTable">
              <thead>
                <tr class="text-nowrap">
                  <th>No.</th>
                  <th>Kategori Barang</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="card">
        <h5 class="card-header">Tambah Kategori Barang</h5>
        <div class="card-body">
          <form method="POST" action="{{ route('warehouse.product-category.store') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">Kategori Barang</label>
              <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
              {{-- error message --}}
              @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </form>
        </div>
      </div>
    </div>

  </div>


  {{-- Edit Modal --}}
  <div class="modal fade" id="editModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Kategori Modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateCategoryForm" autocomplete="off">
          <input type="hidden" name="id" id="id_category">
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="update_name" class="form-label">Kategori Barang</label>
                <input type="text" id="update_name" name="update_name" class="form-control" value="{{ old('update_name') }}">
              </div>
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
          <h5 class="modal-title">Hapus Kategori Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yaking ingin menghapus kategori barang ini?</p>
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
<script src="{{ asset('/js/product-category/index.js') }}"></script>
@endsection