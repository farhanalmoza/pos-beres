@extends('components.layout')
@section('title', 'Kasir | Riwayat Permintaan Barang')

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
          <div class="">
            <h5 class="card-title">Permintaan Barang <span class="badge bg-primary">{{ $productRequest->request_number }}</span></h5>
            <div class="">
              @if ($productRequest->status == 'requested')
                <span class="badge bg-success">Diajukan</span>
              @elseif ($productRequest->status == 'done')
                <span class="badge bg-primary">Selesai</span>
              @elseif ($productRequest->status == 'customized')
                <span class="badge bg-warning">Disesuaikan</span>
              @endif
            </div>
          </div>
          <div class="">
            <a href="{{ route('cashier.product-request.history') }}" class="btn btn-secondary">
              Kembali
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="productRequestHistoryTable">
              <thead>
                <tr class="text-nowrap">
                  <th style="width: 5%;">No</th>
                  <th style="width: 20%">Kode Barang</th>
                  <th>Nama Barang</th>
                  <th style="width: 5%;">Jumlah</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($items as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->code }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td style="direction: rtl">{{ $item->quantity }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection