@extends('components.layout')
@section('title', 'Admin | Daftar Permintaan Barang')

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
        <div class="card-header">
          <h5>Daftar Permrintaan Barang</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="productOutTable">
              <thead>
                <tr class="text-nowrap">
                  <th style="width: 5%;">No</th>
                  <th>No Permintaan</th>
                  <th>Toko</th>
                  <th>Dibuat Oleh</th>
                  <th>Status</th>
                  <th>Dibuat</th>
                  <th>Diubah</th>
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
  </div>
</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('/admin') }}"
</script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>

<script src="{{ asset('/js/warehouse/product-out/request.js') }}"></script>
@endsection