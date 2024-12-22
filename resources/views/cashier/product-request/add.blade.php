@extends('components.layout')
@section('title', 'Kasir | Tambah Permintaan Barang')

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
        <div class="card-body">
          <form id="addProductForm" autocomplete="off">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="product_id" class="form-label">Barang</label>
                  <select name="product_id" id="product_id" class="form-select">
                    <option value="">Pilih Barang</option>
                    @foreach ($products as $product)
                      <option value="{{ $product->id }}">{{ $product->code ." - ". $product->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="quanity" class="form-label">Jumlah</label>
                  <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Masukkan jumlah">
                </div>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary mb-3">Tambah</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-12 mb-3">
      <div class="card">
        <div class="card-header">
          <h5>No. Permintaan <span class="badge bg-primary">{{ $requestNumber }}</span></h5>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap mb-3">
            <table class="table">
              <thead>
                <tr class="text-nowrap text-center">
                  <th style="width: 5%;">No</th>
                  <th style="width: 20%">Kode Barang</th>
                  <th>Nama Barang</th>
                  <th style="width: 5%;">Jumlah</th>
                  <th style="width: 5%;">Aksi</th>
                </tr>
              </thead>
              <tbody id="productRequestList">

              </tbody>
            </table>
          </div>

          <button class="btn btn-primary" id="addProductRequestModalBtn" disabled data-bs-toggle="modal" data-bs-target="#addProductRequestModal">Ajukan</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete Modal --}}
  <div class="modal fade" id="deleteCartModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yaking ingin menghapus barang ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="button" class="btn btn-danger" id="confirmDeleteCartBtn">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Add Product Request Modal --}}
  <div class="modal fade" id="addProductRequestModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Permintaan Barang Akan Dikirimkan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Pastikan data barang sudah benar</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="button" class="btn btn-primary" id="addProductRequestBtn">Ajukan</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('cashier') }}"
  const requestNumber = "{{ $requestNumber }}"
</script>
{{-- Form Validate --}}
<script src="{{ asset('js/jquery-validate.js') }}" ></script>
<script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>

<script src="{{ asset('js/cashier/product-request/add.js') }}"></script>
@endsection