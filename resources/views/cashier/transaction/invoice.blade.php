@extends('components.layout')
@section('title', 'Kasir | Detail Transaksi')

@section('css')
	<style>
		@media only screen and (max-width: 660px) {
			#d-desktop {
				justify-content: start !important;
				align-items: flex-start !important;
				margin-top: 20px;
			}
			#keterangan {
				text-align: left !important;
			}
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
					<h5>Detail Transaksi <span class="badge bg-primary">{{ $invoice->no_invoice }}</span></h5>
					<a href="#">
						<button class="btn btn-sm btn-danger">Kembali</button>
					</a>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 d-flex justify-content-start align-items-start flex-column">
							<span class="font-weight-bold text-uppercase text-primary">Toko</span>
							<span class="text-muted">{{ $store->name }}</span>
							<span class="text-muted">Kasir : {{ $invoice->createdBy->name }}</span> 
							{{-- <span class="text-muted">No Telp</span> --}}
							<span class="text-muted">{{ $store->address }}</span>
						</div>
						<div class="col-md-6 d-flex justify-content-end align-items-end flex-column" id="d-desktop">
							<span class="font-weight-bold text-uppercase text-primary">Transaksi</span>
							<span class="text-muted no_invoice">{{ $invoice->no_invoice }}</span>
							<span class="text-muted" id="tgl_transaksi">{{ $invoice->created_at->format('d-m-Y H:i:s') }}</span>
							<span class="text-muted text-right" id="keterangan">{{ $invoice->notes ? $invoice->notes : '-' }}</span>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-borderless table-striped">
							<thead>
								<tr>
									<th style="width: 5%">No</th>
									<th>Barang</th>
									<th style="width: 8%">Jml</th>
									<th style="width: 15%">Harga</th>
									<th style="width: 15%">Diskon</th>
									<th style="width: 15%">Total</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($items as $item) 
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $item->product->name }}</td>
										<td style="direction: rtl">{{ $item->quantity }}</td>
										<td style="direction: rtl">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
										<td style="direction: rtl">RP. {{ number_format($item->product_discount, 0, ',', '.') }}</td>
										<td style="direction: rtl">Rp. {{ number_format(($item->price - $item->product_discount) * $item->quantity, 0, ',', '.') }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="row justify-content-end">
						<div class="col-md-5">
							<table class="table table-clear table-borderless">
								<tr>
									<th style="padding: 0 1.25rem">Total Item</th>
									<td style="padding: 0 1.25rem; direction: rtl;" id="subTotal">Rp. {{ number_format($invoice->total_item, 0, ',', '.') }}</td>
								</tr>
								<tr>
									<th style="padding: 0 1.25rem">Diskon</th>
									<td style="padding: 0 1.25rem; direction: rtl;" id="diskonTrx">Rp. {{ number_format($invoice->transaction_discount, 0, ',', '.') }}</td>
								</tr>
								<tr>
									<th style="padding: 0 1.25rem">PPN</th>
									<td style="padding: 0 1.25rem; direction: rtl;" id="ppnValue">Rp. {{ number_format($invoice->ppn, 0, ',', '.') }}</td>
								</tr>
								<tr>
									<th style="padding: 0 1.25rem">Total Belanja</th>
									<td style="padding: 0 1.25rem; direction: rtl;" id="ppnValue">Rp. {{ number_format($invoice->total, 0, ',', '.') }}</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="d-flex justify-content-end mt-2">
						{{-- <a href="{{ route('printPdfInvoice') }}?id={{ $id }}" class="btn btn-primary btn-sm">Cetak pdf</a> --}}
						<a href="{{ route('cashier.transaction.download-invoice', $invoice->id) }}" class="btn btn-primary btn-sm">Cetak pdf</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('/cashier') }}"
</script>
<script src="{{ asset('/js/cashier/transaction/invoice.js') }}"></script>
@endsection