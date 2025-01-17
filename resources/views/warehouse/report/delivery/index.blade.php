@extends('components.layout')
@section('title', 'Gudang | Laporan Pengiriman Gudang')

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

  <div class="card mb-3">
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <label for="start_date">Tanggal Awal</label>
          <input class="form-control" type="date" id="start_date" onchange="checkToggleDisabled()">
        </div>
        <div class="col-md-3">
          <label for="end_data">Tanggal Akhir</label>
          <input class="form-control" type="date" id="end_date" onchange="checkToggleDisabled()">
        </div>

        <div class="col-md-3">
          <button type="submit" class="btn btn-primary" id="filterDateBtn" disabled onclick="submitFilterDate()">Cari</button>
          <button type="button" class="btn btn-outline-danger" id="resetDateBtn" onclick="resetFilterDate()">Reset</button>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between">
      <h5 class="card-title">Laporan Pengiriman</h5>
      <div class="btn-group">
        <button type="button" class="btn btn-sm btn-success" onclick="exportExcel()">Ekspor Excel</button>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-hover table-sm" id="deliveryReportTable">
        <thead>
          <tr>
            <th>No</th>
            <th>No Invoice</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Toko</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('warehouse') }}"
</script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>

<script src="{{ asset('js/warehouse/report/delivery.js') }}"></script>
@endsection