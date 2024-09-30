@extends('components.layout')
@section('title', 'Admin | Daftar Barang Keluar')

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
          <h5 class="card-title">Daftar Barang Keluar</h5>
          <div class="d-flex align-items-center">
            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductOutModal">
              <i class="tf-icon bx bx-plus"></i>
              Restok Barang Toko
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="product-out-table" width="100%">
              <thead>
                <tr class="text-nowrap">
                  <th>No.</th>
                  <th>Nama Barang</th>
                  <th>Dikirim ke</th>
                  <th>Jumlah</th>
                  <th>Tanggal Kirim</th>
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
  <div class="modal fade" id="addProductOutModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Kirim Barang ke Toko</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addProductOutForm" autocomplete="off">
          <div class="modal-body">
            <div class="mb-3">
              <label for="store_id" class="form-label">Toko</label>
              <select name="store_id" id="store_id" class="form-control">
                @foreach ($stores as $store)
                  <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="product_id" class="form-label">Barang</label>
              <select name="product_id" id="product_id" class="form-control">
                @foreach ($products as $product)
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="quantity" class="form-label">Jumlah</label>
              <input type="text" id="quantity" name="quantity" class="form-control">
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
<script src="{{ asset('/js/product-out/index.js') }}"></script>
@endsection