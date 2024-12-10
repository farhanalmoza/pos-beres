@extends('components.layout')
@section('title', 'Admin | Daftar Barang')

@section('css')
<link rel="stylesheet" href="{{ asset('css/datatable-bs4.css') }}">
{{-- Print barcode --}}
<link rel="stylesheet" href="{{ asset('css/print-barcode.css') }}">
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
    <div class="col-md-8 mb-3">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title">Daftar Barang</h5>
          <div class="d-flex align-items-center">
            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
              <i class="tf-icon bx bx-plus"></i>
              Tambah Barang Baru
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="productTable">
              <thead>
                <tr class="text-nowrap">
                  <th>Kode</th>
                  <th>Barang</th>
                  <th>Stok</th>
                  <th>Hrg Gudang</th>
                  <th>Hrg Toko</th>
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

    <div class="col-md-4 mb-3">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5>Detail Barang</h5>
          <button type="button" class="btn btn-primary" id="printBarcodeBtn">Print barcode</button>
        </div>
        <div class="card-body">
          <div class="mb-2">
            <label for="product_code" class="form-label">Kode Barang</label>
            <input type="text" id="product_code" class="form-control" disabled>
          </div>
          <div class="mb-2">
            <label for="product_name" class="form-label">Nama Barang</label>
            <input type="text" id="product_name" class="form-control" disabled>
          </div>
          <div class="mb-2">
            <label for="product_category" class="form-label">Kategori Barang</label>
            <input type="text" id="product_category" class="form-control" disabled>
          </div>
          <div class="mb-2">
            <label for="display_warehouse_price" class="form-label">Harga Gudang</label>
            <input type="text" id="display_warehouse_price" class="form-control" disabled>
          </div>
          <div class="mb-2">
            <label for="product_price" class="form-label">Harga Toko</label>
            <input type="text" id="product_price" class="form-control" disabled>
          </div>
          <div class="mb-2">
            <label for="product_stock" class="form-label">Stok</label>
            <input type="text" id="product_stock" class="form-control" disabled>
          </div>
          <div class="mb-2" id="barcode">
            <svg id="barcodeSvg"></svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Add Modal --}}
  <div class="modal fade" id="addProductModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addProductForm" autocomplete="off">
          <div class="modal-body">
            <div class="mb-3">
              <label for="add_product_code" class="form-label">Kode Barang</label>
              <input type="text" id="add_product_code" name="add_product_code" class="form-control">
            </div>
            <div class="mb-3">
              <label for="add_product_name" class="form-label">Nama Barang</label>
              <input type="text" id="add_product_name" name="add_product_name" class="form-control">
            </div>
            <div class="mb-3">
              <label for="product_category_id" class="form-label">Kategori Barang</label>
              <select id="product_category_id" name="product_category_id" class="form-control">
                <option value="">Pilih Kategori Barang</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="warehouse_price" class="form-label">Harga Gudang</label>
              <input type="number" id="warehouse_price" name="warehouse_price" class="form-control">
            </div>
            <div class="mb-3">
              <label for="add_product_price" class="form-label">Harga Toko</label>
              <input type="number" id="add_product_price" name="add_product_price" class="form-control">
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
          <h5 class="modal-title">Edit Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateProductForm" autocomplete="off">
          <div class="modal-body">
            <input type="hidden" name="id" id="id_product">
            <div class="mb-3">
              <label for="update_code" class="form-label">Kode Barang</label>
              <input type="text" id="update_code" name="update_code" class="form-control">
              <div class="form-text">Kode Barang harus unik</div>
            </div>
            <div class="mb-3">
              <label for="update_name" class="form-label">Nama Barang</label>
              <input type="text" id="update_name" name="update_name" class="form-control">
            </div>
            <div class="mb-3">
              <label for="update_category_id" class="form-label">Kategori Barang</label>
              <select id="update_category_id" name="update_category_id" class="form-control">
                <option value="">Pilih Kategori Barang</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="update_warehouse_price" class="form-label">Harga Gudang</label>
              <input type="number" id="update_warehouse_price" name="update_warehouse_price" class="form-control">
            </div>
            <div class="mb-3">
              <label for="update_price" class="form-label">Harga Jual</label>
              <input type="number" id="update_price" name="update_price" class="form-control">
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
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Div yang hanya muncul saat cetak -->
<div id="print-barcodes">
  <label for="product_stock" class="form-label">Stok</label>
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
{{-- JS Barcode --}}
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="{{ asset('/js/product/index.js') }}"></script>
@endsection