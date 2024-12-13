@extends('components.layout')
@section('title', 'Kasir | Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-3 mb-4">
      <div class="card card-border-shadow-primary">
        <div class="card-body text-end">
          <h5 class="card-title text-danger">Rp. {{ number_format($data['expensesThisMonth']) }}</h5>
          <div class="card-subtitle text-muted mb-3">Pengeluaran Bulan Ini</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="card card-border-shadow-primary">
        <div class="card-body text-end">
          <h5 class="card-title @if($data['profitThisMonth'] > 0) text-success @else text-danger @endif">
            Rp. {{ number_format($data['profitThisMonth']) }}
          </h5>
          <div class="card-subtitle text-muted mb-3">Keuntungan Bulan Ini</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="card card-border-shadow-primary">
        <div class="card-body text-end">
          <h5 class="card-title">{{ $data['transactionsThisMonth'] }}</h5>
          <div class="card-subtitle text-muted mb-3">Transaksi Bulan Ini</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection