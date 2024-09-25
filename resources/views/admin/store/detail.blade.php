@extends('components.layout')
@section('title', 'Admin | Detail Toko')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <h5 class="card-header">Detail Toko</h5>
        <div class="card-body">
          {{-- nama --}}
          <h2>{{ $store->name }}</h2>
          {{-- alamat --}}
          <p>{{ $store->address }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')

@endsection