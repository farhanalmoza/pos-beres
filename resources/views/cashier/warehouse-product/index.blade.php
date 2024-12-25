@extends('components.layout')
@section('title', 'Kasir | Daftar Barang di Gudang')

@section('css')
<link rel="stylesheet" href="{{ asset('css/datatable-bs4.css') }}">
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <h5 class="card-header">Daftar Barang di Gudang</h5>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table" id="productTable">
              <thead>
                <tr class="text-nowrap">
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Stok</th>
                  <th>Harga Jual</th>
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
</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('cashier') }}"
</script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>

<script src="{{ asset('js/cashier/warehouse-product/index.js') }}"></script>
@endsection