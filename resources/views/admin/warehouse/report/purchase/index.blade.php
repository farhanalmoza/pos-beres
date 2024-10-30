@extends('components.layout')
@section('title', 'Admin | Laporan Pembelian Gudang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
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
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Barang 1</td>
            <td>100</td>
            <td>Rp. 100.000</td>
            <td>2020-01-01</td>
          </tr>
          <tr>
            <td>Barang 2</td>
            <td>200</td>
            <td>Rp. 200.000</td>
            <td>2020-01-02</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection