@extends('components.layout')
@section('title', 'Kasir | Tambah Transaksi')

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
    <div class="col-md-7 mb-3">
      <div class="card">
        <div class="card-body">
          <input type="text" class="form-control" id="product_code" name="product_code"
            placeholder="kode barang" autofocus oninput="this.value = this.value.toUpperCase()">

          <table class="table-responsive text-nowrap table">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Barang</th>
                <th class="text-center" style="width: 10%">Jml</th>
                <th class="text-center" style="width: 25%">Harga</th>
                <th class="text-center" style="width: 15%">Disc. Member</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="listCarts">
              
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-5 mb-3">
      <div class="card">
        <div class="card-body">
          <input type="hidden" id="grandTotal">
          <input type="hidden" id="subTotal">
          <input type="hidden" id="diskonValue">
          <div class="d-flex flex-column justify-content-end align-items-end">
            <span class="text-muted font-weight-bold">{{ $no_invoice }}</span>
            <span class="font-weight-bold grand_total" style="font-size: 30px">Rp. 0</span>
          </div>
          <hr class="my-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="font-weight-bold text-muted" style="font-size: 17px;">Sub Total</span>
            <span class="font-weight-bold text-danger subTotalBadge" style="font-size: 14px;">Rp. 0</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span class="font-weight-bold text-muted" style="font-size: 17px;">Diskon</span>
            <span class="font-weight-bold text-success" style="font-size: 14px;" id="diskonTrxLabel">Rp. 0</span>
          </div>
          <hr class="my-2">
          <div class="d-flex justify-content-between align-items-center">
            <span class="font-weight-bold text-muted" style="font-size: 17px;">Total</span>
            <span class="font-weight-bold text-primary grand_total" style="font-size: 14px;">Rp. 0</span>
          </div>
          <hr class="my-2">

          <div class="mb-3">
            <label for="customer" class="mb-1">Member <small class="text-muted">* Jika ada</small> </label>
            <select name="customer" id="customer" class="form-control" onchange="changeMember(this)">
              <option value="">Pilih member</option>
              @foreach ($members as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="row gap-2 mt-2">
            <button class="btn btn-secondary" id="cancelOrder">Batal</button>
            <button class="btn btn-primary btn-lg grand_total" id="processPaymentBtn" type="submit">Rp. 0</button>
          </div>
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

  {{-- Cancel Transaction Modal --}}
  <div class="modal fade" id="cancelTransactionModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Batalkan Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin membatalkan transaksi ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="button" class="btn btn-danger" id="confirmCancelTransactionBtn">Batalkan</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Cash Modal --}}
  <div class="modal fade" id="cashModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cashModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="cashForm" autocomplete="off">
          <div class="modal-body">
            <div class="form-group">
              <label for="cashAmount">Jumlah Uang</label>
              <input type="text" class="form-control" id="cashAmount" name="cashAmount" placeholder="Masukkan jumlah uang">
              <div class="form-text">
                Pastikan jumlah uang sudah benar
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="button" class="btn btn-primary" id="confirmCashBtn">Bayar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Print Receipt Modal --}}
  <div class="modal fade" id="printReceiptModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="printReceiptLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Ingin cetak struk?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" id="noPrintReceiptBtn">
            Tidak
          </button>
          <button type="button" class="btn btn-primary" id="printReceiptBtn">Cetak</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('/cashier') }}"
  const noInvoice = '{{ $no_invoice }}'
  const storeId = "{{ auth()->user()->store_id }}"
  const idUserInput = "{{ auth()->user()->id }}"
</script>
<script src="{{ asset('js/cashier/transaction/add.js') }}"></script>
@endsection