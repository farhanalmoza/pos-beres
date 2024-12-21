@extends('components.layout')
@section('title', 'Gudang | Invoice Pengiriman Barang')

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
					<h5>Pengiriman Barang <span class="badge bg-primary">{{ $productOut->no_invoice }}</span></h5>
					<a href="#">
						<button class="btn btn-sm btn-danger">Kembali</button>
					</a>
				</div>
				<div class="card-body">
					<div class="row d-flex justify-content-between">
						<div class="col-md-4 d-flex justify-content-start align-items-start flex-column">
							<span class="font-weight-bold text-uppercase text-primary">Gudang</span>
							<span class="text-muted">No Invoice: {{ $productOut->no_invoice }}</span>
							<span class="text-muted">Dibuat oleh : {{ $productOut->createdBy->name }}</span> 
							<span class="text-muted">Tanggal : {{ $productOut->created_at->format('d-m-Y H:i:s') }}</span>
						</div>
						<div class="col-md-4 d-flex align-items-end flex-column" id="d-desktop">
							<span class="font-weight-bold text-uppercase text-primary">{{ $productOut->store->name }}</span>
							<span class="text-muted no_invoice">{{ $productOut->store->address }}</span>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-sm">
							<thead>
								<tr>
									<th class="text-center" style="width: 5%">No</th>
									<th class="text-center">Kode Barang</th>
									<th class="text-center">Nama Barang</th>
									<th class="text-center" style="width: 5%">Jml</th>
									<th class="text-center" style="width: 15%">Harga</th>
									<th class="text-center" style="width: 15%">Total</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($productOut->carts as $item) 
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $item->product->code }}</td>
										<td>{{ $item->product->name }}</td>
										<td style="direction: rtl">{{ $item->quantity }}</td>
										<td style="direction: rtl">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
										<td style="direction: rtl">Rp. {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="row justify-content-end">
						<div class="col-md-5">
							<table class="table table-sm table-borderless">
								<tr>
									<th style="">Subtotal</th>
									<td style=" direction: rtl;" id="subTotal">Rp. {{ number_format($productOut->total_item, 0, ',', '.') }}</td>
								</tr>
								<tr>
									<th style="">PPN</th>
									<td style=" direction: rtl;" id="ppnValue">Rp. {{ number_format($productOut->ppn, 0, ',', '.') }}</td>
								</tr>
								<tr>
									<th style="">Grand Total</th>
									<td style=" direction: rtl;" id="ppnValue">Rp. {{ number_format($productOut->total, 0, ',', '.') }}</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="d-flex justify-content-end mt-2">
						<a href="#" class="btn btn-primary btn-sm">Cetak pdf</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('/warehouse') }}"
</script>
<script src="{{ asset('/js/warehouse/product-out/invoice.js') }}"></script>
@endsection