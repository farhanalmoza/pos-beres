@extends('components.layout')
@section('title', 'Admin | Kirim Barang Keluar')

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
          <div class="col-md-6 mb-3">
            <label for="store" class="form-label">Toko</label>
            <select id="store" class="form-select" name="store">
              <option value="">Pilih Toko</option>
              @foreach ($stores as $store)
                <option value="{{ $store->id }}">{{ $store->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" id="ppnCheck">
              <label class="form-check-label" for="ppnCheck">PPN</label>
            </div>
          </div>
          <form id="addProductForm">
            <div class="row">
              <div class="col-md-8">
                <div class="mb-3">
                  <label for="product" class="form-label">Barang</label>
                  <select id="product" class="form-select" name="product">
                    <option value="">Pilih Barang</option>
                    @foreach ($products as $product)
                      <option value="{{ $product->id }}">{{ $product->code . " - " . $product->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label for="quantity" class="form-label">Jumlah</label>
                  <input type="number" class="form-control" id="quantity" name="quantity">
                </div>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Tambah</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">{{ $noInvoice }}</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="cartProductTable" width="100%">
              <thead>
                <tr class="text-nowrap text-center">
                  <th style="width: 3%">No.</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Jml</th>
                  <th>Harga</th>
                  <th>Total</th>
                  <th style="width: 3%"></th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" id="listCarts">
              </tbody>
            </table>
          </div>

          <div class="row justify-content-end">
            <div class="col-md-5">
              <table class="table table-clear table-borderless">
                <tr>
                  <th style="padding: 0 1.25rem">Total</th>
                  <th style="padding: 0 1.25rem">: Rp.</th>
                  <td style="padding: 0 1.25rem" id="total" class="text-end">0</td>
                </tr>
                <tr>
                  <th style="padding: 0 1.25rem">PPN</th>
                  <th style="padding: 0 1.25rem">: Rp.</th>
                  <td style="padding: 0 1.25rem" id="ppn" class="text-end">0</td>
                </tr>
                <tr>
                  <th><strong>Grand Total</strong></th>
                  <th><strong>: Rp.</strong></th>
                  <td class="text-end"><strong id="grandTotal">0</strong></td>
                </tr>
              </table>
            </div>
          </div>

          <button class="btn btn-primary" id="sendProductBtn">Kirim</button>

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

  {{-- Confirmation Send Product Modal --}}
  <div class="modal fade" id="confirmSendProductModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Pengiriman</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Pastikan barang yang akan dikirim sudah benar</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="button" class="btn btn-primary" id="confirmSendBtn">Bayar</button>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('/admin') }}"
  const noInvoice = "{{ $noInvoice }}"
  const ppnPercentage = "{{ $ppnPercentage }}"
</script>
{{-- Form Validate --}}
<script src="{{ asset('js/jquery-validate.js') }}" ></script>
<script src="{{ asset('js/message_id.js') }}" integrity="sha512-Pb0klMWnom+fUBpq+8ncvrvozi/TDwdAbzbICN8EBoaVXZo00q6tgWk+6k6Pd+cezWRwyu2cB+XvVamRsbbtBA==" crossorigin="anonymous"></script>

<script src="{{ asset('/js/warehouse/product-out/add.js') }}"></script>
@endsection