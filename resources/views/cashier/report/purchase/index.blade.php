@extends('components.layout')
@section('title', 'Kasir | Laporan Pembelian')

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
          <label for="">Hari</label>
          <input class="form-control" type="date" value="2024-10-30">
        </div>
        <div class="col-md-3">
          <label for="">Bulan</label>
          <input class="form-control" type="month" value="2024-06">
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between">
      <h5 class="card-title">Laporan Pembelian</h5>
      <div class="btn-group">
        <a href="#" class="btn btn-sm btn-success">Ekspor Excel</a>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-hover" id="purchaseReportTable">
        <thead>
          <tr>
            <th>Barang</th>
            <th>Jumlah</th>
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
  const URL_Role = "{{ url('/cashier') }}"
</script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>
<script src="{{ asset('js/cashier/report/purchase.js') }}"></script>
@endsection