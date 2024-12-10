@extends('components.layout')
@section('title', 'Admin | Pajak')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5>Pajak</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.tax.update') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-md">
                <div class="mb-3 row">
                  <label for="tax" class="col-sm-2 col-form-label">PPN <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="number" name="tax" id="tax" class="form-control" value="{{ $tax['tax'] }}">
                      <span class="input-group-text">%</span>
                    </div>
                    @error('tax')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection