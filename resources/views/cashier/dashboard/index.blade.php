@extends('components.layout')
@section('title', 'Kasir | Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-3 mb-4">
      <div class="card card-border-shadow-primary">
        <div class="card-body text-end">
          <h5 class="card-title text-danger">Rp. {{ number_format($data['expensesThisMonth']) }}</h5>
          <div class="card-subtitle text-muted">Belanja Bulan Ini</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="card card-border-shadow-primary">
        <div class="card-body text-end">
          <h5 class="card-title text-success">
            Rp. {{ number_format($data['salesThisMonth']) }}
          </h5>
          <div class="card-subtitle text-muted">Pendapatan Bulan Ini</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="card card-border-shadow-primary">
        <div class="card-body text-end">
          <h5 class="card-title">{{ $data['transactionsThisMonth'] }}</h5>
          <div class="card-subtitle text-muted">Transaksi Bulan Ini</div>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Barang Terlaris</h5>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga</th>
                <th scope="col">Terjual</th>
              </tr>
            </thead>
            <tbody>
              @if (count($data['topProducts']) == 0)
                <tr>
                  <td colspan="4" class="text-center">Belum ada penjualan di bulan ini</td>
                </tr>
              @else
                @foreach ($data['topProducts'] as $product)
                  <tr>
                    <th>{{ $product->code }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->total_sold }}</td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Barang Tidak Laku</h5>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
              </tr>
            </thead>
            <tbody>
              @if (count($data['inactiveProducts']) == 0)
                <tr>
                  <td colspan="4" class="text-center">Data tidak ditemukan</td>
                </tr>
              @else
                @foreach ($data['inactiveProducts'] as $product)
                  <tr>
                    <th>{{ $product['code'] }}</th>
                    <td>{{ $product['name'] }}</td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection